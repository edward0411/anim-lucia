<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_caracteristicas as uv_reporte_proyectos_caracteristicas; 


class ReporteProyectosCaracteristicasController extends Controller
{
    //
    public function index(){

        $proyecto_caracteristica = uv_reporte_proyectos_caracteristicas::all();
        $search = [];

        $proyectos = uv_reporte_proyectos_caracteristicas::select('id_proyecto','nombre_proyecto')
        ->distinct()
        ->orderBy('nombre_proyecto','asc')
        ->get();

        $caracteristicas = uv_reporte_proyectos_caracteristicas::select('caracteristica')
        ->distinct()
        ->orderBy('caracteristica','asc')
        ->get();

        return view('reportes.reporte_proyectos_caracteristicas.index',compact('proyecto_caracteristica','search','proyectos','caracteristicas'));
    }

    public function busqueda_proyecto_caracteristica(Request $request){
       
        // dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();

        $proyecto_caracteristica = uv_reporte_proyectos_caracteristicas::all();

        $id_proyecto = $request->id_proyecto;

        $consulta = uv_reporte_proyectos_caracteristicas::orderBy('id_proyecto');

        if ($request->id_proyecto != null){

          $consulta = $consulta->where('id_proyecto',$id_proyecto);
        }
        if ($request->caracteristica != null){

          $consulta = $consulta->where('caracteristica',$request->caracteristica);
        }

          $consulta = $consulta->get();

          $search = $consulta;

          $proyectos = uv_reporte_proyectos_caracteristicas::select('id_proyecto','nombre_proyecto')
          ->distinct()
          ->orderBy('nombre_proyecto','asc')
          ->get();

          $caracteristicas = uv_reporte_proyectos_caracteristicas::select('caracteristica')
          ->distinct()
          ->orderBy('caracteristica','asc')
          ->get();

            return view('reportes.reporte_proyectos_caracteristicas.index',compact('search','olddata','proyecto_caracteristica','active','proyectos','caracteristicas'));
  }
}
