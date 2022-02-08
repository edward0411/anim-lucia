<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calidad_seguridad_industrial_inspeccion_ensayos as calidad_seguridad_industrial_inspeccion_ensayos;
use App\Models\Parametricas as parametricas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Gestioncalidad_seguridad_industrial_inspeccion_ensayosController extends Controller
{

//
    public function inspeccion_ensayos_store(Request $request)
    {   
     
      
        if ($request->file('file')) {

            $rules['file'] = 'mimes:jpeg,bmp,png,gif,svg,pdf|max:3000';
            $messages['file.mimes'] ='El formato del documento no es compatible con las soportadas por el sistema.';
            $messages['file.max'] ='El tamaño del documento no es compatible con la requerida para el sistema.';

            $this->validate($request, $rules, $messages);
        }
       
        $calidad_seguridad_industrial_inspeccion_ensayos = calidad_seguridad_industrial_inspeccion_ensayos::find($request->id_InspeccionEnsayos);
       
        if($calidad_seguridad_industrial_inspeccion_ensayos  == null )
        {
            if(isset($request->id_InspeccionEnsayos_crear) &&  $request->id_InspeccionEnsayos_crear == 1)
            {
             $calidad_seguridad_industrial_inspeccion_ensayos  = new calidad_seguridad_industrial_inspeccion_ensayos();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $calidad_seguridad_industrial_inspeccion_ensayos ;
                return response()->json($respuesta);
            }
        }

         $calidad_seguridad_industrial_inspeccion_ensayos->id_calidad_seguridad_industrial   = $request->InspeccionEnsayos_id_gestion_calidad;
         $calidad_seguridad_industrial_inspeccion_ensayos->control_inspeccion_ensayos  = $request->control_inspeccion_ensayos;
         $calidad_seguridad_industrial_inspeccion_ensayos->recomendaciones  = $request->recomendaciones_ensayo;
         $calidad_seguridad_industrial_inspeccion_ensayos->param_tipo_prueba_valor = $request->tipo_prueba_ensayo;
         $calidad_seguridad_industrial_inspeccion_ensayos->param_tipo_prueba_texto = Parametricas::getTextFromValue('GestionCalidad.tipo_prueba', $request->tipo_prueba_ensayo);
         $calidad_seguridad_industrial_inspeccion_ensayos->unidad_ejecutora = $request->unidad_ejecutora_ensayo;
         $calidad_seguridad_industrial_inspeccion_ensayos->nombre_especialista = $request->nombre_ensayo;
         $calidad_seguridad_industrial_inspeccion_ensayos->localizacion = $request->localizacion;
         $calidad_seguridad_industrial_inspeccion_ensayos->fecha_toma_prueba  = $request->fecha_toma_prueba;
         $calidad_seguridad_industrial_inspeccion_ensayos->resultados_prueba = $request->resultados_prueba;
         $calidad_seguridad_industrial_inspeccion_ensayos->fecha_resultado_prueba = $request->fecha_resultado_prueba;
        
         
         if($request->id_InspeccionEnsayos==0)
         {
             $calidad_seguridad_industrial_inspeccion_ensayos->created_by = Auth::user()->id;
         }else {
             $calidad_seguridad_industrial_inspeccion_ensayos->updated_by = Auth::user()->id;
         }
         $calidad_seguridad_industrial_inspeccion_ensayos->save();

        if($calidad_seguridad_industrial_inspeccion_ensayos->updated_by != null){
            if (!$request->file('file')) {
                if ($calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo == '' || $calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo == null) {
                    $calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo = '';
                    $calidad_seguridad_industrial_inspeccion_ensayos->save();
                }
            } else {
                $path = public_path().'/images/GestionSeguridadIndustrial_Ensayos/';
                $extension = $request->file('file')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_inspeccion_ensayos->id . '.' . $extension;
                $request->file('file')->move($path, $filename);
                $calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo = $filename;
                $calidad_seguridad_industrial_inspeccion_ensayos->save();
            }
        }else{
            if (!$request->file('file')) {
                $calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo = '';
                $calidad_seguridad_industrial_inspeccion_ensayos->save();
            } else {
                $path = public_path().'/images/GestionSeguridadIndustrial_Ensayos/';
                $extension = $request->file('file')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_inspeccion_ensayos->id . '.' . $extension;
                $request->file('file')->move($path, $filename);
                $calidad_seguridad_industrial_inspeccion_ensayos->documento_inspeccion_ensayo = $filename;
                $calidad_seguridad_industrial_inspeccion_ensayos->save();
            }
        }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $calidad_seguridad_industrial_inspeccion_ensayos;
         $respuesta['id']= $calidad_seguridad_industrial_inspeccion_ensayos->id;

          return response()->json($respuesta);

    }

    public function inspeccion_ensayos_get_info(Request $request)
    {

        $calidad_seguridad_industrial_inspeccion_ensayos = calidad_seguridad_industrial_inspeccion_ensayos::where('id_calidad_seguridad_industrial',$request->InspeccionEnsayos_id_gestion_calidad)
        ->get();

        return response()->json($calidad_seguridad_industrial_inspeccion_ensayos);

    }

    public function delete_inspeccion_ensayos(Request $request)
    {
        $relacion = calidad_seguridad_industrial_inspeccion_ensayos::find($request->id_InspeccionEnsayos);
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
