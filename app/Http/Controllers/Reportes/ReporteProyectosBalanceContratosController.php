<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto_principal as proyectos;
use App\Models\reportes\uv_reporte_proyectos_balance_contratos as uv_reporte_balance; 

class ReporteProyectosBalanceContratosController extends Controller
{
   public function index()
   {
    $search = [];

    $proyectos = proyectos::select('id','nombre_proyecto_principal')
    ->whereNull('deleted_at')
    ->get();
  
    return view('reportes.reporte_proyectos_balance_contratos.index',compact('search','proyectos'));
   }

   public function busqueda(Request $request)
   {

      $search = [];

      $proyectos = proyectos::select('id','nombre_proyecto_principal')
      ->whereNull('deleted_at')
      ->get();

      $consulta = uv_reporte_balance::orderBy('id_proyecto_principal');

      if ($request->id_proyecto != null) {
        $consulta = $consulta->where('id_proyecto_principal',$request->id_proyecto[0]);
      }
         $consulta = $consulta->get();

         $search = $consulta;

      return view('reportes.reporte_proyectos_balance_contratos.index',compact('search','proyectos'));
   }
}
