<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_patrimonios_movimientos as uv_reporte_patrimonios_movimientos; 


class ReportePatrimoniosMovimientosController extends Controller
{
    //
    public function index(){

        $patrimonio_movimiento = uv_reporte_patrimonios_movimientos::all();

        $pads = uv_reporte_patrimonios_movimientos::select('id_contrato','numero_pad')
        ->distinct()
        ->orderBy('numero_pad','asc')
        ->get();

        $codigo_pad = uv_reporte_patrimonios_movimientos::select('id_patrimonio','codigo_pad')
        ->distinct()
        ->orderBy('codigo_pad','asc')
        ->get();

        $search = [];

        return view('reportes.reporte_patrimonios_movimientos.index',compact('patrimonio_movimiento','search','pads','codigo_pad'));
    }

    public function busqueda_patrimonios_movimiento(Request $request){
       
        // dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();

        $patrimonio_movimiento = uv_reporte_patrimonios_movimientos::all();

        $id_contrato = $request->id_contrato;

        $consulta = uv_reporte_patrimonios_movimientos::orderBy('id_contrato');

        if ($request->id_contrato != null){

          $consulta = $consulta->where('id_contrato',$id_contrato);
        }
        if ($request->id_patrimonio != null){

          $consulta = $consulta->where('id_patrimonio',$request->id_patrimonio);
        }

          $consulta = $consulta->get();

          // dd($consulta);
             $search = $consulta;

             $pads = uv_reporte_patrimonios_movimientos::select('id_contrato','numero_pad')
             ->distinct()
             ->orderBy('numero_pad','asc')
             ->get();
     
             $codigo_pad = uv_reporte_patrimonios_movimientos::select('id_patrimonio','codigo_pad')
             ->distinct()
             ->orderBy('codigo_pad','asc')
             ->get();

             return view('reportes.reporte_patrimonios_movimientos.index',compact('search','olddata','patrimonio_movimiento','active','pads','codigo_pad'));


  }
}
