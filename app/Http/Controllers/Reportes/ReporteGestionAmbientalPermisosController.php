<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class ReporteGestionAmbientalPermisosController extends Controller
{
    public function index(){

        $proyectos = DB::table('gestiones_ambientales')
        ->join('gestiones_ambientales_permisos_ambientales','gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales','=','gestiones_ambientales.id')
        ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
        ->select('gestiones_ambientales.id','proyectos.nombre_proyecto')
        ->get();
        // dd($proyectos);
        $search = [];

        return view('reportes.reporte_gestion_ambiental_permisos.index',compact('proyectos','search'));
    }

    public function busqueda_gestion_ambiental_permisos(Request $request){

        //dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
   
            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_gestion_ambiental_permisos.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }
          $proyectos = DB::table('gestiones_ambientales')
          ->join('gestiones_ambientales_permisos_ambientales','gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales','=','gestiones_ambientales.id')
          ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
          ->select('gestiones_ambientales.id','proyectos.nombre_proyecto')
          ->get();

          $id_proyecto = $request->id_proyecto;

          $consulta = DB::table('gestiones_ambientales')
          ->join('gestiones_ambientales_permisos_ambientales','gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales','=','gestiones_ambientales.id')
          ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
          ->leftJoin('proyecto_principal','proyecto_principal.id','=','proyectos.id_proyecto_principal')
          ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
          ->where('proyectos_personas.param_tipo_rol_valor',1)
          ->Join('fases_relaciones_contratos','gestiones_ambientales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
          ->Join('users','gestiones_ambientales.id_usuario','=','users.id')
          ->Join('contratos','fases_relaciones_contratos.id_contrato','contratos.id')
          ->whereNull('gestiones_ambientales.deleted_at')
          ->select('gestiones_ambientales.id','proyectos.nombre_proyecto','users.name','gestiones_ambientales.fecha_informe','gestiones_ambientales_permisos_ambientales.param_tipo_permiso_text',
          'gestiones_ambientales_permisos_ambientales.documento_soporte','gestiones_ambientales_permisos_ambientales.seguimiento','gestiones_ambientales_permisos_ambientales.observaciones',
          'contratos.numero_contrato','proyecto_principal.nombre_proyecto_principal','proyectos_personas.para_tipo_subdireccion_texto');
          if ($request->id_proyecto != null){
 
            $consulta = $consulta->where('gestiones_ambientales.id',$id_proyecto);

        }
        if ($request->fecha_hasta != null){
   
            $consulta = $consulta->where('fecha_informe','<=',$request->fecha_hasta);

        }
        if ($request->fecha_desde != null){

            $consulta = $consulta->where('fecha_informe','>=',$request->fecha_desde);
        }
        $consulta = $consulta->get();
        $search = $consulta->toArray();
      // dd($search);

      return view('reportes.reporte_gestion_ambiental_permisos.index',compact('search','olddata','proyectos','active'));

    }
}
