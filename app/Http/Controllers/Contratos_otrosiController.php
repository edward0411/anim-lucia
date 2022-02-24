<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos as contratos;
use App\Models\Contratos_fechas as contratos_fechas;
use App\Models\Contratos_otrosi as contratos_otrosi;
use App\Models\Cdrs as cdr;
use Auth;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class Contratos_otrosiController extends Controller
{

    public function get_info_por_contrato(Request $request)
    {
        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos_otrosi = Contratos_otrosi::where('id_contrato', $request->id_contrato)
            ->orderBy('fecha_firma')
            ->get();

        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos_otrosi);
    }


    public function delete_info_otrosi(Request $request)
    {
        $id_contrato = 0;

        $contratos_otrosi = Contratos_otrosi::find($request->id_otrosi);
        $id_contrato = $contratos_otrosi->id_contrato;

        $contratos_otrosi->deleted_by = Auth::user()->id;
        $contratos_otrosi->save();
       
        $informacionlog = 'Se ha eliminado la informacion del otro si';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $contratos_otrosi,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );

        $contratos_otrosi->delete();

        $fecha_terminacion =  DB::select('call usp_contratos_fecha_actualizar_fecha_terminacion_actual_bucle(?,?)',array($id_contrato,Auth::user()->id));       
        $valor_actual =  DB::select('call usp_contratos_fecha_actualizar_valor_actual(?,?)',array($id_contrato,Auth::user()->id));

        // $info_contra = informacion_contractuals::all();
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $contratos_otrosi;


        return response()->json($respuesta);
    }


    public function store(Request $request)
    {

        $otrosi_valor_adicion=$request->otrosi_valor_adicion;
        $otrosi_valor_adicion=str_replace(',','',$otrosi_valor_adicion);

        $rules = [
            'numero_otrosi' => 'required',
            'otrosi_fecha_firma' => 'required',
            'modificacion' => 'required',        
        ];

        $messages = [
            'otrosi_fecha_firma.required' => 'La fecha de la la firma del otro sí es obligatorio',
            'numero_otrosi.required' => 'El número del otro sí es obligatorio',
            'modificacion.required' => 'Digite el detalle de la modificación',        
        ];
        
        $contrato_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();

        if ($contrato_fechas == null) {
            $rules['fehcasContratos'] = 'required';   
            $messages['fehcasContratos.required'] ='Debe diligenciar las fechas del contrato antes de hacer un otrosí';   
        
            $this->validate($request, $rules, $messages);
        }

        if ((!isset($request->otrosi_es_adicion)) && (!isset($request->otrosi_es_prorroga)) && (!isset($request->otrosi_es_obligacion)) && (!isset($request->otrosi_es_suspension)) && (!isset($request->otrosi_es_cesion))) {
          
            $rules['fehcasContratos_13'] = 'required';   
            $messages['fehcasContratos_13.required'] ='Debe diligenciar al menos un tipo de otro sí.';   
        
            $this->validate($request, $rules, $messages);
        }



        $id_contrato = $request->id_contrato;

        $contrato = contratos::find($id_contrato);
 
        $fechas = $contrato->contratos_fechas()->select('fecha_inicio','fecha_terminacion_actual')->first();
        $fecha_inicio = $fechas->fecha_inicio;
        $fecha_final = $fechas->fecha_terminacion_actual;
        $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');
        $valor_contrato = $contrato->valor_contrato;

        $contratos_otrosi = contratos_otrosi::where('id', $request->id_otrosi)->first();

        // if ($contratos_otrosi == null) {
        //     $contratos_otrosi_val = contratos_otrosi::where('id_contrato', $request->id_contrato)->where('numero_otrosi',$request->numero_otrosi) ->first();      
           
        //     if ($contratos_otrosi_val != null) {
        //         $rules['numero_otrosi_2'] = 'required';   
        //         $messages['numero_otrosi_2.required'] ='EL número del otrosí ya fue registrado';   
        //     }
        // }else{

        //     $contratos_otrosi_val = contratos_otrosi::where('id_contrato', $request->id_contrato)->where('numero_otrosi',$request->numero_otrosi)->whereNotIn('id', [$contratos_otrosi->id])->get();


        //     if (count($contratos_otrosi_val) != 0) {
        //         $rules['numero_otrosi_16'] = 'required';   
        //         $messages['numero_otrosi_16.required'] ='El número del otrosí ya fue registrado en otrosí';   
        //     }
        // }
       

        if ($request->otrosi_fecha_firma < $fecha_inicio) {
            $rules['id_contrato15'] = 'required';
            $messages['id_contrato15.required'] ='La fecha firma del otrosí no puede ser inferior a la fecha inicio del contrato.';          
          }

        if ($request->otrosi_fecha_firma > $fecha_final) {
            $rules['id_contrato3'] = 'required';
            $messages['id_contrato3.required'] ='La fecha firma del otrosí no puede ser superior a la fecha final del contrato.';          
        }

        if ($request->otrosi_fecha_firma > $fecha_hoy) {
            $rules['id_contrato14'] = 'required';
            $messages['id_contrato14.required'] ='La fecha firma del otrosí no puede ser superior a la fecha actual.';          
        }

        if($request->otrosi_nueva_fecha_terminacion != null){

            if ($request->otrosi_nueva_fecha_terminacion < $fecha_inicio) {
                $rules['id_contrato4'] = 'required';
                $messages['id_contrato4.required'] ='La fecha nueva de terminación del contrato no puede ser inferior a la fecha inicio del contrato.';          
              }
    
            if ($request->otrosi_nueva_fecha_terminacion < $fecha_final) {

                $rules['id_contrato5'] = 'required';
                $messages['id_contrato5.required'] ='La fecha nueva de terminación del contrato no puede ser inferior a la fecha final del contrato.';          
            }

        }

        if($request->suspension_fecha_inicio != null){
            if ($request->suspension_fecha_inicio < $fecha_inicio) {
                $rules['id_contrato6'] = 'required';
                $messages['id_contrato6.required'] ='La fecha de suspensión del contrato no puede ser inferior a la fecha inicio del contrato.';          
              }
        }

        if($request->suspension_fecha_fin != null){

            if ($request->suspension_fecha_fin < $fecha_inicio) {
                $rules['id_contrato7'] = 'required';
                $messages['id_contrato7.required'] ='La fecha de suspensión del contrato no puede ser inferior a la fecha inicio del contrato.';          
              }
        }

        if($otrosi_valor_adicion != null){
            $valor = $contrato->valor_contrato + $otrosi_valor_adicion;
            if($valor < 0){
                $rules['id_contrato8'] = 'required';
                $messages['id_contrato8.required'] ='El valor de la disminución no puede ser mayor al valor del contrato.'; 
            }
        }

      // dd($request->otrosi_es_adicion);

        if (isset($request->otrosi_es_adicion)) {
            if (((int)$otrosi_valor_adicion == null) || ((int)$otrosi_valor_adicion == 0)) {
                
                $rules['id_contrato9'] = 'required';
                $messages['id_contrato9.required'] ='El valor de la adición ó disminución no puede ser 0 ó vacio.';
            }

            if ($contrato->param_valor_tipo_contrato == 3) {


                $cdr = cdr::find($request->otrosi_id_cdr);
                $valor_cdr = $cdr->saldo_cdr();

                if ($request->id_otrosi != 0) {

                   $valor_otrosi_old = contratos_otrosi::where('id', $request->id_otrosi)->select('valor_adicion')->first();
                   $valor_aumento = ($valor_contrato - $valor_otrosi_old->valor_adicion) + $otrosi_valor_adicion;
                  
                }else{
                    $valor_aumento = $valor_contrato + $otrosi_valor_adicion;
                }
        
                if ($valor_aumento > $valor_cdr) {
                    $rules['otrosi_valor_adicion2'] = 'required';   
                    $messages['otrosi_valor_adicion2.required'] ='El valor de la adición más el valor del contrato supera el valor del CDR';   
                }
            }

        }

        /* if (isset($request->otrosi_es_prorroga)) {
            if ($request->otrosi_nueva_fecha_terminacion == null) {
                $rules['id_contrato10'] = 'required';
                $messages['id_contrato10.required'] ='La Nueva fecha terminación de la Prorroga no puede ser vacia.';
            }
        }

       if (isset($request->otrosi_es_suspension)) {
            if ($request->suspension_afecta_terminacion == 1) {
                if ($request->suspension_nueva_fecha_terminacion == null) {
                    $rules['id_contrato11'] = 'required';
                    $messages['id_contrato11.required'] ='La Nueva fecha terminación de la suspensión no puede ser vacia ya que indico que afecta la fecha de terminación del contrato.';
                }
               
            }
        }*/

        if (isset($request->otrosi_es_suspension)) {

            if($request->suspension_fecha_inicio != null){
                if ($request->suspension_fecha_inicio < $request->otrosi_fecha_firma) {
                    $rules['id_contrato12'] = 'required';
                    $messages['id_contrato12.required'] ='La fecha de inicio suspensión no puede ser inferior a la fecha inicio de la firma otro si.';          
                  }
            }
            if($request->suspension_fecha_fin != null){
                if ($request->suspension_fecha_fin < $request->suspension_fecha_inicio) {
                    $rules['id_contrato13'] = 'required';
                    $messages['id_contrato13.required'] ='La fecha fin suspensión no puede ser inferior a la fecha inicio de suspensión.';          
                  }
            }
        } 

        $this->validate($request, $rules, $messages);


        $fecha_fin_suspension = Carbon::parse($request->suspension_fecha_fin);
        $fecha_inical_suspension = Carbon::parse($request->suspension_fecha_inicio);

        $contratos_otrosi = contratos_otrosi::where('id', $request->id_otrosi)->first();

        if ($contratos_otrosi == null) {

            $contratos_otrosi = new contratos_otrosi();
        }

        $contratos_otrosi->id_contrato  = $request->id_contrato;
        $contratos_otrosi->es_adicion  = $request->otrosi_es_adicion  ?? 0;
        $contratos_otrosi->es_prorroga  = $request->otrosi_es_prorroga  ?? 0;
        $contratos_otrosi->es_obligacion  = $request->otrosi_es_obligacion  ?? 0;
        $contratos_otrosi->es_suspension  = $request->otrosi_es_suspension  ?? 0;
        $contratos_otrosi->es_cesion  = $request->otrosi_es_cesion  ?? 0;
        $contratos_otrosi->numero_otrosi  = $request->numero_otrosi;
        $contratos_otrosi->fecha_firma  = $request->otrosi_fecha_firma;


        
        if ($contratos_otrosi->es_adicion == 1) {
            $valor_otrosi_old = 0;
            if($request->id_otrosi != 0){            
                $valor_otrosi_old =  $contratos_otrosi->valor_adicion;
            }

            $contratos_otrosi->valor_adicion  = $otrosi_valor_adicion;
            $contratos_otrosi->id_cdr_otrosi  = $request->otrosi_id_cdr;

        
        }

        if ($contratos_otrosi->es_prorroga == 1) {

           
            $contratos_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();

            //dd($contratos_fechas);


            $contratos_otrosi->definir_plazo  = $request->otrosi_definir_plazo  ?? 0;
            $contratos_otrosi->meses  = $request->otrosi_meses ?? 0;
            $contratos_otrosi->dias  = $request->otrosi_dias ?? 0;

            if (($request->otrosi_definir_plazo ?? 0) == 1) { 

                if($request->otrosi_nueva_fecha_terminacion == null){

                    $fecha_carbon = ($contratos_fechas->fecha_terminacion_actual ?? $contratos_fechas->fecha_terminacion);

                    $fecha  = new Carbon($fecha_carbon);
                    $meses = $request->otrosi_meses ?? 0;
                    $dias = $request->otrosi_dias ?? 0;
                    $fecha->add($meses, 'months');
                    $fecha->add($dias, 'days');

                    $fechaTermincacionCalculada = $fecha;
                }else{

                    $fechaTermincacionCalculada =  $request->otrosi_nueva_fecha_terminacion;
                }
                
            } else {
                $fechaTermincacionCalculada =  $request->otrosi_nueva_fecha_terminacion;
            }

            //dd(Carbon::parse($fechaTermincacionCalculada)->format('Y-m-d'));

            $contratos_otrosi->nueva_fecha_terminacion  = Carbon::parse($fechaTermincacionCalculada)->format('Y-m-d');
            //$contratos_fechas->fecha_terminacion_actual = Carbon::parse($fechaTermincacionCalculada)->format('Y-m-d');
            //$contratos_fechas->save();

            //dd($contratos_fechas);
        }


        //calcular nueva fecha de terminacion del contratos                
        if ($contratos_otrosi->es_suspension == 1) {

            $contrato = contratos::find($request->id_contrato);
            $contrato->cambiar_estado(2); //pasa a suspendido


            $contratos_otrosi->suspension_afecta_terminacion  = $request->suspension_afecta_terminacion  ?? 0;
            $contratos_otrosi->suspension_fecha_inicio  = $request->suspension_fecha_inicio;
            $contratos_otrosi->suspension_definir_plazo  = $request->suspension_definir_plazo  ?? 0;
            $contratos_otrosi->suspension_meses  = $request->suspension_meses ?? 0;
            $contratos_otrosi->suspension_dias  = $request->suspension_dias ?? 0;
            if (($request->suspension_definir_plazo ?? 0) == 1) {
                $fecha  = new Carbon($request->suspension_fecha_inicio);
                $meses = $request->suspension_meses ?? 0;
                $dias = $request->suspension_dias ?? 0;

                $fecha->add($meses, 'months');
                $fecha->add($dias, 'days');

                $fechaTermincacionSuspensionCalculada = $fecha;
            } else {
                $fechaTermincacionSuspensionCalculada =  $request->suspension_fecha_fin;
            }

            $contratos_otrosi->suspension_fecha_fin  = $fechaTermincacionSuspensionCalculada;


            if ($contratos_otrosi->suspension_afecta_terminacion  == 1) {

                 $contratos_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();

                if (($request->suspension_definir_plazo ?? 0) == 1) {


                    $fecha_carbon = ($contratos_fechas->fecha_terminacion_actual ?? $contratos_fechas->fecha_terminacion);

                    $fecha  = new Carbon($fecha_carbon);
                    $meses = $request->suspension_meses ?? 0;
                    $dias = $request->suspension_dias ?? 0;

                    $fecha->add($meses, 'months');
                    $fecha->add($dias, 'days');

                    // $fechaTermincacionContratoCalculada = $fecha;
                } else {
                    if (!empty($request->suspension_nueva_fecha_terminacion)) {
                        $fechaTermincacionContratoCalculada =  $request->suspension_nueva_fecha_terminacion;
                    } else {
                        $inicio = new Carbon($contratos_otrosi->suspension_fecha_inicio);
                        $fin = new Carbon($contratos_otrosi->suspension_fecha_fin);
                        $dias = $inicio->diff($fin)->days;

                        $fecha  = new Carbon($contratos_fechas->fecha_terminacion_actual);

                        $fecha->add($dias, 'days');

                        // $fechaTermincacionContratoCalculada = $fecha;
                    }
                }

                // $contratos_fechas->fecha_terminacion_actual = $fechaTermincacionContratoCalculada;
                // $contratos_fechas->save();
            }
        }

        $contratos_otrosi->detalle_modificacion  = $request->modificacion;
        //calcular nueva fecha de terminacion del contratos

        $contratos_otrosi->created_by  =  Auth::user()->id;
        $contratos_otrosi->updated_by  =  Auth::user()->id;


        $contratos_otrosi->save();
       // $contratos_otrosi->valor_actual = $contratos_fechas->valor_actual;

        $contratos_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();

        //dd($contratos_fechas);
        
        if($contratos_otrosi->es_prorroga || $contratos_otrosi->es_suspension  ){
            $contratos_fechas->actualizar_fecha_terminacion_actual(Auth::user()->id);
        }
        if($contratos_otrosi->es_adicion ){
            $contrato_fechas->actualizar_valor_contrato_actual(Auth::user()->id);
        }
        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información del otrosí";
        $respuesta['objeto'] = $contratos_otrosi;

        return response()->json($respuesta);
    }

    public function edit_info_otrosi(Request $request)
    {
        $otrosi = contratos_otrosi::findOrFail($request->id_otrosi);

        return response()->json($otrosi);
    }
}
