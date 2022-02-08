<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyectos_caracteristicas as  proyectos_caracteristicas;
use App\Models\Parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProyectosCaracteristicasController extends Controller
{


    public function caracteristicas_store(Request $request){

        $caracteristica_proyecto = proyectos_caracteristicas::find($request->id_caracteristicas_proyectos);

        if($caracteristica_proyecto  == null )
        {
            if(isset($request->id_caracteristicas_proyectos_crear) &&  $request->id_caracteristicas_proyectos_crear==1)
            {
             $caracteristica_proyecto  = new proyectos_caracteristicas();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $caracteristica_proyecto ;
                return response()->json($respuesta);
            }
        }

         $caracteristica_proyecto ->id_proyecto  = $request->id_proyecto;
         $caracteristica_proyecto ->param_tipo_proyecto_caracteristica_valor = $request->nombre_caracteristica;
         $caracteristica_proyecto ->param_tipo_proyecto_caracteristica_texto = Parametricas::getTextFromValue('tecnico.proyectos.caracteristica_proyectos', $request->nombre_caracteristica);
         $caracteristica_proyecto ->decripcion_proyecto = $request->descripcion_caracteristica;
         if($request->id_caracteristicas_proyectos==0)
         {
             $caracteristica_proyecto->created_by = Auth::user()->id;
         }else {
             $caracteristica_proyecto->updated_by = Auth::user()->id;
         }
         $caracteristica_proyecto->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $caracteristica_proyecto;

          return response()->json($respuesta);
        }

        public function caracteristicas_get_info(Request $request)
        {
            $caracteristicas = proyectos_caracteristicas::where('id_proyecto',$request->id_proyecto)
            ->orderBy('param_tipo_proyecto_caracteristica_texto')
            ->get();

            return response()->json($caracteristicas);
        }

        public function delete_caracteristicas(Request $request)
        {
            
            $relacion = proyectos_caracteristicas::where('id',$request->id_proyecto_caracteristica)->first();
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
