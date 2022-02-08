<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calidad_seguridad_industrial_actividades_realizadas as calidad_seguridad_industrial_actividades_realizadas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Gestioncalidad_seguridad_industrial_actividades_realizadasController extends Controller
{

//
    public function ActividadesRealizadas_store(Request $request){

        if ($request->de_medida_preventiva == null && $request->actividades_higiene_seguridad_industrial == null) {

            $rules['validate1'] = 'required';
            $messages['validate1.required'] ='Debe registrar al menos una actividad';
           
            $this->validate($request, $rules, $messages);
        }


        if ($request->file('file_actividades')) {

            $rules['file_actividades'] = 'mimes:jpeg,bmp,png,gif,svg,pdf|max:3000';
            $messages['file_actividades.mimes'] ='El formato del documento no es compatible con las soportadas por el sistema.';
            $messages['file_actividades.max'] ='El tamaño del documento no es compatible con la requerida para el sistema.';

            $this->validate($request, $rules, $messages);
        }

        $calidad_seguridad_industrial_actividades_realizadas = calidad_seguridad_industrial_actividades_realizadas::find($request->id_ActividadesRealizadas);

        if($calidad_seguridad_industrial_actividades_realizadas  == null )
        {
            if(isset($request->id_ActividadesRealizadas_crear) &&  $request->id_ActividadesRealizadas_crear == 1)
            {
             $calidad_seguridad_industrial_actividades_realizadas  = new calidad_seguridad_industrial_actividades_realizadas();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $calidad_seguridad_industrial_actividades_realizadas ;
                return response()->json($respuesta);
            }
        }

         $calidad_seguridad_industrial_actividades_realizadas->id_calidad_seguridad_industrial   = $request->ActividadesRealizadas_id_gestion_calidad;
         $calidad_seguridad_industrial_actividades_realizadas->de_medida_preventiva  = $request->de_medida_preventiva;
         $calidad_seguridad_industrial_actividades_realizadas->actividades_higiene_seguridad_industrial  = $request->actividades_higiene_seguridad_industrial;          
         
         if($request->id_ActividadesRealizadas==0)
         {
             $calidad_seguridad_industrial_actividades_realizadas->created_by = Auth::user()->id;
         }else {
             $calidad_seguridad_industrial_actividades_realizadas->updated_by = Auth::user()->id;
         }
         $calidad_seguridad_industrial_actividades_realizadas->save();

         dd($request);

         if($calidad_seguridad_industrial_actividades_realizadas->updated_by != null){
            if (!$request->file('file_actividades')) {
                if ($calidad_seguridad_industrial_actividades_realizadas->imagen_actividades == '' || $calidad_seguridad_industrial_actividades_realizadas->imagen_actividades == null) {
                    $calidad_seguridad_industrial_actividades_realizadas->imagen_actividades = '';
                    $calidad_seguridad_industrial_actividades_realizadas->save();
                }
            } else {
                $path = 'C:\home\site\wwwroot/images/GestionSeguridad_actividades/';
                $extension = $request->file('file_actividades')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_actividades_realizadas->id . '.' . $extension;
                $request->file('file_actividades')->move($path, $filename);
                $calidad_seguridad_industrial_actividades_realizadas->imagen_actividades = $filename;
                $calidad_seguridad_industrial_actividades_realizadas->save();
            }
        }else{
            if (!$request->file('file_actividades')) {
                $calidad_seguridad_industrial_actividades_realizadas->imagen_actividades = '';
                $calidad_seguridad_industrial_actividades_realizadas->save();
            } else {
                $path = 'C:\home\site\wwwroot/images/GestionSeguridad_actividades/';
                $extension = $request->file('file_actividades')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_actividades_realizadas->id . '.' . $extension;
                $request->file('file_actividades')->move($path, $filename);
                $calidad_seguridad_industrial_actividades_realizadas->imagen_actividades = $filename;
                $calidad_seguridad_industrial_actividades_realizadas->save();
            }
        }

         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $calidad_seguridad_industrial_actividades_realizadas;
         $respuesta['id']= $calidad_seguridad_industrial_actividades_realizadas->id;

          return response()->json($respuesta);

    }

    public function ActividadesRealizadas_get_info(Request $request){

        $calidad_seguridad_industrial_actividades_realizadas = calidad_seguridad_industrial_actividades_realizadas::where('id_calidad_seguridad_industrial',$request->ActividadesRealizadas_id_gestion_calidad)
        ->get();

        return response()->json($calidad_seguridad_industrial_actividades_realizadas);

    }

    public function delete_ActividadesRealizadas(Request $request)
    {
        $relacion = calidad_seguridad_industrial_actividades_realizadas::find($request->id_ActividadesRealizadas);
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
