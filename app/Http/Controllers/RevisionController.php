<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revision as revision;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class RevisionController extends Controller
{
    public function store(Request $request)
    {
       switch ($request->tipo_modulo) {
            case '1':
                $modulo = 'supervisiones.crear_info';
                $tabla = 'supervisiones';
            break;

            case '2':
                $modulo = 'gestion_social.crear_info';
                $tabla = 'gestiones_sociales';
            break;

            case '3':
                $modulo = 'gestion_ambientales.crear_info';
                $tabla = 'gestiones_ambientales';
            break;

            case '4':
                $modulo = 'gestion_calidad_seguridad.crear_info';
                $tabla = 'calidad_seguridad_industriales';
            break; 
              
            case '5':
                $modulo = 'informe_semanal.crear_ejecucion_semanal';
                $tabla = 'fases_actividades_planeacion';
            break;
       }

       $id_usuario = Auth::user()->id;
       $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');
       $id_registro = $request->revision_id_modulo;

       $registro = new revision();
       $registro->id_usuario_revisa = $id_usuario;
       $registro->fecha_revision = $fecha_hoy;
       $registro->modulo = $modulo;
       $registro->tabla_bd = $tabla;
       $registro->id_registro = $id_registro;
       $registro->created_by = Auth::user()->id;
       $registro->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la bitaora";
        $respuesta['objeto']= $registro;
    
        return response()->json($respuesta);
    }

    public function get_info(Request $request)
    {

        switch ($request->tipo_modulo) {
            case '1':
                $modulo = 'supervisiones.crear_info'; 
            break;

            case '2':
                $modulo = 'gestion_social.crear_info'; 
            break;

            case '3':
                $modulo = 'gestion_ambientales.crear_info'; 
            break;

            case '4':
                $modulo = 'gestion_calidad_seguridad.crear_info'; 
            break;
            case '5':
                $modulo = 'informe_semanal.crear_ejecucion_semanal';
    
            break;
       }

       $datos = revision::where('modulo',$modulo)
       ->where('id_registro',$request->id_registro)
       ->get();

       foreach ($datos as $value) {
           $user = $value->Users()->select('name')->first();
           $value->nombre = $user['name'];
       }

       return response()->json($datos);
    }

    public function delete(Request $request)
    {
        $revision = revision::find($request->id_revision);

        $revision->deleted_by = Auth::user()->id;
        $revision->save();
    
        $informacionlog = 'Se ha eliminado la informacion del integrante';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $revision,
                ];
    
        Log::channel('database')->info(
            $informacionlog ,
            $objetolog
        );
    
        $revision->delete();

        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$revision;
    
    
        return response()->json($respuesta);
    }
}
