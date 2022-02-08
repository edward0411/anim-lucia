<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Patrimonio_cuenta_movimientos as cuentas_movimientos;
use App\Models\Cdrs as cdr;
use App\Models\Cuentas_x_cdr as cuenta_cdr;
use App\Models\Cdr_operaciones as cdr_operacion;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use Illuminate\Support\Facades\DB;
use Auth;
use Log;

use Carbon\Carbon;

class CdrMovimientosController extends Controller
{
   

    public function index(Request $request){

        $relacion = cdr_cuentas::leftJoin('cdrs','cdrs.id','=','cdrs_cuentas.id_cdr')
        ->leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
        ->where('cdrs_cuentas.id',$request->id)
        ->select('cdrs_cuentas.id','cdrs_cuentas.id_cdr','cdrs.fecha_registro_cdr','cdrs.objeto_cdr','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto')
        ->first();
        
        $fecha = Carbon::now()->parse()->format('Y-m-d');

        return view('cdr.movimientos.historial',compact('relacion','fecha'));

    }
    
    public function store(Request $request){
        
        $rules = [
            'id_cdr_cuenta' => 'required', 
        ];
        $messages = [
            'id_cdr_cuenta.required' => 'Es un campo obligatorio',  
        ];


        $array_valores = $this->get_saldos_por_id_cuenta($request->id_cdr_cuenta);


        $fecha = Carbon::now()->parse()->format('Y-m-d');
        
        $registro = cdr_operacion::find($request->id_cdr_movimiento);

        if($registro == null )
        {
            if(isset($request->id_cdr_movimiento_crear) &&  $request->id_cdr_movimiento_crear==1)
            { 
                $registro = new cdr_operacion();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $registro;
                return response()->json($respuesta);
            }

            if ($request->valor_operacion > 0 ) {

                if ($array_valores['disponible'] < $request->valor_operacion && $array_valores['disponible_asignado'] < $request->valor_operacion  )  {
                    $rules['valor_disponible2'] = 'required';   
                    $messages['valor_disponible2.required'] ='El valor del movimiento supera el valor disponible de la cuenta';   
                }
                $this->validate($request, $rules, $messages);
            }
        }else{
            //Se guarda elnuevo valos dosponble en caja sumandoelvalor inicial del movimiento para validar el nuevo valor del movimiento
            $valor_disp_validar = 0;

            if($request->valor_operacion != $registro->valor_operacion){
              
                $valor_disp_validar = $array_valores['disponible'] + $registro->valor_operacion;

                if ($valor_disp_validar < $request->valor_operacion) {
                    $rules['valor_disponible2'] = 'required';   
                    $messages['valor_disponible2.required'] ='El valor del movimiento supera el valor disponible de la cuenta'; 
                }
                $this->validate($request, $rules, $messages);
            }
        }

        
        $registro->id_cdr_cuenta = $request->id_cdr_cuenta;
        if($request->patrimonio_cuenta==0)
        {
            $registro->fecha_operacion = $fecha;
        }
        $registro->observaciones = $request->observacion;
        $registro->valor_operacion = $request->valor_operacion;
        $registro->cdr_fiducia = $request->codigo_fiducia;
        if($request->patrimonio_cuenta==0)
        {
            $registro->created_by = Auth::user()->id;
        }else {
            $registro->updated_by = Auth::user()->id;
        }
        $registro->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la cuenta";
        $respuesta['objeto']= $registro;

        return response()->json($respuesta);
    }


    public function get_infomovimientos_por_cdr(Request $request)
    {
        $operaciones = cdr_operacion::where('id_cdr_cuenta',$request->id_cdr_cuenta)
        ->get();

        return response()->json($operaciones);

    }

    public function delete_info_operacion(Request $request)
    {
        $operaciones_cdp = cdr_operacion::find($request->id_cdr_operacion);

        $operaciones_cdp->deleted_by = Auth::user()->id;
        $operaciones_cdp->save();


        $informacionlog = 'Se ha eliminado la informacion de la operacion';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $operaciones_cdp,
                ];

        Log::channel('database')->info(
            $informacionlog ,
            $objetolog
        );

        $operaciones_cdp->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$operaciones_cdp;


        return response()->json($respuesta);

    }

    public function get_infoValores_por_cdr(Request $request){

        $array_valores = $this->get_saldos_por_id_cuenta($request->id_cdr_cuenta);
        
        return  $array_valores;
    }


    function get_saldos_por_id_cuenta($id_cdr_cuenta){
        
        $id_cuenta = cdr_cuentas::find($id_cdr_cuenta)->id_cuenta;

        
        $suma_asignado = patrimonios_cuentas::find($id_cuenta)->valor_asignado;
        
        
        $sumatoria = cdr_cuentas::Join('cdr_operaciones','cdrs_cuentas.id','=','cdr_operaciones.id_cdr_cuenta' )
        ->select('id_cuenta', DB::raw('SUM(valor_operacion) as valor_operacion'))
        ->groupBy('id_cuenta')
        ->wherenull('cdr_operaciones.deleted_at')
        ->where('id_cuenta',$id_cuenta)
        ->get();

        //dd($sumatoria);

        $suma = cuentas_movimientos::select('id_cuenta', DB::raw('SUM(valor) as valor_cuenta'))
        ->groupBy('id_cuenta')
        ->where('deleted_at',null)
        ->where('id_cuenta',$id_cuenta)
        ->get();

        //dd($suma);


        if(count($suma) > 0){
          $saldo = $suma[0]->valor_cuenta;
        }else{
          $saldo = 0;
        }
        if(count($sumatoria) > 0){
            $saldo_cdr = $sumatoria[0]->valor_operacion;
        }else{
            $saldo_cdr = 0;
        }

        $disponible = $saldo - $saldo_cdr;


        $disponible_asignado = $suma_asignado - $saldo_cdr;

        $array_valores['suma_cdr_cuentas'] = (float)$saldo_cdr;
        $array_valores['suma_cuentas_movimientos'] = (float)$saldo;
        $array_valores['suma_asignado'] =(float) $suma_asignado;
        $array_valores['disponible'] = (float)$disponible;
        $array_valores['disponible_asignado'] =(float) $disponible_asignado;


        // dd($array_valores);
        return  $array_valores;
    }

}
