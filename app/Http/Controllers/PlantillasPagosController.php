<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\Plantillas_pagos as plantillas_pagos;
use App\Models\Plan_pagos_rps as plan_rp;
use App\Models\Obl_operaciones as obl_operaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Rps_cuentas as rp_cuenta;

class PlantillasPagosController extends Controller
{
    //
    public function index(Request $request){

        $tipo_plantilla = parametricas::getFromCategory('financiero.cdr.rps.tipo_plantilla');


        $rps = cdr_rp::leftJoin('terceros','terceros.id','=','rps.id_tercero')
        ->select('rps.*','terceros.nombre','identificacion')
        ->where('rps.id',$request->id)->first();

        return view('cdr.rps.plantillas_pagos.index',compact('tipo_plantilla','rps'));
    }

    public function store(Request $request){

      if (($request->chk_plantilla == 1) || ($request->chk_plantilla == 2)) {

        $fecha = Carbon::create($request->anio_inicial, $request->mes_inicial + 1, 01)->format('Y-m-d');

        $plan_pagos = new plantillas_pagos();
        $plan_pagos->id_rp = $request->id_rp;
        $plan_pagos->mes_inicial = $fecha;
        $plan_pagos->numeros_cuotas = $request->numero_cuotas;
        $plan_pagos->porcentaje_liquidacion = $request->porcentaje_liquidacion;
        $plan_pagos->param_tipo_plantilla_pagos_valor = $request->chk_plantilla;
        $plan_pagos->param_tipo_plantilla_pagos_texto = Parametricas::getTextFromValue('financiero.cdr.rps.tipo_plantilla', $request->chk_plantilla);
        $plan_pagos->created_by = Auth::user()->id;
        $plan_pagos->save();

     }else if($request->chk_plantilla == 3){

        $rules = [
            'mes_' => 'required',
            'anio_' => 'required',
            'valor_cuota' => 'required',
        ];
        $messages = [
            'mes_.required' => 'Favor asigne un mes inicial a la tabla de plantilla',
            'anio_.required' => 'Favor asigne un año inicial a la tabla de plantilla',
            'valor_cuota.required' => 'Favor asigne un valor de cuota inicial a la tabla de plantilla',
        ];
        $this->validate($request, $rules, $messages);
        $count = count($request->valor_cuota);
        $valor_t_cuotas = 0;

        foreach($request->valor_cuota as $value){
            $valor_t_cuotas =  $valor_t_cuotas + $value;
        }
        $valor_t_cuotas;

       if( $valor_t_cuotas != $request->saldo_rp){
            $rules = [
                'valor_cuota2' => 'required',
            ];
            $messages = [
                'valor_cuota2.required' => 'La sumatoria de las cuotas mensuales es diferente al valor del rp',
            ];
             $this->validate($request, $rules, $messages);
       }

       $pos = array_key_first($request->mes_);
       $mes = $request->mes_[$pos];
       $anio = $request->anio_[$pos];
       $fecha_creada = Carbon::create($anio,$mes,01)->format('Y-m-d');

        $plan_pagos = new plantillas_pagos();
        $plan_pagos->id_rp = $request->id_rp;
        $plan_pagos->mes_inicial = $fecha_creada;
        $plan_pagos->numeros_cuotas = $count;
        $plan_pagos->porcentaje_liquidacion = $request->porcentaje_liquidacion;
        $plan_pagos->param_tipo_plantilla_pagos_valor = $request->chk_plantilla;
        $plan_pagos->param_tipo_plantilla_pagos_texto = Parametricas::getTextFromValue('financiero.cdr.rps.tipo_plantilla', $request->chk_plantilla);
        $plan_pagos->created_by = Auth::user()->id;
        $plan_pagos->save();
     }

     $id_plantilla = $plan_pagos->id;


     if ($request->chk_plantilla == 1) {

        $valor_cuota = $request->saldo_rp/$request->numero_cuotas;

        for ($i=0; $i < $request->numero_cuotas; $i++) {

            $registro = new plan_rp();
            $registro->id_plantilla = $id_plantilla;
            $registro->mes = $fecha;
            $registro->valor_mes = $valor_cuota;
            $registro->created_by = Auth::user()->id;
            $registro->save();

            $fecha = Carbon::parse($fecha)->addMonth()->format('Y-m-d');
        }

     }else if ($request->chk_plantilla == 2){

        $valor_porcentaje = ($request->saldo_rp/100)*$request->porcentaje_liquidacion;
        $valor_rest = $request->saldo_rp - $valor_porcentaje;
        $num_cuotas = $request->numero_cuotas - 1;
        $valor_cuota = $valor_rest/$num_cuotas;

        for ($i=0; $i < $num_cuotas; $i++) {

            $registro = new plan_rp();
            $registro->id_plantilla = $id_plantilla;
            $registro->mes = $fecha;
            $registro->valor_mes = $valor_cuota;
            $registro->created_by = Auth::user()->id;
            $registro->save();

            $fecha = Carbon::parse($fecha)->addMonth()->format('Y-m-d');
        }
            $registro = new plan_rp();
            $registro->id_plantilla = $id_plantilla;
            $registro->mes = $fecha;
            $registro->valor_mes = $valor_porcentaje;
            $registro->created_by = Auth::user()->id;
            $registro->save();

        }else if ($request->chk_plantilla == 3){

           foreach ($request->mes_ as $key => $value) {

            $fecha_creada = Carbon::create($request->anio_[$key],$request->mes_[$key],01)->format('Y-m-d');

            $registro = new plan_rp();
            $registro->id_plantilla = $id_plantilla;
            $registro->mes = $fecha_creada;
            $registro->valor_mes = $request->valor_cuota[$key];
            $registro->created_by = Auth::user()->id;
            $registro->save();

           }

        }

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información del pago";
        $respuesta['objeto']= $plan_pagos;

         return response()->json($respuesta);

    }

