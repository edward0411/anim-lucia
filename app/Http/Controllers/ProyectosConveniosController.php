<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto_convenios as proyecto_convenio;
use App\Models\Proyectos_contratos as proyecto_contrato;
use App\Models\Contratos_terceros as contrato_terceros;
use App\Models\Contratos_pads_convenios as pads_convenios;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use App\Models\Contratos as contratos;
use App\Models\fases_relaciones_contratos as fases_relaciones_contratos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProyectosConveniosController extends Controller
{
    public function convenios_store(Request $request){

        $rules = [
            'convenio' => 'required',
        ];
        $messages = [
            'convenio.required' => 'Favor seleccione un convenio.',
        ];

        $validar = proyecto_convenio::where('id_proyecto',$request->convenio_id_proyecto)
        ->where('id_contrato',$request->convenio)
        ->get();
       
        if(count($validar) > 0){

            $rules = [
                'convenio2' => 'required',
            ];
            $messages = [
                'convenio2.required' => 'La relación entre el proyecto y el convenio seleccionado ya existe.',
            ];

            $this->validate($request, $rules, $messages);
        }else{
            
            $relacion = new proyecto_convenio();
            $relacion->id_proyecto = $request->convenio_id_proyecto;
            $relacion->id_contrato = $request->convenio;
            $relacion->created_by = Auth::user()->id;
            $relacion->save();
            
            $respuesta['status']="success";
             $respuesta['message']="Se ha guardado la información de la caracteristica";
             $respuesta['objeto']= $relacion;


            $id_convenio = $request->convenio;

            $pads = pads_convenios::where('id_contrato_convenio',$id_convenio)
            ->select('id_contrato_pad')
            ->get();

            $id_pads = $pads->toArray();

            $array_contratos = [];

            foreach($id_pads as $pad){

                $id_pad = $pad['id_contrato_pad'];

                $patrimonios = patrimonio::where('id_contrato_pad',$id_pad)
                ->select('id')
                ->get();

                $id_patrimonios = $patrimonios->toArray();

                foreach($id_patrimonios as $id_pat){

                    $patri = $id_pat['id'];

                    $relacion = patrimonios_cuentas::where('id_patrimonio',$patri)
                    ->select('id')
                    ->get();

                    $cuentas = $relacion->toArray();

                    foreach($cuentas as $cuenta){

                        $id_cuenta = $cuenta['id'];

                        $consulta = cdr_cuentas::where('id_cuenta', $id_cuenta)
                        ->select('id_cdr')
                        ->get();

                        $cdrs = $consulta->toArray();

                        foreach($cdrs as $cdr){

                            $id_cdr = $cdr['id_cdr'];

                            $contratos = contratos::where('id_cdr',$id_cdr)
                            ->select('id')
                            ->get();

                            foreach($contratos as $contrato){

                                $id_contrato = $contrato['id'];

                                 array_push($array_contratos, $id_contrato); 
                            }
                        }
                    }
                }
            }
    
             $array = array_unique($array_contratos);

            foreach ($array as $value) {

                $relacion = new proyecto_contrato();
                $relacion->id_proyecto = $request->convenio_id_proyecto;
                $relacion->id_contrato = $value;
                $relacion->created_by = Auth::user()->id;
                $relacion->save();
               
            }
        }

        return response()->json($respuesta);

    }

    public function get_info_convenios(Request $request)
    { 
      $consulta =DB::select('call usp_consultar_convenios(?)',array($request->convenio_id_proyecto));
   
      return response()->json($consulta);
    }

    public function delete_convenios(Request $request)
    {
        $contratos = proyecto_convenio::join('contratos','proyectos_convenios.id_contrato','=','contratos.id')
        ->join('contratos as c','contratos.id','=','c.numero_convenio')
        ->join('fases','proyectos_convenios.id_proyecto','=','fases.id_proyecto')
        ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase') 
        ->where([['proyectos_convenios.id','=',$request->id_proyecto_convenio],
                ['c.id','=','fases_relaciones_contratos.id_contrato']])
        ->select('fases_relaciones_contratos.id')
        ->get();


        /*SELECT fases_relaciones_contratos.id 
        FROM proyectos_convenios 
        Inner join contratos on proyectos_convenios.id_contrato=contratos.id
        Inner join contratos as c on contratos.id=c.numero_convenio
        Inner join fases on proyectos_convenios.id_proyecto = fases.id_proyecto
        inner join fases_relaciones_contratos on fases.id = fases_relaciones_contratos.id_fase 
        WHERE proyectos_convenios.id=49
        and c.id = fases_relaciones_contratos.id_contrato*/


        for ($i=0; $i < count( $contratos); $i++) 
        {
            $id_contrato = $contratos[$i]->id;
            $fases_relaciones_contratos= fases_relaciones_contratos::find($id);

            $fases_relaciones_contratos = Auth::user()->id;
            $fases_relaciones_contratos->save();
        }

        $relacion = proyecto_convenio::find($request->id_proyecto_convenio);
        $relacion->deleted_by = Auth::user()->id;
        $relacion->save();

        $informacionlog = 'Se ha eliminado la informacion de la bitacora';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $relacion,
                ];

        Log::channel('database')->info(
            $informacionlog ,
            $objetolog
        );

        $relacion->delete();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$relacion;


        return response()->json($respuesta);
    }
}
