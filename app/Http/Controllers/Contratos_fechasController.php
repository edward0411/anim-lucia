<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\terceros as terceros;
use App\Models\Contratos as contratos;
use App\Models\Contratos_fechas as contratos_fechas;
use App\Models\Contratos_polizas as contrato_poliza;
use Auth;
use Carbon\Carbon;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\DB;
use Throwable;

class Contratos_fechasController extends Controller
{


    public function get_info(Request $request)
     {
       $valores = contratos_fechas::where('id_contrato',$request->id_contrato)
                 ->get();

        return response()->json($valores);  
     }


    public function store(Request $request)
    {
        //dd($request);

        $valor_inicial=$request->valor_inicial;
        $valor_inicial=str_replace(',','',$valor_inicial); 

        $request->validate([
            'fecha_firma' => 'required',
            'id_contrato' => 'required',
            
        ]);

        $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');
        $rules['id_contrato'] = 'required';   
        $messages['id_contrato.required'] ='Favor seleccione un tipo de contrato.'; 

            if($request->fecha_firma != null){
                if ($request->fecha_firma > $fecha_hoy) {
                    $rules['id_contrato2'] = 'required';
                    $messages['id_contrato2.required'] ='La fecha de la firma no puede ser superior a la fecha actual.';     
                }
            }
            if($request->fecha_inicio != null){
                if ($request->fecha_inicio > $fecha_hoy) {
                    $rules['id_contrato3'] = 'required';
                    $messages['id_contrato3.required'] ='La fecha de inicio no puede ser superior a la fecha actual.';                  
                }
                if ( $request->fecha_inicio < $request->fecha_firma) {
                    $rules['id_contrato4'] = 'required';
                    $messages['id_contrato4.required'] ='La fecha de inicio del contrato no puede ser inferior a la fecha firma del contrato.';       
                }
            }  
            if($request->fecha_arl != null){
                if ($request->fecha_arl < $request->fecha_firma ) {
                    $rules['id_contrato5'] = 'required';
                    $messages['id_contrato5.required'] ='La fecha ARL no puede ser inferior a la fecha firma del contrato.';                  
                }
                if ($request->fecha_arl > $fecha_hoy ) {
                    $rules['id_contrato11'] = 'required';
                    $messages['id_contrato11.required'] ='La fecha ARL no puede ser superior a la fecha del sistema.';                  
                }
            }
            if($request->fecha_acta_inicio != null){
                if ($request->fecha_acta_inicio < $request->fecha_firma ) {
                    $rules['id_contrato6'] = 'required';
                    $messages['id_contrato6.required'] ='La fecha de acta de inicio no puede ser inferior a la fecha firma del contrato.';               
                }
            }
            if($request->fecha_terminacion != null){
                if ($request->fecha_terminacion < $request->fecha_inicio ) {
                    $rules['id_contrato7'] = 'required';
                    $messages['id_contrato7.required'] ='La fecha de terminación no debe ser inferior a la fecha de inicio del contrato.';               
                }
            }
            if(($request->fecha_terminacion != null) && ($request->fecha_arl != null)){
                if ($request->fecha_arl > $request->fecha_terminacion ) {
                    $rules['id_contrato8'] = 'required';
                    $messages['id_contrato8.required'] ='La fecha de ARL no debe ser superior a la fecha de terminación del contrato.';               
                }
            }
            if(($request->fecha_terminacion != null) && ($request->fecha_acta_inicio != null)){
                if ($request->fecha_acta_inicio > $request->fecha_terminacion ) {
                    $rules['id_contrato9'] = 'required';
                    $messages['id_contrato9.required'] ='La fecha de acta de inicio no debe ser superior a la fecha de terminación del contrato.';               
                }
            }
            if ($request->plazo_inicial_definir == 1) {
                if (($request->plazo_inicial_meses == null) && ($request->plazo_inicial_dias == null)) {
                    $rules['id_contrato10'] = 'required';
                    $messages['id_contrato10.required'] ='Si selecciono "Definir plazo inicial" no puede degar los campos de meses y días ambos vacios.';               
                }
            }
             if ($request->fecha_suscripcion_acta_liquidacion != null) {
                if ($request->fecha_suscripcion_acta_liquidacion < $request->fecha_terminacion_actual ) {
                    $rules['id_contrato11'] = 'required';
                    $messages['id_contrato11.required'] ='La fecha de subcripción acta de liquidación no debe ser inferior a la fecha de terminación actual contrato.';               
                }
             }
               
            

            $this->validate($request, $rules, $messages);

        $contratos_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();

        if ($contratos_fechas == null) {

            $contratos_fechas = new contratos_fechas();
        }

        $contratos_fechas->id_contrato  = $request->id_contrato;
        $contratos_fechas->fecha_firma  = $request->fecha_firma;

        //al firmar el contrato pasa a estado en ejecucion
        $contrato = contratos::find($request->id_contrato);
        $var_nuevo_estado = $contrato->param_valor_tipo_contrato == 2 ? 5 : 1;  //5 es para PAD y apliga Vigente, 1 es para Convenios y Contrato y es en ejecucion
        $contrato->cambiar_estado($var_nuevo_estado); //en ejecuicion;

        // $this->param_valor_estado_contrato = 1;
        // $contrato->param_valor_estado_contrato = Parametricas::getTextFromValue('contratos.estados_contrato', 1);
        // $contrato->save();

        $contratos_fechas->requiere_pliza  = $request->requiere_pliza;

        if (isset($request->requiere_arl)) {
            $contratos_fechas->requiere_arl  = $request->requiere_arl;
            $contratos_fechas->fecha_arl  = $request->fecha_arl;
        }else{
            $contratos_fechas->requiere_arl  = null;
            $contratos_fechas->fecha_arl  = null;
        }
        if (isset($request->requiere_acta_inicio)) {
            $contratos_fechas->requiere_acta_inicio  = $request->requiere_acta_inicio;
            $contratos_fechas->fecha_acta_inicio  = $request->fecha_acta_inicio;
        }else{
            $contratos_fechas->requiere_acta_inicio  = null;
            $contratos_fechas->fecha_acta_inicio  = null;
        }
        if (isset($request->plazo_inicial_definir)) {
            $contratos_fechas->plazo_inicial_meses  = $request->plazo_inicial_meses;
            $contratos_fechas->plazo_inicial_dias  = $request->plazo_inicial_dias;
        }else{
            $contratos_fechas->plazo_inicial_meses  = null;
            $contratos_fechas->plazo_inicial_dias  = null;
        }
        
        $contratos_fechas->fecha_terminacion  = $request->fecha_terminacion;


        $fecha_inicio = $contratos_fechas->fecha_firma;

        if (!empty($request->fecha_arl)) $fecha_inicio = $request->fecha_arl;

        if (!empty($request->fecha_acta_inicio)) $fecha_inicio = $request->fecha_acta_inicio;

        $contratos_fechas->fecha_inicio  = $fecha_inicio;

        $fechaTermincacionCalculada = "";

        if ($request->plazo_inicial_definir == 1) {
            $fecha  = new Carbon($fecha_inicio);
            $meses = $request->plazo_inicial_meses ?? 0;
            $dias = $request->plazo_inicial_dias ?? 0;
            $fecha->add($meses, 'months');
            $fecha->add($dias, 'days');

            $fechaTermincacionCalculada = $fecha;
        } else {
            $fechaTermincacionCalculada =  $contratos_fechas->fecha_terminacion;
        }

        $contratos_fechas->fecha_terminacion = $fechaTermincacionCalculada;
        $contratos_fechas->fecha_terminacion_actual  = $fechaTermincacionCalculada;

        $contratos_fechas->valor_inicial  = $valor_inicial;
        $contratos_fechas->valor_actual  = $valor_inicial;

        $contratos_fechas->requiere_liquidacion  = $request->requiere_liquidacion;

        $contratos_fechas->tiempo_liquidacion_meses  = $request->tiempo_liquidacion_meses;
        $contratos_fechas->fecha_suscripcion_acta_liquidacion  = $request->fecha_suscripcion_acta_liquidacion;

        $fechaLiquidacion  = new Carbon($fechaTermincacionCalculada);
        $fechaLiquidacion->add($request->tiempo_liquidacion_meses, 'months');

        $contratos_fechas->fecha_maxima_liquidacion  = $fechaLiquidacion;

        $contratos_fechas->observaciones  = $request->observaciones;

        $contratos_fechas->created_by = Auth::user()->id;

        $contratos_fechas->save();

        $actualizacion = DB::select('call usp_contratos_fecha_actualizar_valor_actual(?,?)',array($request->id_contrato,Auth::user()->id));
        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');
        $actualizacion_fecha_final = DB::select('call usp_contratos_fecha_actualizar_fecha_terminacion_actual_bucle (?,?)',array($request->id_contrato,Auth::user()->id));


        $contratos_fechas->fecha_maxima_liquidacion  =  Carbon::parse($contratos_fechas->fecha_maxima_liquidacion)->format('Y-m-d');

        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de fechas";
        $respuesta['objeto'] = $contratos_fechas;

        return response()->json($respuesta);
    }

    public function update_contratos()
    {
        try {         

            $registros = contratos::Join('contratos_fechas','contratos_fechas.id_contrato','=','contratos.id')
            ->whereNull('contratos.deleted_at')
            ->select('contratos.id')
            ->get();

            foreach ($registros as $contrato) { 

             $actualizacion_fecha_final = DB::select('call usp_contratos_fecha_actualizar_fecha_terminacion_actual_bucle (?,?)',array($contrato->id,Auth::user()->id));
             $actualizacion_fecha = DB::select('call usp_contratos_fecha_actualizar_fecha_inicial(?,?)',array($contrato->id,Auth::user()->id));
             $actualizacion_valor = DB::select('call usp_contratos_fecha_actualizar_valor_actual(?,?)',array($contrato->id,Auth::user()->id));
               
            }
            $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

            dd('true');
           
        } catch (Throwable $e) {
            report($e);

            dd($e);
    
            return false;
        }
    }

}
