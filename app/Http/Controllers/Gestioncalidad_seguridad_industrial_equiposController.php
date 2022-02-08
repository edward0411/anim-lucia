<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calidad_seguridad_industrial_equipos_obras as calidad_seguridad_industrial_equipos_obras;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Gestioncalidad_seguridad_industrial_equiposController extends Controller
{

    public function ControlEquipos_store(Request $request)
    {
      
        if ($request->file('file_control')) {

            $rules['file_control'] = 'image|mimes:jpg,jpeg,bmp,png|dimensions:min_width=100 px,min_height=200 px|max:5000 px';
            $messages['file_control.image'] ='El tipo de archivo que esta subiendo no es compatible como imagen o foto.';
            $messages['file_control.mimes'] ='El formato de imagen no es compatible con las soportadas por el sistema.';
            $messages['file_control.dimensions'] ='las dimensiones de la imagen no son compatibles con las requeridas para el sistema.';
            $messages['file_control.max'] ='El tamaño de la imagen no es compatible con la requerida para el sistema.';

            $this->validate($request, $rules, $messages);

        }

        $calidad_seguridad_industrial_equipos_obras = calidad_seguridad_industrial_equipos_obras::find($request->id_ControlEquipos);

        if($calidad_seguridad_industrial_equipos_obras  == null )
        {
            if(isset($request->id_ControlEquipos_crear) &&  $request->id_ControlEquipos_crear == 1)
            {
             $calidad_seguridad_industrial_equipos_obras  = new calidad_seguridad_industrial_equipos_obras();
            }else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $calidad_seguridad_industrial_equipos_obras ;
                return response()->json($respuesta);
            }
        }

         $calidad_seguridad_industrial_equipos_obras->id_calidad_seguridad_industrial = $request->ControlEquipos_id_gestion_calidad;
         $calidad_seguridad_industrial_equipos_obras->control_equipos_obra = $request->control_equipos_obra;
         $calidad_seguridad_industrial_equipos_obras->recomendaciones = $request->recomendaciones_equipo;
         $calidad_seguridad_industrial_equipos_obras->actividad_labor_realizada = $request->actividad_labor_realizada;
         $calidad_seguridad_industrial_equipos_obras->equipo_utilizado =  $request->equipo_utilizado;
         $calidad_seguridad_industrial_equipos_obras->nombre_especialista = $request->nombre_especialista;
               
         
         if($request->id_ControlEquipos==0)
         {
             $calidad_seguridad_industrial_equipos_obras->created_by = Auth::user()->id;
         }else {
             $calidad_seguridad_industrial_equipos_obras->updated_by = Auth::user()->id;
         }
         $calidad_seguridad_industrial_equipos_obras->save();

         if($calidad_seguridad_industrial_equipos_obras->updated_by != null){
            if (!$request->file('file_control')) {
                if ($calidad_seguridad_industrial_equipos_obras->imagen_control == '' || $calidad_seguridad_industrial_equipos_obras->imagen_control == null) {
                    $calidad_seguridad_industrial_equipos_obras->imagen_control = '';
                    $calidad_seguridad_industrial_equipos_obras->save();
                }
            } else {
                $path = public_path().'/images/GestionControl_Equipos/';
                $extension = $request->file('file_control')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_equipos_obras->id . '.' . $extension;
                $request->file('file_control')->move($path, $filename);
                $calidad_seguridad_industrial_equipos_obras->imagen_control = $filename;
                $calidad_seguridad_industrial_equipos_obras->save();
            }
        }else{
           
            if (!$request->file('file_control')) {
               
                $calidad_seguridad_industrial_equipos_obras->imagen_control = '';
                $calidad_seguridad_industrial_equipos_obras->save();
            } else {
               
                $path = public_path().'/images/GestionControl_Equipos/';
                $extension = $request->file('file_control')->getClientOriginalExtension();
                $filename = 'Documento'.$calidad_seguridad_industrial_equipos_obras->id . '.' . $extension;
                $request->file('file_control')->move($path, $filename);
                $calidad_seguridad_industrial_equipos_obras->imagen_control = $filename;
                $calidad_seguridad_industrial_equipos_obras->save();
            }
        }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $calidad_seguridad_industrial_equipos_obras;
         $respuesta['id']= $calidad_seguridad_industrial_equipos_obras->id;

          return response()->json($respuesta);

    }

    public function ControlEquipos_get_info(Request $request)
    {

        $calidad_seguridad_industrial_control_equipos = calidad_seguridad_industrial_equipos_obras::where('id_calidad_seguridad_industrial',$request->control_equipos_id_gestion_calidad)
        ->get();

        return response()->json($calidad_seguridad_industrial_control_equipos);

    }

    public function delete_control_equipos(Request $request)
    {
        $relacion = calidad_seguridad_industrial_equipos_obras::find($request->id_Control_equipos);
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
