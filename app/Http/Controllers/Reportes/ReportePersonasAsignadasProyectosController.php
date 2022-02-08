<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos as proyectos;
use App\Models\reportes\uv_reporte_personas_asignadas_proyectos as reporte_personas; 

class ReportePersonasAsignadasProyectosController extends Controller
{
    public function index()
    {
        $search = [];

        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

      
        return view('reportes.reporte_proyectos_personas.index',compact('search','proyectos'));
    }

    public function busqueda(Request $request)
    {
        //dd($request);

        $consulta = reporte_personas::orderBy('id');
        
           if ($request->id_proyecto != null){
   
               $consulta = $consulta->where('id','=',$request->id_proyecto);
   
           }
   
           $consulta = $consulta->get();

          $search = $consulta;
   
        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

        //dd($search);
      
        return view('reportes.reporte_proyectos_personas.index',compact('search','proyectos'));
    }
}
