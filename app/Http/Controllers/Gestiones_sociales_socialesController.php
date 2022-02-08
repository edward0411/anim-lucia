<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestiones_sociales_sociales as gestiones_sociales_sociales;
use App\Models\Parametricas;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class Gestiones_sociales_socialesController extends Controller
{

//
    public function sociales_store(Request $request){

        $gestiones_sociales_sociales = gestiones_sociales_sociales::find($request->id_sociales);

        $gestiones_sociales_socialesRepetidos = gestiones_sociales_sociales::
                                                where([['param_caracteristicas_valor','=',$request->id_caracteristicas],
                                                ['id_gestiones_sociales',$request->social_id_sociales],
                                                ['id','<>',$request->id_sociales]])->get();

        if ($gestiones_sociales_socialesRepetidos->count()>0)
        {
            $rules['caracteristica_2'] = 'required';
            $messages['caracteristica_2.required'] ='La caracteristica ya existe.';
        
        $this->validate($request, $rules, $messages);
        }

    

        if($gestiones_sociales_sociales  == null )
        {
            if(isset($request->id_sociales_crear) &&  $request->id_sociales_crear == 1)
            {
             $gestiones_sociales_sociales  = new gestiones_sociales_sociales();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $gestiones_ambientales_fuente_materiales ;
                return response()->json($respuesta);
            }
        }

         $gestiones_sociales_sociales->id_gestiones_sociales  = $request->social_id_sociales;
         $gestiones_sociales_sociales->param_caracteristicas_valor = $request->id_caracteristicas;
         $gestiones_sociales_sociales->param_caracteristicas_texto = Parametricas::getTextFromValue('gestionesSocial.caracteristicas', $request->id_caracteristicas);
         $gestiones_sociales_sociales->valor = $request->valor;
         $gestiones_sociales_sociales->observaciones = $request->observaciones;
        
         
         if($request->id_sociales==0)
         {
             $gestiones_sociales_sociales->created_by = Auth::user()->id;
         }else {
             $gestiones_sociales_sociales->updated_by = Auth::user()->id;
         }
         $gestiones_sociales_sociales->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $gestiones_sociales_sociales;

          return response()->json($respuesta);

    }

    public function sociales_get_info(Request $request){

        $gestiones_sociales_sociales = gestiones_sociales_sociales::where('id_gestiones_sociales',$request->social_id_sociales)
        ->OrderBy('param_caracteristicas_texto')
        ->get();

        return response()->json($gestiones_sociales_sociales);

    }

    public function delete_sociales(Request $request)
        {
            $relacion = gestiones_sociales_sociales::find($request->id_sociales);
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
