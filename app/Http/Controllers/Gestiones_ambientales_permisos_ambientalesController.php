<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestiones_ambientales_permisos_ambientales as gestiones_ambientales_permisos_ambientales;
use App\Models\Parametricas as parametricas;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class Gestiones_ambientales_permisos_ambientalesController extends Controller
{
   
//
    public function permisos_ambientales_store(Request $request){

        if($request->file('file')) {

            $rules['file'] = 'mimes:jpeg,bmp,png,gif,svg,pdf|max:3000';
            $messages['file.mimes'] ='El formato del documento no es compatible con las soportadas por el sistema.';
            $messages['file.max'] ='El tamaño del documento no es compatible con la requerida para el sistema.';
    
            $this->validate($request, $rules, $messages);
        }

        $gestiones_ambientales_permisos_ambientales = gestiones_ambientales_permisos_ambientales::find($request->id_permisos_ambientales);

        $gestiones_ambientales_permisos_ambientalesExiste = gestiones_ambientales_permisos_ambientales::Where(
                                                    [['id_gestiones_ambientales','=',$request->permisos_ambientales_id_gestion_ambiental],
                                                    ['id','<>',$request->id_permisos_ambientales],
                                                    ['param_tipo_permiso_valor','=',$request->tipo_permiso]])
                                                    ->get();
        if ($gestiones_ambientales_permisos_ambientalesExiste->count() >0)
        {
            $rules['Existe_1'] = 'required';
            $messages['Existe_1.required'] ='El Tipo de Permiso Ambiental ya existe.';
            $this->validate($request, $rules, $messages);
        }


        if($gestiones_ambientales_permisos_ambientales  == null )
        {
            if(isset($request->id_permisos_ambientales_crear) &&  $request->id_permisos_ambientales_crear == 1)
            {
             $gestiones_ambientales_permisos_ambientales  = new gestiones_ambientales_permisos_ambientales();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $gestiones_ambientales_permisos_ambientales ;
                return response()->json($respuesta);
            }
        }

         $gestiones_ambientales_permisos_ambientales->id_gestiones_ambientales = $request->permisos_ambientales_id_gestion_ambiental;
         $gestiones_ambientales_permisos_ambientales->param_tipo_permiso_valor = $request->tipo_permiso;
         $gestiones_ambientales_permisos_ambientales->param_tipo_permiso_text =   Parametricas::getTextFromValue('gestionesAambientales.permisos_ambientales', $request->tipo_permiso);
         $gestiones_ambientales_permisos_ambientales->otro_permiso  = $request->otro_permiso;
         $gestiones_ambientales_permisos_ambientales->documento_soporte = $request->documento_soporte;
         $gestiones_ambientales_permisos_ambientales->seguimiento = $request->seguimiento;
         $gestiones_ambientales_permisos_ambientales->observaciones = $request->observaciones_permiso;
        
         
         if($request->id_permisos_ambientales==0)
         {
             $gestiones_ambientales_permisos_ambientales->created_by = Auth::user()->id;
         }else {
             $gestiones_ambientales_permisos_ambientales->updated_by = Auth::user()->id;
         }
         $gestiones_ambientales_permisos_ambientales->save();

         if($gestiones_ambientales_permisos_ambientales->updated_by != null){
            if (!$request->file('file')) {
                if ($gestiones_ambientales_permisos_ambientales->documento_ambiental == '' || $gestiones_ambientales_permisos_ambientales->documento_ambiental == null) {
                    $gestiones_ambientales_permisos_ambientales->documento_ambiental = '';
                    $gestiones_ambientales_permisos_ambientales->save();
                }
            } else {
                $path = public_path().'/images/GestionAmbiental_permisosAmbientales/';
                $extension = $request->file('file')->getClientOriginalExtension();
                $filename = 'Documento'.$gestiones_ambientales_permisos_ambientales->id . '.' . $extension;
                $request->file('file')->move($path, $filename);
                $gestiones_ambientales_permisos_ambientales->documento_ambiental = $filename;
                $gestiones_ambientales_permisos_ambientales->save();
            }
        }else{
            if (!$request->file('file')) {
                $gestiones_ambientales_permisos_ambientales->documento_ambiental = '';
                $gestiones_ambientales_permisos_ambientales->save();
            } else {
                $path = public_path().'/images/GestionAmbiental_permisosAmbientales/';
                $extension = $request->file('file')->getClientOriginalExtension();
                $filename = 'Documento'.$gestiones_ambientales_permisos_ambientales->id . '.' . $extension;
                $request->file('file')->move($path, $filename);
                $gestiones_ambientales_permisos_ambientales->documento_ambiental = $filename;
                $gestiones_ambientales_permisos_ambientales->save();
            }
        }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $gestiones_ambientales_permisos_ambientales;

          return response()->json($respuesta);

    }

    public function permisos_ambientales_get_info(Request $request){

        $gestiones_ambientales_permisos_ambientales = gestiones_ambientales_permisos_ambientales::where('id_gestiones_ambientales',$request->permisos_ambientales_id_gestion_ambiental)
        ->get();

        return response()->json($gestiones_ambientales_permisos_ambientales);

    }

    public function delete_permisos_ambientales(Request $request)
        {
            $relacion = gestiones_ambientales_permisos_ambientales::find($request->id_permisos_ambientales);
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