    public function edit($id){

       $plantilla = plantillas_pagos::where('id_rp',$id)
       ->whereNull('deleted_at')
       ->first();

       $id_plantilla = $plantilla->id;

       $plan_pago = plan_rp::where('id_plantilla',$id_plantilla)->get();

       foreach($plan_pago as $plan){

            $mes = Carbon::parse($plan->mes)->format('m');
            $anio = Carbon::parse($plan->mes)->format('Y');

           $plan->mes_obt = $mes;
           $plan->anio_obt = $anio;
       }

       return view('cdr.rps.plantillas_pagos.edit',compact('plan_pago','id_plantilla','id'));
    
    }

    public function update(Request $request)
    {

        $array_anios = [];

        if (!isset($request->mes)) {
            $rules = [
                'valor_cuota4' => 'required',
            ];
            $messages = [
                'valor_cuota4.required' => 'Favor no intentar eliminar todas las cuotas de un plan de pagos.',
            ];
             $this->validate($request, $rules, $messages);
        }

        foreach ($request->mes as $key => $value) {

            $fecha_creada = Carbon::create($request->anio[$key],$request->mes[$key],01)->format('Y-m-d');

            $array_anios[$key] = $fecha_creada;
        }

        $array_unique = array_unique($array_anios);

        if(count($array_unique) < count($array_anios)){
            $rules = [
                'valor_cuota3' => 'required',
            ];
            $messages = [
                'valor_cuota3.required' => 'Favor no seleccionar la misma fecha más de una vez.',
            ];
             $this->validate($request, $rules, $messages);

        }

        $plantilla = plantillas_pagos::where('id',$request->id_plantilla)->first();
        $id_rp = $plantilla->id_rp;

        
        $rp = cdr_rp::find($id_rp);
        $valor_rp = $rp->saldo_rp();
      
        $rules = [
            'mes' => 'required',
            'anio' => 'required',
            'valor_cuota' => 'required',
        ];
        $messages = [
            'mes.required' => 'Favor asigne un mes inicial a la tabla de plantilla',
            'anio.required' => 'Favor asigne un año inicial a la tabla de plantilla',
            'valor_cuota.required' => 'Favor asigne un valor de cuota inicial a la tabla de plantilla',
        ];
        $this->validate($request, $rules, $messages);
        $count = count($request->valor_cuota);
        $valor_t_cuotas = 0;

        //dd($request->valor_cuota);

        foreach($request->valor_cuota as $value){

            if (is_numeric($value)) {
                $valor_t_cuotas =  $valor_t_cuotas + (float)$value;
            }else{

            $valor = explode('$', $value, 2);
            $valor = str_replace(',','',$valor);  
            $valor_t_cuotas =  $valor_t_cuotas + (float)$valor[1];
            }
           
            
        }

        //dd($valor_t_cuotas, $valor_rp);

       if($valor_t_cuotas <> $valor_rp){
            $rules = [
                'valor_cuota2' => 'required',
            ];
            $messages = [
                'valor_cuota2.required' => 'La sumatoria de las cuotas mensuales es diferente del valor del rp',
            ];
             $this->validate($request, $rules, $messages);
       }

       $pos = array_key_first($request->mes);
       $mes = $request->mes[$pos];
       $anio = $request->anio[$pos];
       $fecha_creada = Carbon::create($anio,$mes,01)->format('Y-m-d');

       $registro = plantillas_pagos::findOrFail($request->id_plantilla);
       $registro->mes_inicial = $fecha_creada;
       $registro->numeros_cuotas = $count;
       $registro->updated_by = Auth::user()->id;
       $registro->save();

       $planes = plan_rp::where('id_plantilla',$request->id_plantilla)->get();

       foreach($planes as $plan){
        $id_plan = $plan->id;
        $registro = plan_rp::findOrFail($id_plan);
        $registro->deleted_by = Auth::user()->id;
        $registro->delete();
       }

       foreach ($request->mes as $key => $value) {

        if(is_numeric($request->valor_cuota[$key])){
            $valor_final = $request->valor_cuota[$key];
        }else{
            $valor = explode('$', $request->valor_cuota[$key], 2);
            $valor = str_replace(',','',$valor); 
            $valor_final = $valor[1];
        }

         

        $fecha_creada = Carbon::create($request->anio[$key],$request->mes[$key],01)->format('Y-m-d');
        $registro = new plan_rp();
        $registro->id_plantilla = $request->id_plantilla;
        $registro->mes = $fecha_creada;
        $registro->valor_mes =  $valor_final;
        $registro->created_by = Auth::user()->id;
        $registro->save();
       }

       return redirect()->back()->withSuccess('Actualización con éxito.');

    }

