<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class ReporteControlSeguridadIndustrialController extends Controller
{
    public function index(){

        $proyectos = DB::table('calidad_seguridad_industriales')
        ->Join('calidad_seguridad_industrial_seguridad_industrial','calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
        ->Join('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
        ->whereNull('calidad_seguridad_industriales.deleted_at')
        ->select('calidad_seguridad_industriales.id','proyectos.nombre_proyecto')
        ->get();
          // dd($proyectos);
          $search = [];

        return view('reportes.reporte_control_seguridad_industrial.index',compact('proyectos','search'));

    }

    public function busqueda_control_seguridad_industrial(Request $request){

        $active = true;
        $search = [];
        $olddata =$request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
   
            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_control_seguridad_industrial.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }

         $proyectos = DB::table('calidad_seguridad_industriales')
        ->Join('calidad_seguridad_industrial_seguridad_industrial','calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
        ->Join('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
        ->whereNull('calidad_seguridad_industriales.deleted_at')
        ->select('calidad_seguridad_industriales.id','proyectos.nombre_proyecto')
        ->get();

          $id_proyecto = $request->id_proyecto;

          $consulta = DB::table('calidad_seguridad_industriales')
          ->leftjoin('calidad_seguridad_industrial_actividades_realizadas','calidad_seguridad_industrial_actividades_realizadas.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->Join('calidad_seguridad_industrial_seguridad_industrial','calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial','=','calidad_seguridad_industriales.id')
          ->Join('proyectos','calidad_seguridad_industriales.id_proyecto','proyectos.id')
          ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
          ->where('proyectos_personas.param_tipo_rol_valor',1)
          ->leftJoin('proyecto_principal','proyecto_principal.id','=','proyectos.id_proyecto_principal')
          ->Join('fases_relaciones_contratos','calidad_seguridad_industriales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
          ->Join('users','calidad_seguridad_industriales.id_usuario','=','users.id')
          ->Join('contratos','fases_relaciones_contratos.id_contrato','contratos.id')
          ->whereNull('calidad_seguridad_industriales.deleted_at')
          ->select('calidad_seguridad_industriales.id','proyectos.nombre_proyecto','users.name','contratos.numero_contrato','calidad_seguridad_industriales.fecha_informe',
                   'calidad_seguridad_industrial_seguridad_industrial.accidente_laboral_incidente','calidad_seguridad_industrial_seguridad_industrial.param_tipo_accidente_texto',
                'calidad_seguridad_industrial_seguridad_industrial.fecha','calidad_seguridad_industrial_seguridad_industrial.plan_mejora_leccion_aprendida',
                'calidad_seguridad_industrial_seguridad_industrial.adoptado'
                ,'proyecto_principal.nombre_proyecto_principal',
                'proyectos_personas.para_tipo_subdireccion_texto',
                'calidad_seguridad_industrial_actividades_realizadas.de_medida_preventiva',
                'calidad_seguridad_industrial_actividades_realizadas.actividades_higiene_seguridad_industrial');

          if ($request->id_proyecto != null){
 
            $consulta = $consulta->where('calidad_seguridad_industriales.id',$id_proyecto);

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

       return view('reportes.reporte_control_seguridad_industrial.index',compact('search','olddata','proyectos','active'));
    }
}
