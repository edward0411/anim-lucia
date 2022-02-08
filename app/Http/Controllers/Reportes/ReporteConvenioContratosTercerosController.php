<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_contratos_supervision as uv_reporte_contratos_supervision; 
use App\Models\Parametricas as parametricas;


class ReporteConvenioContratosTercerosController extends Controller
{
    //
    public function index(){

        $convenio_terceros = uv_reporte_contratos_supervision::all();

        $dependencias = parametricas::getFromCategory('contratos.dependencia');

        $search = [];

        return view('reportes.reporte_convenio_contratos_terceros.index',compact('convenio_terceros','search','dependencias'));
    }

    public function busqueda_terceros(Request $request){

        // dd($request);
         $active = true;
         $search = [];
         $olddata =$request->all();
 
 
         if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
 
             if ($request->fecha_hasta < $request->fecha_desde) {
 
                 return redirect()->route('reportes.reporte_convenio_contratos_terceros.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
              }
           }     
      $convenio_terceros = uv_reporte_contratos_supervision::all();
 
      $id_convenio = $request->id_convenio;
 
      $consulta = uv_reporte_contratos_supervision::orderBy('id_convenio');
      
         if ($request->id_convenio != null){
 
            $consulta = $consulta->where('id_convenio',$id_convenio);
 
        }
        if ($request->vigencia != null){
  
         $consulta = $consulta->where('vigencia',$request->vigencia);
 
     }
     if ($request->dependencia != null){
 
         $consulta = $consulta->where('dependencia',$request->dependencia);
     }
         if ($request->fecha_hasta != null){
 
             $consulta = $consulta->where('fecha_inicio','<=',$request->fecha_hasta);
 
         }
         if ($request->fecha_desde != null){

             $consulta = $consulta->where('fecha_inicio','>=',$request->fecha_desde);
         } 
         $consulta = $consulta->get();
        $search = $consulta;

        $dependencias = parametricas::getFromCategory('contratos.dependencia');

           return view('reportes.reporte_convenio_contratos_terceros.index',compact('search','olddata','convenio_terceros','active','dependencias'));
        }
}
