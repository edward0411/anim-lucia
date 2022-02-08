<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_ejecucion_actualizada as ejecucion_actualizada; 
use App\Models\Proyectos as proyectos;
use Illuminate\Support\Facades\DB;
use App\Models\semanas_parametrica as semanas;
use Carbon\Carbon;
use App\Models\fases_actividades_planeacion as fases_actividades_planeacion;

class ReporteEjecucionActualizadaController extends Controller
{
    public function index()
    {
        $search = [];

        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

        return view('reportes.reporte_ejecucion_actualizada.index',compact('proyectos','search'));
    }

    public function busqueda(Request $request){

        $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');

        $semana = semanas::where('fecha_inicial','<=',$fecha_hoy)
        ->where('fecha_fin','>=',$fecha_hoy)
        ->select('id')
        ->first();

        $consulta = ejecucion_actualizada::orderBy('id_fase');
        
            if ($request->id_proyecto != null){
                $consulta = $consulta->where('id_fase','=',$request->id_proyecto);
            }

            $consulta = $consulta->get();
            $search = $consulta;

         foreach ($search as $value) {

            $fases = DB::select('call usp_proyecto_consultarAvanceFase(?)',array($value->id_fase));

            foreach ($fases as $fase) {

                if ($fase->id == $value->id_etapa) {
                   $value->etapa_programado = $fase->porcentaje_programado;
                   $value->etapa_ejecutado = $fase->porcentaje_ejecutado;
                }
            }

            $fases_planes =DB::select('call usp_Consulta_Avance_hitos(?,?)',array($value->id_fase,$semana->id));

            foreach($fases_planes as $hito)
            {
                if($hito->id == $value->id_hito){
                   $value->avance_hito_programado = $hito->programadosemana;
                   $value->avance_hito_ejecutado = $hito->porcentaje_ejecutado;
                }
            }

            $datos = fases_actividades_planeacion::where('id_fase_actividad', $value->id_actividad)
            ->whereNull('deleted_at')
            ->select(DB::raw('sum(porcentaje_programado) as programado'),DB::raw('sum(porcentaje_ejecutado) as ejecutado'),DB::raw('max(updated_at) as fecha_actualizacion'))
            ->get();

           // dd($datos);

            $value->avance_actividad_programado = $datos[0]->programado;
            $value->avance_actividad_ejecutado = $datos[0]->ejecutado;
            $value->fecha_actualizacion = $datos[0]->fecha_actualizacion;

         }
         // dd($search );

        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

        //dd($search);
   
         return view('reportes.reporte_ejecucion_actualizada.index',compact('proyectos','search'));

    }
}
