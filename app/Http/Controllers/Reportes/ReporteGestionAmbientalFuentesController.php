<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReporteGestionAmbientalFuentesController extends Controller
{
    //
    public function index(){

        $proyectos = DB::table('gestiones_ambientales')
        ->Join('gestiones_ambientales_fuente_materiales','gestiones_ambientales_fuente_materiales.id_gestiones_ambientales','=','gestiones_ambientales.id')
        ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
        ->whereNull('gestiones_ambientales.deleted_at')
        ->select('gestiones_ambientales.id','proyectos.nombre_proyecto')
        ->get();
        // dd($proyectos);
        $search = [];
        return view('reportes.reporte_gestion_ambiental_fuentes.index',compact('proyectos','search'));
    }

    public function busqueda_gestion_ambiental_fuentes(Request $request){

        $active = true;
        $search = [];
        $olddata =$request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {

            if ($request->fecha_hasta < $request->fecha_desde) {
                return redirect()->route('reportes.reporte_gestion_ambiental_fuentes.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
            }
        }

          $proyectos = DB::table('gestiones_ambientales')
          ->join('gestiones_ambientales_fuente_materiales','gestiones_ambientales_fuente_materiales.id_gestiones_ambientales','=','gestiones_ambientales.id')
          ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
          ->whereNull('gestiones_ambientales.deleted_at')
          ->select('gestiones_ambientales.id','proyectos.nombre_proyecto')
          ->get();

        $id_proyecto = $request->id_proyecto;

        $consulta = DB::table('gestiones_ambientales')
        ->join('gestiones_ambientales_fuente_materiales','gestiones_ambientales_fuente_materiales.id_gestiones_ambientales','=','gestiones_ambientales.id')
        ->Join('proyectos','gestiones_ambientales.id_proyecto','=','proyectos.id')
        ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
        ->where('proyectos_personas.param_tipo_rol_valor',1)
        ->leftJoin('proyecto_principal','proyecto_principal.id','=','proyectos.id_proyecto_principal')
        ->leftJoin('proyectos_caracteristicas','proyectos_caracteristicas.id_proyecto','=','proyectos.id')
        ->where('proyectos_caracteristicas.param_tipo_proyecto_caracteristica_valor',17)
        ->Join('fases_relaciones_contratos','gestiones_ambientales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
        ->Join('users','gestiones_ambientales.id_usuario','=','users.id')
        ->Join('contratos','fases_relaciones_contratos.id_contrato','contratos.id')
        ->Join('municipios','gestiones_ambientales_fuente_materiales.id_municipios','=','municipios.id')
        ->Join('departamentos','municipios.id_departamento','=','departamentos.id')
        ->whereNull('gestiones_ambientales.deleted_at')
        ->select('gestiones_ambientales.id','proyectos.id as id_p','proyectos.nombre_proyecto','users.name','gestiones_ambientales.fecha_informe','gestiones_ambientales_fuente_materiales.ubicacion',
        'gestiones_ambientales_fuente_materiales.permiso_minero','gestiones_ambientales_fuente_materiales.permiso_ambiental','gestiones_ambientales_fuente_materiales.observaciones','municipios.nombre_municipio',
        'departamentos.nombre_departamento','contratos.numero_contrato','proyecto_principal.nombre_proyecto_principal','proyectos_caracteristicas.decripcion_proyecto','proyectos_personas.para_tipo_subdireccion_texto');

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

        return view('reportes.reporte_gestion_ambiental_fuentes.index',compact('search','olddata','proyectos','active'));
    }
}
