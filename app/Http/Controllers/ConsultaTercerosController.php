<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terceros as terceros;
use App\Models\Parametricas as parametricas;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\rps_movimientos as rp_movimientos;
use App\Models\Rps_cuentas as rp_cuenta;
use Illuminate\Support\Facades\DB;


class ConsultaTercerosController extends Controller
{
    //

    public function index(){

        $listaterceros = terceros::where('estado',1)->get();

        return view('consulta_terceros.index',compact('listaterceros'));
    }

    public function store(Request $request){

        $rules = [
            'id_tercero' => 'required',          
        ];

        $messages = [
            'id_tercero.required' => 'El nombre o IDE no se encuentra registrado.',     
        ];

        $this->validate($request, $rules, $messages);

        $id_tercero = $request->id_tercero;

        //dd($id_tercero);

        $compromisos = cdr_rp::leftJoin('rps_cuentas','rps_cuentas.id_rp','=','rps.id')
        ->leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','rps_cuentas.id_cuenta')
        ->leftJoin('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->where('rps.id_tercero',$id_tercero)
        ->select('rps.id_cdr','rps.id','rps_cuentas.id as id_rp_cuenta','rps.fecha_registro_rp','patrimonios.id_contrato_pad','rps_cuentas.id_cuenta','patrimonio_cuentas.id_param_tipo_cuenta','patrimonio_cuentas.descripcion_cuenta','rps.num_documento_soporte')
        ->get();   

        foreach($compromisos as $value) {

            if ($value->id_param_tipo_cuenta != null) {
                $id_tipo = $value->id_param_tipo_cuenta;
                $dato = parametricas::where('categoria','financiero.patrimonios.cuentas.tipo_cuenta')
                                    ->where('valor',$id_tipo)
                                    ->select('texto')
                                    ->first();
                
                $value->tipo_cuenta = $dato->texto;     
            }else {
                $value->tipo_cuenta = null;  
            }

           if ($value->id_rp_cuenta != null) {
            $valor = rp_movimientos::Where('id_rp_cuenta',$value->id_rp_cuenta)
            ->whereNull('deleted_at')
            ->select( DB::raw('sum(valor_operacion_rp) as valor'))
            ->get();

            $value->valor_operaciones = $valor[0]->valor;
           }else {
            $value->valor_operaciones = 0;
           }
            
           
        }

        return response()->json($compromisos);

    }
}
