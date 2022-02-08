<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_licencias as uv_reporte_proyectos_licencias; 
use App\Models\Proyectos as proyectos;

class ReporteProyectosLicenciasController extends Controller
{
    public function index()
    {
        $search = [];

        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

      
        return view('reportes.reporte_proyectos_licencias.index',compact('search','proyectos'));
    }

    public function busqueda(Request $request)
    {
        $consulta = uv_reporte_proyectos_licencias::orderBy('id_fase');
        
           if ($request->id_proyecto != null){
   
               $consulta = $consulta->where('id_fase','=',$request->id_proyecto);
   
           }
   
           $consulta = $consulta->get();

          $search = $consulta;
   
        $proyectos = proyectos::select('id','nombre_proyecto')
        ->whereNull('deleted_at')
        ->get();

        //dd($search);
      
        return view('reportes.reporte_proyectos_licencias.index',compact('search','proyectos'));
    }
}
