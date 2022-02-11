<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\semanas_parametrica as semanas_parametrica;
use App\Models\fases_actividades_planeacion as fases_actividades_planeacion;

class ReporteAvanceEjecucionController extends Controller
{
    public function index()
    {

        $hoy = Carbon::now()->format('Y-m-d');

        $id_semanas_parametrica = semanas_parametrica::where('fecha_inicial', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->select('id')
            ->first();

        $id_semana = $id_semanas_parametrica->id;
        $id_semana_ant = $id_semana - 1;

        $array_id_actividades = [];

        $consulta = fases_actividades_planeacion::leftJoin('fases_actividades', 'fases_actividades.id', '=', 'fases_actividades_planeacion.id_fase_actividad')
            ->leftJoin('fases_planes', 'fases_planes.id', '=', 'fases_actividades.id_fase_plan')
            ->leftJoin('fases', 'fases.id', '=', 'fases_planes.id_fase')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'fases.id_proyecto')
            ->where('fases_actividades_planeacion.id_semana_parametrica', $id_semana)
            ->whereNull('proyectos.deleted_at')
            ->whereNull('fases.deleted_at')
            ->whereNull('fases_planes.deleted_at')
            ->whereNull('fases_actividades.deleted_at')
            ->whereNull('fases_actividades_planeacion.deleted_at')
            ->select(
                'proyectos.id as id_proyecto',
                'proyectos.nombre_proyecto',
                'fases.param_tipo_fase_texto as nombre_etapa',
                'fases_planes.nombre_plan as nombre_hito',
                'fases_actividades.id as id_actividad',
                'fases_actividades.nombre_actividad',
                'fases_actividades_planeacion.porcentaje_programado as programado',
                'fases_actividades_planeacion.porcentaje_ejecutado as ejecutado'
            )
            ->get();

            //dd($consulta);

        foreach ($consulta as $value) {
            array_push($array_id_actividades, $value->id_actividad);

            $consulta_ant = fases_actividades_planeacion::where('id_semana_parametrica', $id_semana_ant)
                ->where('id_fase_actividad', $value->id_actividad)
                ->select('porcentaje_programado', 'porcentaje_ejecutado')
                ->first();

            if ($consulta_ant == null) {

                $value->programado_ant = null;
                $value->ejecutado_ant = null;
            } else {

                $value->programado_ant = $consulta_ant->porcentaje_programado;
                $value->ejecutado_ant = $consulta_ant->porcentaje_ejecutado;
            }
        }

        $actividades = $consulta->toArray();

        $consulta = fases_actividades_planeacion::leftJoin('fases_actividades', 'fases_actividades.id', '=', 'fases_actividades_planeacion.id_fase_actividad')
            ->leftJoin('fases_planes', 'fases_planes.id', '=', 'fases_actividades.id_fase_plan')
            ->leftJoin('fases', 'fases.id', '=', 'fases_planes.id_fase')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'fases.id_proyecto')
            ->where('fases_actividades_planeacion.id_semana_parametrica', $id_semana_ant)
            ->whereNotIn('id_fase_actividad', $array_id_actividades)
            ->whereNull('proyectos.deleted_at')
            ->whereNull('fases.deleted_at')
            ->whereNull('fases_planes.deleted_at')
            ->whereNull('fases_actividades.deleted_at')
            ->whereNull('fases_actividades_planeacion.deleted_at')
            ->select(
                'proyectos.id as id_proyecto',
                'proyectos.nombre_proyecto',
                'fases.param_tipo_fase_texto as nombre_etapa',
                'fases_planes.nombre_plan as nombre_hito',
                'fases_actividades.id as id_actividad',
                'fases_actividades.nombre_actividad',
                'fases_actividades_planeacion.porcentaje_programado as programado',
                'fases_actividades_planeacion.porcentaje_ejecutado as ejecutado'
            )
            ->get();

        $actividades_sem_ant = $consulta->toArray();
        
        dd($actividades);

        return view('reportes.reporte_avance_ejecucion.index', compact('actividades', 'actividades_sem_ant'));
    }
}
