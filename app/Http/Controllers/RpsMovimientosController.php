<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\Cdrs as cdr;
use App\Models\rps_movimientos as rp_movimientos;
use App\Models\Rps_cuentas as rp_cuenta;
use Carbon\Carbon;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use Illuminate\Support\Facades\DB;
use Auth;
use Log;

class RpsMovimientosController extends Controller
{
    public function index(Request $request)
    {   
        
        $rp_cuenta = rp_cuenta::leftJoin('rps','rps.id','=','rps_cuentas.id_rp')
        ->leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','rps_cuentas.id_cuenta')
        ->select('rps_cuentas.id as id_rp_cuenta','rps.*','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.numero_de_cuenta')
        ->where('rps_cuentas.id',$request->id)
        ->first(); 

       $id_rp_cuenta = $rp_cuenta->id;

        return view('cdr.rps.cuentas.movimientos.index',compact('rp_cuenta','id_rp_cuenta'));
    }

    public function store(Request $request){

        $fecha = Carbon::now()->parse()->format('Y-m-d');

        $registro = rp_movimientos::find($request->id_rp_movimiento); 
        
        $rules = [
            'valor_operacion' => 'required',
        ];

        $messages = [
            'valor_operacion.required' => 'El valor de la operación es un campo obligatorio',
        ];

        if ($request->valor_operacion > $request->valor_disponible) {
            $rules['valor_operacion_2'] = 'required';
            $messages['valor_operacion_2.required'] ='El valor de la operación no puede superar el valor disponible en la cuenta.';
        }

        $this->validate($request, $rules, $messages);
        
        if($registro == null )
        {
            if(isset($request->id_rp_movimiento_crear) &&  $request->id_rp_movimiento_crear==1)
            {   
                $registro = new rp_movimientos();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $registro;            
                return response()->json($respuesta);
            }
        }

        $registro->id_rp_cuenta  = $request->id_rp_cuenta;
        $registro->fecha_operacion_rp = $fecha;
        $registro->valor_operacion_rp = $request->valor_operacion;
        $registro->observaciones = $request->observaciones;
        if($request->id_rp_movimiento==0)
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

    public function get_info_por_rp(Request $request){

        $rp_movimientos = rp_movimientos::where('rp_operaciones.id_rp_cuenta',$request->id_rp_cuenta)->get(); 

        return response()->json($rp_movimientos); 
    }

    public function delete(Request $request)
    {
        $rp_movimiento = rp_movimientos::find($request->id_rp_movimiento);
        
        $rp_movimiento->deleted_by = Auth::user()->id;
        $rp_movimiento->save();

        
        $informacionlog = 'Se ha eliminado la informacion del movimiento';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $rp_movimiento,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        $rp_movimiento->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$rp_movimiento;
        

        return response()->json($respuesta);
    }   

    public function get_info_cuentas(Request $request)
    {
        $cuentas = rp_movimientos::leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','rp_operaciones.id_cuenta')
        ->where('rp_operaciones.deleted_at',null)
        ->where('rp_operaciones.id_rp',$request->id_rp)
        ->select('patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta',DB::raw('Sum(rp_operaciones.valor_operacion_rp) as valor_asignado'))
        ->groupBy('patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta')
        ->get();
    }


    public function get_info_consultar_valor_disponible(Request $request){

        $rp_cuenta = rp_cuenta::where('id',$request->id_rp_cuenta)->first();
        $id_rp = $rp_cuenta->id_rp;
        $id_cuenta = $rp_cuenta->id_cuenta;
        $rp =  cdr_rp::where('id',$id_rp)->first();
        $id_cdr = $rp->id_cdr; 
        $relacion = cdr_cuentas::where('id_cdr',$id_cdr)->where('id_cuenta',$id_cuenta)->select('id')->first();
        $id_rel = $relacion->id;
        $relacion_cuenta = cdr_cuentas::find($id_rel);
        $valor_cuenta = $relacion_cuenta->saldo_cuenta_cdr();
        $valor_operaciones = $rp_cuenta->saldo_rp_cuenta();

        $relacion_cuenta_rp = rp_cuenta::join('rp_operaciones','rp_operaciones.id_rp_cuenta','=','rps_cuentas.id')
        ->join('rps','rps.id','=','rps_cuentas.id_rp')
        ->where('rps_cuentas.id_cuenta',$id_cuenta)
        ->where('rps.id_cdr',$id_cdr)
        ->whereNull('rp_operaciones.deleted_at')
        ->whereNull('rps_cuentas.deleted_at')
        ->whereNull('rps.deleted_at')
        ->select(DB::raw('sum(rp_operaciones.valor_operacion_rp) as valor'))
        ->first();
        
        $valor = $valor_cuenta - $relacion_cuenta_rp->valor;

        return $valor;

    }

    
}
