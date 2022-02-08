<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestiones_ambientales_fuente_materiales as gestiones_ambientales_fuente_materiales;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

  //Se actulizo
class Gestiones_ambientales_fuente_materialesController extends Controller
{

//
    public function fuente_materiales_store(Request $request){

        $gestiones_ambientales_fuente_materiales = gestiones_ambientales_fuente_materiales::find($request->id_Fuente_materiales);

        if($gestiones_ambientales_fuente_materiales  == null )
        {
            if(isset($request->id_Fuente_materiales_crear) &&  $request->id_Fuente_materiales_crear == 1)
            {
             $gestiones_ambientales_fuente_materiales  = new gestiones_ambientales_fuente_materiales();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $gestiones_ambientales_fuente_materiales ;
                return response()->json($respuesta);
            }
        }

         $gestiones_ambientales_fuente_materiales->id_gestiones_ambientales  = $request->fuente_materiales_id_gestion_ambiental;
         $gestiones_ambientales_fuente_materiales->id_municipios  = $request->id_municipio;
         $gestiones_ambientales_fuente_materiales->ubicacion  = $request->ubicacion;
         $gestiones_ambientales_fuente_materiales->permiso_minero = $request->permiso_minero;
         $gestiones_ambientales_fuente_materiales->permiso_ambiental = $request->permiso_ambiental;
         $gestiones_ambientales_fuente_materiales->observaciones = $request->observaciones_ambiental;
        
         
         if($request->id_Fuente_materiales==0)
         {
             $gestiones_ambientales_fuente_materiales->created_by = Auth::user()->id;
         }else {
             $gestiones_ambientales_fuente_materiales->updated_by = Auth::user()->id;
         }
         $gestiones_ambientales_fuente_materiales->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $gestiones_ambientales_fuente_materiales;

          return response()->json($respuesta);

    }

    public function fuente_materiales_get_info(Request $request){

        $gestiones_ambientales_fuente_materiales = gestiones_ambientales_fuente_materiales::where('id_gestiones_ambientales',$request->fuente_materiales_id_gestion_ambiental)
        ->join('municipios','gestiones_ambientales_fuente_materiales.id_municipios','=','municipios.id')
        ->join('departamentos','municipios.id_departamento','=','departamentos.id')
        ->select('gestiones_ambientales_fuente_materiales.id','departamentos.nombre_departamento','departamentos.id as id_departamento',
        'municipios.id as id_municipio','municipios.nombre_municipio','gestiones_ambientales_fuente_materiales.ubicacion',
        'gestiones_ambientales_fuente_materiales.permiso_minero','gestiones_ambientales_fuente_materiales.permiso_ambiental',
        DB::raw("case gestiones_ambientales_fuente_materiales.permiso_minero when 'S' then 'Si' when 'N' then 'No' when 'X' then 'No aplica' end permiso_minero_descripcion") ,
        DB::raw("case gestiones_ambientales_fuente_materiales.permiso_ambiental when 'S' then 'Si' when 'N' then 'No' when 'X' then 'No aplica' end permiso_ambiental_descripcion"),
        'gestiones_ambientales_fuente_materiales.observaciones')
        ->get();

        return response()->json($gestiones_ambientales_fuente_materiales);

    }

    public function delete_fuente_materiales(Request $request)
        {
            $relacion = gestiones_ambientales_fuente_materiales::find($request->id_Fuente_materiales);
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
