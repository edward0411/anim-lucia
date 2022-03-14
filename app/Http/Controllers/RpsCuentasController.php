<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cdrs as cdr;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\rps_movimientos as rp_movimientos;
use App\Models\Rps_cuentas as rp_cuenta;
use Carbon\Carbon;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use Illuminate\Support\Facades\DB;
use Auth;
use Log;

class RpsCuentasController extends Controller
{
    public function index(Request $request)
    {
        $rps = cdr_rp::leftJoin('terceros','terceros.id','=','rps.id_tercero')
        ->select('rps.*','terceros.nombre','identificacion')
        ->where('rps.id',$request->id)->first(); 

       $id_cdr = $rps->id_cdr;

       $cuentas = cdr_cuentas::leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
       ->select('cdrs_cuentas.id_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto')
       ->where('cdrs_cuentas.id_cdr',$id_cdr)
       ->get();

        return view('cdr.rps.cuentas.index',compact('rps','cuentas'));
    }

    public function store(Request $request)
    {

        $registro = rp_cuenta::where('id_rp',$request->id_rp)
        ->where('id_cuenta',$request->id_cuenta)
        ->get();
        
        if(count($registro) == 0){
            if(isset($request->id_rp_cuenta_crear) &&  $request->id_rp_cuenta_crear==1)
            {   
                $registro = new rp_cuenta();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $registro;            
                return response()->json($respuesta);
            }
        }else{

            $rules = [
                'id_rp_cuenta_crear2' => 'required', 
            ];
            $messages = [
                'id_rp_cuenta_crear2.required' => 'La relación de la cuenta con el rp ya ha sido creada',  
            ];
            $this->validate($request, $rules, $messages);
        }
            

        $registro->id_rp  = $request->id_rp;
        $registro->id_cuenta  = $request->id_cuenta;
        $registro->created_by = Auth::user()->id;
        $registro->save();
      
        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la bitaora";
        $respuesta['objeto']= $registro;
    
        return response()->json($respuesta);
    }

    public function get_info_cuentas(Request $request)
    {

        $cuentas = rp_cuenta::leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','rps_cuentas.id_cuenta')
        ->where('rps_cuentas.id_rp',$request->id_rp)
        ->select('rps_cuentas.id','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta')      
        ->get();

        foreach($cuentas as $cuenta){

            $cuenta->valor = $cuenta->saldo_rp_cuenta();
        }

        return response()->json($cuentas); 
    }

    public function delete(Request $request)
    {
        $rp_cuenta = rp_cuenta::find($request->id_rp_cuenta);
        if(count($rp_cuenta->Rps_movimientos) == 0){

            $rp_cuenta->deleted_by = Auth::user()->id;
            $rp_cuenta->save();

            $informacionlog = 'Se ha eliminado la informacion del movimiento';
            $objetolog = [
                    'user_id' => Auth::user()->id,
                    'user_email' => Auth::user()->mail,
                    'Objeto Eliminado' => $rp_cuenta,
                    ];                

            Log::channel('database')->info( 
                $informacionlog ,
                $objetolog
            );

            $rp_cuenta->delete();
            $respuesta['status']="success";
            $respuesta['message']="Se ha eliminado registro";
            $respuesta['objeto']=$rp_cuenta;
        }else{
            $respuesta['status']="error";
            $respuesta['message'] = "La relación con la cuenta N° ".$rp_cuenta->Cuentas->numero_de_cuenta." no puede ser eliminada por que ya tiene movimientos creados.";
            $respuesta['objeto']= $rp_cuenta;
        }
        return response()->json($respuesta);
    }  
    
    public function get_info_cuentas_pendiente_comprometer(Request $request){

        $id_cdr = cdr_rp::find($request->id_rp)->select('id_cdr')->first();
        $cdr = cdr::find($id_cdr->id_cdr);
        $valor = $cdr->Por_comprometer();

      return $valor;

    }

    
}
