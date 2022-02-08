<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Contratos as contratos;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use App\Models\reportes\uv_reporte_convenios as uv_reporte_convenios; 


class ReporteDetalladoConvenioController extends Controller
{
    //


    public function index_convenio(){

    
     $contratos_convenio = uv_reporte_convenios::all();

     $dependencias = parametricas::getFromCategory('contratos.dependencia');
    
     $search = [];

        return view('reportes.reporte_detallado_convenio.index',compact('contratos_convenio','search','dependencias'));
    }


    public function busqueda_convenio(Request $request){

       // dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();


        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {

            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_detallado_convenio.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }
     
     $contratos_convenio = uv_reporte_convenios::all();

     $id_convenio = $request->id_convenio;

     $consulta = uv_reporte_convenios::orderBy('id_convenio');
     
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


         return view('reportes.reporte_detallado_convenio.index',compact('search','olddata','contratos_convenio','active','dependencias'));
    }
}
