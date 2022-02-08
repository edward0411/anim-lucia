<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos_terminaciones as contrato_terminacion;
use App\Models\Contratos as contratos;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\DB;
use App\Models\Contratos_fechas as contratos_fechas;

class ContratosTerminacionController extends Controller
{
       public function store(Request $request){

        $rules = [
          'chk_terminacion' => 'required',           
        ];

        $messages = [
            'chk_terminacion.required' => 'Debe seleccionar un tipo de terminación',                
        ];

         $consulta = contrato_terminacion::where('id_contrato',$request->id_contrato)->first();
         $id_contrato = $request->id_contrato;
         $contrato = contratos::find($id_contrato);
         $fechas = $contrato->contratos_fechas()->select('fecha_inicio')->first();
         $fecha_inicio = $fechas->fecha_inicio;
         $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');

         if (isset($request->fecha_firma_terminacion )) {
          if ($request->fecha_firma_terminacion < $fecha_inicio) {
            $rules['fecha_firma_terminacion2'] = 'required';
            $messages['fecha_firma_terminacion2.required'] ='La fecha firma del acta no puede ser inferior a la fecha inicio del contrato.';          
          }
          if ($request->fecha_firma_terminacion > $fecha_hoy) {
            $rules['fecha_firma_terminacion3'] = 'required';
            $messages['fecha_firma_terminacion3.required'] ='La fecha firma del acta no puede ser superior a la fecha actual.';          
        }

         }
            $this->validate($request, $rules, $messages);

         $i = 0;  
         if ($consulta == null) { 
          $i = 1;      
          $relacion = new contrato_terminacion();
         }else{
          $relacion = contrato_terminacion::find($consulta->id);
         }

         $relacion->id_contrato = $request->id_contrato;
         $relacion->param_tipo_terminacion_valor = $request->chk_terminacion;
         $relacion->param_tipo_terminacion_texto = Parametricas::getTextFromValue('contratos.tipo_terminacion', $request->chk_terminacion);
         $relacion->fecha_firma_acta = $request->fecha_firma_terminacion;
         $relacion->soporte_documento_acta = $request->adjuntar_documento_terminacion;
         $relacion->observaciones = $request->observacion_terminacion;
         if ($i == 1) {
          $relacion->created_by = Auth::user()->id;
          }else {
           $relacion->updated_by = Auth::user()->id;
          }
         $relacion->save(); 

         $contratos_fechas = contratos_fechas::where('id_contrato', $request->id_contrato)->first();
         $contratos_fechas->fecha_terminacion_actual  = $request->fecha_firma_terminacion;
         $contratos_fechas->save();
         
         $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

          $respuesta['status']="success";
          $respuesta['message']="Se ha guardado la información de la caracteristica";
          $respuesta['objeto']= $relacion;

        return response()->json($respuesta);

        
    }

    public function get_info(Request $request){

      $terminacion = contrato_terminacion::where('id_contrato',$request->id_contrato_terminacion)->select('id','param_tipo_terminacion_valor','fecha_firma_acta','soporte_documento_acta','observaciones')->get();

      return response()->json($terminacion);
      

    } 
}
