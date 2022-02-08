<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_contratos_polizas as uv_reporte_contratos_polizas; 


class ReporteContratosPolizasController extends Controller
{
    //
    public function index(){
        $contrato_poliza = uv_reporte_contratos_polizas::all();
        $search = [];
   
           return view('reportes.reporte_contrato_polizas.index',compact('contrato_poliza','search'));
       }

       public function busqueda_contratos_polizas(Request $request){

        //dd($request);
         $active = true;
         $search = [];
         $olddata =$request->all();
 
 
         if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
 
             if ($request->fecha_hasta < $request->fecha_desde) {
 
                 return redirect()->route('reportes.reporte_contrato_polizas.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
              }
           }

      $contrato_poliza = uv_reporte_contratos_polizas::all();
       
      $id_contrato = $request->id_contrato;

      $consulta = uv_reporte_contratos_polizas::orderBy('id_contrato');

         
         if ($request->id_contrato != null){
 
            $consulta = $consulta->where('id_contrato',$id_contrato);

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

          return view('reportes.reporte_contrato_polizas.index',compact('search','olddata','contrato_poliza','active'));
     }
}
