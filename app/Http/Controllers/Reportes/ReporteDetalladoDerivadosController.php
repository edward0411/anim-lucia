<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contratos as contratos;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\reportes\uv_reporte_contratos as uv_reporte_contratos; 


class ReporteDetalladoDerivadosController extends Controller
{
    //
    public function index(){
        $contratos = uv_reporte_contratos::all();

        $dependencias = parametricas::getFromCategory('contratos.dependencia');

        $search = [];
   
           return view('reportes.reporte_detallado_contrato_derivados.index',compact('contratos','search','dependencias'));
       }

       public function busqueda_derivado(Request $request){

        //dd($request);
         $active = true;
         $search = [];
         $olddata =$request->all();
 
 
         if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
 
             if ($request->fecha_hasta < $request->fecha_desde) {
 
                 return redirect()->route('reportes.reporte_detallado_contrato_derivados.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
              }
           }

           $contratos = uv_reporte_contratos::all();

        
      $id_contrato = $request->id_contrato;

      $consulta = uv_reporte_contratos::orderBy('id_contrato');

         
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
 
      // dd($consulta);
        $search = $consulta;

        $dependencias = parametricas::getFromCategory('contratos.dependencia');
    
 
 
          return view('reportes.reporte_detallado_contrato_derivados.index',compact('search','olddata','contratos','active','dependencias'));
     }
}
