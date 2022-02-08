<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_actividades as uv_reporte_proyectos_actividades; 


class ReporteProyectosActividadesController extends Controller
{
    public function index(){

        $proyectos_actividad = uv_reporte_proyectos_actividades::all();
        $search = [];

        $proyectos = uv_reporte_proyectos_actividades::select('id_proyecto','nombre_proyecto')
        ->distinct()
        ->orderBy('nombre_proyecto','asc')
        ->get();

        $fases = uv_reporte_proyectos_actividades::select('tipo_fase')
        ->distinct()
        ->orderBy('tipo_fase','asc')
        ->get();

        return view('reportes.reporte_proyectos_actividades.index',compact('proyectos_actividad','search','fases','proyectos'));
    }

    public function busqueda_proyecto_actividad(Request $request){
       
        // dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();

        
        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {

            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_proyectos_actividades.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }

        $proyectos_actividad = uv_reporte_proyectos_actividades::all();

        $id_proyecto = $request->id_proyecto;

        $consulta = uv_reporte_proyectos_actividades::orderBy('id_proyecto');

        if ($request->id_proyecto != null){

          $consulta = $consulta->where('id_proyecto',$id_proyecto);
        }
        if ($request->tipo_fase != null){

          $consulta = $consulta->where('tipo_fase',$request->tipo_fase);
        }
        
        if ($request->fecha_hasta != null){
            
            $consulta = $consulta->where('fase_fecha_inicio','<=',$request->fecha_hasta);
        }
        
        if ($request->fecha_desde != null){
 
            $consulta = $consulta->where('fase_fecha_inicio','>=',$request->fecha_desde);

        }
          $consulta = $consulta->get();

          // dd($consulta);
             $search = $consulta;

             $proyectos = uv_reporte_proyectos_actividades::select('id_proyecto','nombre_proyecto')
             ->distinct()
             ->orderBy('nombre_proyecto','asc')
             ->get();
     
             $fases = uv_reporte_proyectos_actividades::select('tipo_fase')
             ->distinct()
             ->orderBy('tipo_fase','asc')
             ->get();

             return view('reportes.reporte_proyectos_actividades.index',compact('search','olddata','proyectos_actividad','active','fases','proyectos'));


  }
}
