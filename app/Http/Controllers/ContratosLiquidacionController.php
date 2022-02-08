<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos_liquidaciones as contrato_liquidacion;
use App\Models\Contratos as contratos;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\DB;

class ContratosLiquidacionController extends Controller
{
    //
    public function store(Request $request){

      $rules = [
      'chk_liquidacion' => 'required',
              
      ];

      $messages = [
          'chk_liquidacion.required' => 'Debe seleccionar un tipo de Liquidación', 
      
      ];

        $consulta = contrato_liquidacion::where('id_contrato',$request->id_contrato)->first();
        $id_contrato = $request->id_contrato;
        $contrato = contratos::find($id_contrato);
        $fechas = $contrato->contratos_fechas()->select('fecha_inicio','fecha_terminacion_actual')->first();
        $fecha_inicio = $fechas->fecha_inicio;
        $fecha_final = $fechas->fecha_terminacion_actual;
        $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');

        if (isset($request->fecha_firma_liquidacion)) {
          if ($request->fecha_firma_liquidacion < $fecha_inicio) {
            $rules['fecha_firma_liquidacion2'] = 'required';
            $messages['fecha_firma_liquidacion2.required'] ='La fecha firma del acta no puede ser inferior a la fecha inicio del contrato.';          
          }
          if ($request->fecha_firma_liquidacion > $fecha_hoy) {
            $rules['fecha_firma_liquidacion3'] = 'required';
            $messages['fecha_firma_liquidacion3.required'] ='La fecha firma del acta no puede ser superior a la fecha actual.';          
        }
          
        }
            $this->validate($request, $rules, $messages);

        $i = 0;  
        if ($consulta == null) { 
         $i = 1;      
         $relacion = new contrato_liquidacion();
        }else{
         $relacion = contrato_liquidacion::find($consulta->id);
        }

        $relacion->id_contrato = $request->id_contrato;
        $relacion->param_tipo_liquidacion_valor	 = $request->chk_liquidacion;
        $relacion->param_tipo_liquidacion_texto = Parametricas::getTextFromValue('contratos.tipo_liquidacion', $request->chk_liquidacion);
        
        $relacion->fecha_firma_proceso_liquidacion = $request->fecha_firma_proceso_liquidacion;
        $relacion->soporte_documento_acta_proceso = $request->adjuntar_documento_proceso_liquinacion;
        $relacion->observaciones_proceso = $request->observacion_proceso_liquidacion;

        $relacion->fecha_firma_acta = $request->fecha_firma_liquidacion;
        $relacion->soporte_documento_acta = $request->adjuntar_documento_liquinacion;
        $relacion->observaciones = $request->observacion_liquidacion;

        if ($i == 1) {
         $relacion->created_by = Auth::user()->id;
         }else {
          $relacion->updated_by = Auth::user()->id;
         }
        $relacion->save(); 

        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $relacion;

       return response()->json($respuesta);

       
   }
   public function get_info(Request $request){

    $liquidacion = contrato_liquidacion::where('id_contrato',$request->id_contrato_liquidacion)->get();

    return response()->json($liquidacion);

  } 

   
}
