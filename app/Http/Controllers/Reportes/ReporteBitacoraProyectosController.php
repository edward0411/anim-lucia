<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\semanas_parametrica as semanas_parametrica;
use App\Models\Proyectos as proyectos;
use Illuminate\Support\Facades\DB;

class ReporteBitacoraProyectosController extends Controller
{
    public function index()
    {
        $search = [];

        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

      
        return view('reportes.reporte_proyectos_bitacora.index',compact('search','proyectos'));
    }

    public function busqueda(Request $request)
    {
       
        $dia = $request->fecha;

        $id_semanas_parametrica = semanas_parametrica::where('fecha_inicial', '<=', $dia)
            ->where('fecha_fin', '>=', $dia)
            ->select('id')
            ->first();

        $id_semana = $id_semanas_parametrica->id;
        $id_semana_ant = $id_semana - 1;

        $id_proyecto = -99;

        if ($request->id_proyecto != null) {
            $id_proyecto = $request->id_proyecto;
        }

       $consulta = DB::select('call usp_reporte_proyecto_bitacoras (?,?,?)',array($id_proyecto, $id_semana, $id_semana_ant));

       $search = $consulta;

       $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

        return view('reportes.reporte_proyectos_bitacora.index', compact('search','proyectos','id_semana'));
    }
}
