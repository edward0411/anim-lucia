<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion_social_bitacora as gestion_bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GestionSocialBitacoraController extends Controller
{
    public function store_bitacora(Request $request)
    {

        $gestion_social_bitacora = gestion_bitacora::find($request->id_bitacora);

        if ($request->fecha_inicio_gestion < $request->fecha_bitacora)
        {
                $rules['fecha_2'] = 'required';
                $messages['fecha_2.required'] ='La fecha de la bitácora no puede ser mayor a la fecha de elaboración.';

            $this->validate($request, $rules, $messages);
        }

        if ($request->file('photo')) {

            $rules['photo'] = 'image|mimes:jpg,jpeg,bmp,png|dimensions:min_width=100 px,min_height=200 px|max:5000 px';
            $messages['photo.image'] ='El tipo de archivo que esta subiendo no es compatible como imagen o foto.';
            $messages['photo.mimes'] ='El formato de imagen no es compatible con las soportadas por el sistema.';
            $messages['photo.dimensions'] ='las dimensiones de la imagen no son compatibles con las requeridas para el sistema.';
            $messages['photo.max'] ='El tamaño de la imagen no es compatible con la requerida para el sistema.';

            $this->validate($request, $rules, $messages);

        }

        if ($gestion_social_bitacora == null) {
            if (isset($request->id_bitacora_crear) && ($request->id_bitacora_crear == 1)) {
                $gestion_social_bitacora = new gestion_bitacora();
            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permisos para crear registros nuevos";
                $respuesta['objecto']= $gestion_social_bitacora;
                return response()->json($respuesta);
           }
        }
        $gestion_social_bitacora->id_gestion_social  = $request->bitacora_id_gestion_social;
        $gestion_social_bitacora->fecha = $request->fecha_bitacora;
        $gestion_social_bitacora->Descripcion_gestion =  $request->descripcion_gestion;
        $gestion_social_bitacora->vinculo =$request->vinculo;


        if ($request->id_bitacora == 0) {
          $gestion_social_bitacora->created_by = Auth::user()->id;
        }else {
           $gestion_social_bitacora->updated_by = Auth::user()->id;
        }
        $gestion_social_bitacora->save();

        if($gestion_social_bitacora->updated_by != null){
            if (!$request->file('photo')) {
                if ($gestion_social_bitacora->imagen == '' || $gestion_ambiental_bitacora->imagen == null) {
                    $gestion_social_bitacora->imagen = '';
                    $gestion_social_bitacora->save();
                }
            } else {
                $path = public_path().'/images/GestionAmbiental_bitacora/';
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filename = $gestion_social_bitacora->id . '.' . $extension;
                $request->file('photo')->move($path, $filename);
                $gestion_social_bitacora->imagen = $filename;
                $gestion_social_bitacora->save();
            }
        }else{
            if (!$request->file('photo')) {
                $gestion_social_bitacora->imagen = '';
                $gestion_social_bitacora->save();
            } else {
                $path = public_path().'/images/GestionAmbiental_bitacora/';
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filename = $gestion_social_bitacora->id . '.' . $extension;
                $request->file('photo')->move($path, $filename);
                $gestion_social_bitacora->imagen = $filename;
                $gestion_social_bitacora->save();
            }
        }

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la caracteristica";
        $respuesta['objeto']= $gestion_social_bitacora;

        return response()->json($respuesta);
    }


    public function gestion_bitacora_get_info(Request $request)
    {

        $gestion_social_bitacora = gestion_bitacora::where('id_gestion_social',$request->gestion_social_id_bitacora)
        ->get();

        return response()->json($gestion_social_bitacora);

    }

    public function delete_bitacora(Request $request)
    {

        $relacion = gestion_bitacora::find($request->id_bitacora);
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
