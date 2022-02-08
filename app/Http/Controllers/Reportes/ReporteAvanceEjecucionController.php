<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\reportes\uv_reporte_suma;

class ReporteAvanceEjecucionController extends Controller
{
    public function index()
    {

        $consulta = uv_reporte_suma::orderBy('id_proyecto')->get();
            
        $actividades = $consulta->toArray(); 

        return view('reportes.reporte_avance_ejecucion.index', compact('actividades'));
    }
}
