<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Obl_operaciones as obl_operaciones;


class ConsultaObligacionesEstadosController extends Controller
{
    public function index(){

        $obligaciones_estado = Parametricas::getFromCategory('financiero.cdr.rp.obl.operaciones.estado');

        return view('consulta_obligaciones_estados.index',compact('obligaciones_estado'));
    }
    public function store(Request $request){
    
        $estado = $request->obligaciones_estado;

        $registro = obl_operaciones::where('obl_operaciones.param_estado_obl_operacion_valor',$estado)
        ->leftJoin('rps_cuentas','rps_cuentas.id','=','obl_operaciones.id_rp_cuenta')
        ->leftJoin('rps','rps.id','=','rps_cuentas.id_rp')
        ->leftJoin('terceros','terceros.id','=','rps.id_tercero')
        ->whereNull('obl_operaciones.deleted_at')
        ->whereNull('rps_cuentas.deleted_at')
        ->whereNull('rps.deleted_at')
        ->whereNull('terceros.deleted_at')
        ->select('obl_operaciones.id','obl_operaciones.fecha_obl_operacion','obl_operaciones.valor_operacion_obl','obl_operaciones.param_estado_obl_operacion_valor','obl_operaciones.param_estado_obl_operacion_text','terceros.nombre')
        ->get();

        $pendiente = 0;

        foreach ($registro as $value) {  
            
            $relacion = obl_operaciones::find($value->id);
            $pendiente = $value->valor_operacion_obl - $relacion->suma_obl();
            $value->pendiente = $pendiente;
        }

        return response()->json($registro);

    }
}
