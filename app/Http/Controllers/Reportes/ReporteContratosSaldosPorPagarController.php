<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reportes\uv_reporte_contratos_saldo_por_pagar as uv_reporte_saldos; 

class ReporteContratosSaldosPorPagarController extends Controller
{
    public function index()
    {
        $search = uv_reporte_saldos::all();

        return view('reportes.reporte_contratos_saldos.index',compact('search'));
    }

    
}
