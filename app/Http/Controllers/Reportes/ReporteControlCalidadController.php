<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class ReporteControlCalidadController extends Controller
{
    public function index(){

        $proyectos = DB::table('calidad_seguridad_industriales')
        ->Join('calidad_seguridad_industrial_inspeccion_ensayos','calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
        ->Join('calidad_seguridad_industrial_equipos_obras','calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
        ->Join('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
        ->whereNull('calidad_seguridad_industriales.deleted_at')
        ->select('calidad_seguridad_industriales.id','proyectos.nombre_proyecto')
        ->get();
          // dd($proyectos);
          $search = [];

        return view('reportes.reporte_control_calidad.index',compact('proyectos','search'));
    }

    public function busqueda_control_calidad(Request $request){

        $active = true;
        $search = [];
        $olddata =$request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
   
            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_control_calidad.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }

          $proyectos = DB::table('calidad_seguridad_industriales')
          ->Join('calidad_seguridad_industrial_inspeccion_ensayos','calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->Join('calidad_seguridad_industrial_equipos_obras','calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->Join('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
          ->whereNull('calidad_seguridad_industriales.deleted_at')
          ->select('proyectos.id','proyectos.nombre_proyecto')
          ->distinct()
          ->get();

          $id_proyecto = $request->id_proyecto;

          $consulta = DB::table('calidad_seguridad_industriales')
          ->leftJoin('calidad_seguridad_industrial_inspeccion_ensayos','calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->leftJoin('calidad_seguridad_industrial_equipos_obras','calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->leftJoin('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
          ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
          ->where('proyectos_personas.param_tipo_rol_valor',1)
          ->leftJoin('proyecto_principal','proyecto_principal.id','=','proyectos.id_proyecto_principal')
          ->leftJoin('proyectos_caracteristicas','proyectos_caracteristicas.id_proyecto','=','proyectos.id')
          ->where('proyectos_caracteristicas.param_tipo_proyecto_caracteristica_valor',17)
          ->leftJoin('fases_relaciones_contratos','calidad_seguridad_industriales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
          ->leftJoin('users','calidad_seguridad_industriales.id_usuario','=','users.id')
          ->leftJoin('contratos','fases_relaciones_contratos.id_contrato','contratos.id')
          ->whereNull('contratos.deleted_at')
          ->whereNull('calidad_seguridad_industriales.deleted_at')
          ->whereNull('calidad_seguridad_industrial_inspeccion_ensayos.deleted_at')
          ->whereNull('calidad_seguridad_industrial_equipos_obras.deleted_at')
          ->whereNull('proyectos_personas.deleted_at')
          ->whereNull('proyecto_principal.deleted_at')
          ->whereNull('proyectos_caracteristicas.deleted_at')
          ->whereNull('fases_relaciones_contratos.deleted_at')
          ->whereNull('users.deleted_at')
          ->select('proyectos.id','proyectos.nombre_proyecto','users.name','contratos.numero_contrato',
                   'calidad_seguridad_industriales.fecha_informe','calidad_seguridad_industrial_inspeccion_ensayos.control_inspeccion_ensayos',
                   'calidad_seguridad_industrial_inspeccion_ensayos.recomendaciones','calidad_seguridad_industrial_inspeccion_ensayos.param_tipo_prueba_texto',
                   'calidad_seguridad_industrial_inspeccion_ensayos.unidad_ejecutora','calidad_seguridad_industrial_inspeccion_ensayos.nombre_especialista',
                   'calidad_seguridad_industrial_inspeccion_ensayos.localizacion','calidad_seguridad_industrial_equipos_obras.control_equipos_obra',
                   'calidad_seguridad_industrial_equipos_obras.recomendaciones as recomendaciones_obra','calidad_seguridad_industrial_equipos_obras.actividad_labor_realizada',
                    'calidad_seguridad_industrial_equipos_obras.equipo_utilizado','calidad_seguridad_industrial_equipos_obras.nombre_especialista as nombre_especialista_obra',
                    'proyecto_principal.nombre_proyecto_principal',
                    'proyectos_caracteristicas.decripcion_proyecto',
                    'proyectos_personas.para_tipo_subdireccion_texto'
                );

          if ($request->id_proyecto != null){
 
            $consulta = $consulta->where('proyectos.id',$id_proyecto);

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

        return view('reportes.reporte_control_calidad.index',compact('search','olddata','proyectos','active'));
    }
}
