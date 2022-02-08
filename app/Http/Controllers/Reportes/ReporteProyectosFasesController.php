<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_proyectos_fases_suma as reporte_suma; 


class ReporteProyectosFasesController extends Controller
{
    public function index(){   
        $search = reporte_suma::all();

        return view('reportes.reporte_proyectos_fases.index',compact('search'));
    }
}
