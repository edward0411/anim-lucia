<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_actividades_planeacion as uv_reporte_proyectos_actividades_planeacion; 


class ReporteProyectosActividadesPlaneacionController extends Controller
{
    //
    public function index(){

        $search = [];

        $proyectos = uv_reporte_proyectos_actividades_planeacion::select('id_proyecto','nombre_proyecto')
        ->distinct()
        ->orderBy('nombre_proyecto','asc')
        ->get();

        return view('reportes.reporte_proyectos_actividades_planeacion.index',compact('search','proyectos'));
    }

    public function busqueda_proyecto_actividad_planeacion(Request $request){
      
        $search = [];
        $olddata =$request->all();
        $id_proyecto = $request->id_proyecto;

        $consulta = uv_reporte_proyectos_actividades_planeacion::orderBy('id_proyecto');

        if ($request->id_proyecto != null){
          $consulta = $consulta->where('id_proyecto',$id_proyecto);
        }
          $consulta = $consulta->get();

        $search = $consulta;

        $proyectos = uv_reporte_proyectos_actividades_planeacion::select('id_proyecto','nombre_proyecto')
        ->distinct()
        ->orderBy('nombre_proyecto','asc')
        ->get();

        return view('reportes.reporte_proyectos_actividades_planeacion.index',compact('search','olddata','proyectos'));


  }
}
