<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos as uv_reporte_proyectos; 


class ReporteProyectosController extends Controller
{
    //
    public function index(){

        $proyectos = uv_reporte_proyectos::all();

        $departamentos = uv_reporte_proyectos::select('codigo_departamento','nombre_departamento')
        ->distinct()
        ->orderBy('nombre_departamento','asc')
        ->get();
      
        $search = [];

        return view('reportes.reporte_proyectos.index',compact('proyectos','search','departamentos'));
    }

    public function busqueda_proyecto(Request $request){

          $active = true;
          $search = [];
          $olddata =$request->all();

          $proyectos = uv_reporte_proyectos::all();

          $id_proyecto = $request->id_proyecto;

          $consulta = uv_reporte_proyectos::orderBy('id_proyecto');

          if ($request->id_proyecto != null){
 
            $consulta = $consulta->where('id_proyecto',$id_proyecto);
          }
          if ($request->id_departamento != null){
 
            $consulta = $consulta->where('codigo_departamento',$request->id_departamento);
          }

            $consulta = $consulta->get();

               $search = $consulta;

               $departamentos = uv_reporte_proyectos::select('codigo_departamento','nombre_departamento')
               ->distinct()
               ->orderBy('nombre_departamento','asc')
               ->get();

               return view('reportes.reporte_proyectos.index',compact('search','olddata','proyectos','active','departamentos'));
    }
}
