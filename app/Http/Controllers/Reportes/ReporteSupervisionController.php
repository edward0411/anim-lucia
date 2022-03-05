<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_supervision as reporte;

class ReporteSupervisionController extends Controller
{
    public function index()
    {
        $search = reporte::all();

        return view('reportes.reporte_supervision.index',compact('search'));
    }
}
