<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_convenios as uv_reporte_proyectos_convenios; 


class ReporteProyectosConveniosController extends Controller
{
    //
    public function index(){

        $proyecto_convenio = uv_reporte_proyectos_convenios::all();
        $search = [];

        $proyectos = uv_reporte_proyectos_convenios::select('id_proyecto','nombre_proyecto')
        ->distinct()
        ->orderBy('nombre_proyecto','asc')
        ->get();


        return view('reportes.reporte_proyectos_convenios.index',compact('proyecto_convenio','search','proyectos'));
    }
    public function busqueda_proyecto_convenio(Request $request){
       
        // dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();

        $proyecto_convenio = uv_reporte_proyectos_convenios::all();

        $id_proyecto = $request->id_proyecto;

        $consulta = uv_reporte_proyectos_convenios::orderBy('id_proyecto');

        if ($request->id_proyecto != null){

          $consulta = $consulta->where('id_proyecto',$id_proyecto);
        }
        if ($request->id_convenio != null){

          $consulta = $consulta->where('id_convenio',$request->id_convenio);
        }

          $consulta = $consulta->get();

          // dd($consulta);
             $search = $consulta;

             $proyectos = uv_reporte_proyectos_convenios::select('id_proyecto','nombre_proyecto')
            ->distinct()
            ->orderBy('nombre_proyecto','asc')
            ->get();

             return view('reportes.reporte_proyectos_convenios.index',compact('search','olddata','proyecto_convenio','active','proyectos'));


  }
}
