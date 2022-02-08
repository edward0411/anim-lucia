<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_pesos_porcentuales_actividades as pesos_porcentuales; 

class ReportePesosPorcentualesController extends Controller
{
    public function index(){

        $search = pesos_porcentuales::all();

        return view('reportes.reporte_pesos_porcentuales.index',compact('search'));
    }
}
