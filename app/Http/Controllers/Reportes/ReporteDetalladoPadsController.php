<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contratos as contratos;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\reportes\uv_reporte_pads as uv_reporte_pads; 


class ReporteDetalladoPadsController extends Controller
{
    //
    public function index_pad(){
        
        $contratos_pads = uv_reporte_pads::all();

        $dependencias = parametricas::getFromCategory('contratos.dependencia');
  
        $search = [];

        return view('reportes.reporte_detallado_pads.index',compact('contratos_pads','search','dependencias'));
    }

    public function busqueda_pad(Request $request){

        //dd($request);
         $active = true;
         $search = [];
         $olddata =$request->all();
 
 
         if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
 
             if ($request->fecha_hasta < $request->fecha_desde) {
 
                 return redirect()->route('reportes.reporte_detallado_pads.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
              }
           }
      $contratos_pads = uv_reporte_pads::all();

      $id_convenio_padre = $request->id_convenio_padre;

      $consulta = uv_reporte_pads::orderBy('id_convenio_padre');

         
         if ($request->id_convenio_padre != null){
 
            $consulta = $consulta->where('id_convenio_padre',$id_convenio_padre);

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
    
           return view('reportes.reporte_detallado_pads.index',compact('search','olddata','contratos_pads','active','dependencias'));
     }
}
