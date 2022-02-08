<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fases_relaciones_contratos as fases_relaciones_contratos;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FasesRelacionesContratosController extends Controller
{
    //
    public function relacion_contrato_store(Request $request){
        $fases_relaciones_contratos = fases_relaciones_contratos::find($request->id_relacion_contratos);

        $fases_relaciones_contratosExiste = fases_relaciones_contratos::Where([['id_fase',$request->relacion_contratos_id_fase],
                                                                                ['id_contrato',$request->id_contrato],
                                                                                ['id','<>',$request->id_relacion_contratos]])->get();
        
        if ( $fases_relaciones_contratosExiste->count()>0)
        {
            $rules['contrato_1'] = 'required';
            $messages['contrato_1.required'] ='El contrato ya relacionado.';
            
            
            $this->validate($request, $rules, $messages);
        }

        if ($request->id_contrato ==null ) {
           
            $rules['ContratoNull'] = 'required';
            $messages['ContratoNull.required'] ='Debe seleccionar el contrato de la lista.';
            $this->validate($request, $rules, $messages);
        }

        if($fases_relaciones_contratos  == null )
        {
            if(isset($request->id_relacion_contratos_crear) &&  $request->id_relacion_contratos_crear == 1)
            {
             $fases_relaciones_contratos  = new fases_relaciones_contratos();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $fases_relaciones_contratos;
                return response()->json($respuesta);
            }
        }
       
         $fases_relaciones_contratos->id_fase = $request->relacion_contratos_id_fase;
         $fases_relaciones_contratos->id_contrato = $request->id_contrato;
         
         if($request->relacion_contratos_id_proyecto==0)
         {
             $fases_relaciones_contratos->created_by = Auth::user()->id;
         }else {
             $fases_relaciones_contratos->updated_by = Auth::user()->id;
         }
         $fases_relaciones_contratos->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $fases_relaciones_contratos;

          return response()->json($respuesta);



    }

    public function relacion_contrato_get_info(Request $request){
        
        $fases_relaciones_contratos = fases_relaciones_contratos::where('id_fase',$request->relacion_contratos_id_fase)
        ->join('contratos','contratos.id','=','fases_relaciones_contratos.id_contrato')
        ->leftjoin('contratos_fechas','contratos.id','=','contratos_fechas.id_contrato')
        ->leftjoin('contratos_terceros','contratos.id','=','contratos_terceros.id_contrato')
        ->leftjoin('terceros','terceros.id','=','contratos_terceros.id_terecero')
        ->leftjoin('rps','contratos.id','=','rps.id_contrato')
        ->select('fases_relaciones_contratos.id','contratos.numero_contrato','contratos.objeto_contrato','contratos.valor_contrato',
                'contratos.id as id_contrato','contratos.param_texto_estado_contrato','contratos_fechas.fecha_inicio',
                'contratos_fechas.fecha_terminacion','terceros.nombre','rps.id as id_rps')
       
        ->get();
       
        return response()->json($fases_relaciones_contratos);

    }

    public function delete_relacion_contrato(Request $request)
        {
           
            $relacion = fases_relaciones_contratos::find($request->id_relacion_contratos);
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
