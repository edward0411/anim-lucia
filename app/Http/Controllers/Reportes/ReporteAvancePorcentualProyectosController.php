<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\reportes\uv_reporte_avance_porcentual_proyectos as avance_porcentual;

class ReporteAvancePorcentualProyectosController extends Controller
{
    public function index()
    {
        $search = [];

        $dependencias = parametricas::where('categoria','=','contratos.dependencia')
        ->select('valor','texto')
        ->orderBy('valor','asc')
        ->get();


        return view('reportes.reporte_avance_porcentual_proyectos.index',compact('dependencias','search'));
    }

    public function busqueda(Request $request){

        $dependencias = parametricas::where('categoria','=','contratos.dependencia')
        ->select('valor','texto')
        ->orderBy('valor','asc')
        ->get();

        $consulta = avance_porcentual::orderBy('id_proyecto');

        if ($request->dependencia != null) {
            $consulta = $consulta->where('param_valor_dependencia',$request->dependencia);
        }

        $consulta = $consulta->get();
        $search = $consulta->toArray();

         return view('reportes.reporte_avance_porcentual_proyectos.index',compact('dependencias','search'));

    }
}