    public function get_info_pagos_rp(Request $request)
    {
        $plan_pagos_rp = plan_rp::where('id_plantilla',$request->id_plantilla)
        ->get();

        foreach($plan_pagos_rp as $value){

            $mes_request = Carbon::parse($value->mes);
            $mes_inicial = Carbon::parse($value->mes)->format('Y-m-d');
            $dias = $mes_request->daysInMonth;
            $dias_add = $dias-1;
            $mes_final = Carbon::parse($mes_request)->addDays($dias_add)->format('Y-m-d');

            $rp = plantillas_pagos::find($value->id_plantilla);
            $id_rp = $rp->id_rp;
            $cuentas = rp_cuenta::where('id_rp',$id_rp)->get();
            $pagos = 0;

            foreach($cuentas as $cuenta){

                $id_rel = $cuenta->id;

                $valor = obl_operaciones::where('id_rp_cuenta',$id_rel)
                ->whereBetween('fecha_obl_operacion', [$mes_inicial, $mes_final])
                ->get();

                if(count($valor) > 0){
                   foreach($valor as $val){
                    $pagos = $pagos + $val->valor_operacion_obl;
                   }
                }
            }

           $value->ejecutado_mes = $pagos;
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fecha = Carbon::parse($value->mes);
            $mes = $meses[($fecha->format('n')) - 1];

           $anio = Carbon::parse($value->mes)->format('Y');

           $fecha = $mes.' '.$anio;

           $value->fecha = $fecha;
        }

       

        return response()->json($plan_pagos_rp);
    }

    public function get_info_id_plantilla(Request $request)
    {
        $plantilla = plantillas_pagos::where('id_rp',$request->id_rp)
        ->whereNull('deleted_at')
        ->select('id')
        ->first();

        return response()->json($plantilla);
    }

    public function delete($id){
            
        $plantilla = plantillas_pagos::where('id_rp',$id)->first();

        $id_plantilla = $plantilla->id;
 
        $plan_pago = plan_rp::where('id_plantilla',$id_plantilla)->get();
 
        foreach($plan_pago as $plan){

            $plan->deleted_by = Auth::user()->id;
            $plan->save();
            $plan->delete();
        }

        $plantilla->deleted_by = Auth::user()->id;
        $plantilla->save();
        $plantilla->delete();

        return redirect()->back()->withSuccess('Actualización con éxito.');

    }

    
}
