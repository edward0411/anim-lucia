<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_cdr_movimientos as uv_reporte_cdr_movimientos; 


class ReporteCdrMovimientosController extends Controller
{
    //
    public function index(){

      
      $search = [];

        return view('reportes.reporte_cdr_movimientos.index',compact('search'));
    }

    public function busqueda_cdr_movimiento(Request $request){

        // dd($request);
         $active = true;
         $search = [];
         $olddata =$request->all();
 
 
         if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
 
             if ($request->fecha_hasta < $request->fecha_desde) {
 
                 return redirect()->route('reportes.reporte_cdr_movimientos.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
              }
           }
       
      $id_cdr = $request->id_cdr;
 
      $consulta = uv_reporte_cdr_movimientos::orderBy('id_cdr');
      
         if ($request->fecha_hasta != null){
 
             $consulta = $consulta->where('fecha_registro_cdr','<=',$request->fecha_hasta);
 
         }
         if ($request->fecha_desde != null){
 
             $consulta = $consulta->where('fecha_registro_cdr','>=',$request->fecha_desde);
         }
 
 
         $consulta = $consulta->get();
 
     // dd($consulta);
        $search = $consulta;
 
 
          return view('reportes.reporte_cdr_movimientos.index',compact('search','olddata','active'));
     }
}
