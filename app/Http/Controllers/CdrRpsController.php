<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cdrs as cdr;
use App\Models\Cdr_rps as cdr_rp;
use Carbon\Carbon;
use App\Models\Contratos as contratos;
use App\Models\Contratos_terceros as contratos_tercero;
use App\Models\Terceros as terceros;
use Auth;
use Log;

class CdrRpsController extends Controller
{
    public function index($id)
    {
        $fecha = Carbon::now()->parse()->format('Y-m-d');
        $cdr = cdr::where('id',$id)->select('id','fecha_registro_cdr','objeto_cdr')->first();

        $contratos = contratos_tercero::leftJoin('terceros','terceros.id','=','contratos_terceros.id_terecero')
        ->leftJoin('contratos','contratos.id','=','contratos_terceros.id_contrato')
        ->select('contratos.id','contratos.numero_contrato','contratos.id_cdr')
        ->where('contratos.id_cdr',$id)
        ->whereNull('contratos_terceros.deleted_at')
        ->get();

        //dd($contratos);

        $terceros = contratos_tercero::leftJoin('terceros','terceros.id','=','contratos_terceros.id_terecero')
        ->leftJoin('contratos','contratos.id','=','contratos_terceros.id_contrato')
        ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.id')
        ->select('contratos_terceros.id_contrato','terceros.id','terceros.nombre','terceros.identificacion','contratos.numero_contrato','contratos.param_texto_clase_contrato','contratos_fechas.fecha_firma')
        ->get();

        $tercero_all = terceros::select('terceros.id','terceros.nombre','terceros.identificacion')
        ->get();

        return view('cdr.rps.index',compact('cdr','fecha','contratos','terceros','tercero_all'));
    }

    public function store(Request $request){

        $rules['tipo_ide'] = 'required';
        $messages['tipo_ide.required'] ='Favor seleccione un tipo de contrato.';

        if(($request->id_tercero_pre == null) && ($request->id_tercero_pro == null)){

            $rules['id_tercero2'] = 'required';
            $messages['id_tercero2.required'] ='Favor revisar el numero de identificación del tercero.';

        }

        $this->validate($request, $rules, $messages);

        $registro = cdr_rp::find($request->id_rp);

        if($registro == null )
        {
            if(isset($request->id_rp_crear) &&  $request->id_rp_crear==1)
            {
                $registro = new cdr_rp();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $registro;
                return response()->json($respuesta);
            }
        }

        $registro->id_cdr  = $request->id_cdr;
        $registro->tipo_ide  = $request->tipo_ide;
        $registro->id_contrato  = $request->id_contrato;
        $registro->fecha_registro_rp = $request->fecha_hidden;
        $registro->objeto_rp = $request->objeto_rp;
        if ($request->tipo_ide == 1) {
            $registro->id_tercero = $request->id_tercero_pre;
            $registro->documento_soporte = $request->Doc_soporte_H;
            $registro->fecha_documento_soporte = $request->fecha_doc_soporte_H;
            $registro->num_documento_soporte = $request->num_doc_soporte_H;
        }elseif($request->tipo_ide == 2){
            $registro->id_tercero = $request->id_tercero_pro;
            $registro->documento_soporte = $request->Doc_soporte;
            $registro->fecha_documento_soporte = $request->fecha_doc_soporte;
            $registro->num_documento_soporte = $request->num_doc_soporte;
        }

        if($request->id_rp==0)
        {
            $registro->created_by = Auth::user()->id;
        }else {
            $registro->updated_by = Auth::user()->id;
        }

        $registro->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la bitaora";
        $respuesta['objeto']= $registro;

        return response()->json($respuesta);
    }

    public function get_info_rp(Request $request){

        $rps = cdr_rp::leftJoin('terceros','terceros.id','=','rps.id_tercero')
        ->select('rps.*','terceros.nombre','terceros.identificacion')
        ->where('id_cdr',$request->id_cdr)->get();

        foreach ($rps as $rp) {

            $valor_rp = $rp->saldo_rp();
            $rp['saldo_rp'] = $valor_rp;
        }

        return response()->json($rps);
    }

    public function delete(Request $request)
    {
        $id_rp = cdr_rp::find($request->id_rp);
        if(count($id_rp->Rps_cuentas) == 0){

            $id_rp->deleted_by = Auth::user()->id;
            $id_rp->save();
    
            $informacionlog = 'Se ha eliminado la informacion del movimiento';
            $objetolog = [
                    'user_id' => Auth::user()->id,
                    'user_email' => Auth::user()->mail,
                    'Objeto Eliminado' => $id_rp,
                    ];
    
            Log::channel('database')->info(
                $informacionlog ,
                $objetolog
            );
    
            $id_rp->delete();
            $respuesta['status']="success";
            $respuesta['message']="Se ha eliminado registro";
            $respuesta['objeto']=$id_rp;
          
        }else{
            $respuesta['status']="error";
            $respuesta['message'] = "El RP número ".$id_rp->id." no puede ser eliminado portener relacionada cuentas activas.";
            $respuesta['objeto']= $id_rp;
           
        }
        return response()->json($respuesta);
    }


}
