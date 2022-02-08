<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patrimonios as patrimonio;
use App\Models\Terceros as terceros;
use App\Models\Contratos_terceros as contratos_tercero;
use App\Models\Contratos_pads_convenios as pads_convenios;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use App\Models\Rps_cuentas as rp_cuenta;
use App\Models\Contratos_fechas as contratos_fechas;
use Illuminate\Support\Facades\DB;

class ReporteConsolidadoPadsController extends Controller
{
    public function index()
    {
       $patrimonios = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
       ->whereNull('patrimonios.deleted_at')
       ->whereNull('contratos.deleted_at')
       ->select('patrimonios.id','contratos.numero_contrato')
       ->get();

       $search = [];

       return view('reportes.reporte_consolidado_pads.index',compact('patrimonios','search'));
    }

    public function busqueda(Request $request)
    {
        $id_patrimonio = $request->id_patrimonio;

        $patrimonios = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->whereNull('patrimonios.deleted_at')
        ->whereNull('contratos.deleted_at')
        ->select('patrimonios.id','contratos.numero_contrato')
        ->get();

       $search = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
       ->whereNull('patrimonios.deleted_at')
       ->whereNull('contratos.deleted_at');
       if ($id_patrimonio != null) {
        $search = $search->where('patrimonios.id',$id_patrimonio);
       }
       $search = $search->select('patrimonios.id','contratos.id as id_pad','patrimonios.codigo_fid as codigo_pad','contratos.numero_contrato')->get();
      

       foreach ($search as $value) {
           
           $tercero = pads_convenios::LeftJoin('contratos','contratos.id','=','contratos_pads_convenios.id_contrato_convenio')
           ->leftJoin('contratos_terceros','contratos_terceros.id_contrato','=','contratos.id')
           ->LeftJoin('terceros','terceros.id','=','contratos_terceros.id_terecero')
           ->where('contratos_pads_convenios.id_contrato_pad',$value->id_pad)
           ->select('contratos.id as id_contrato','terceros.id as id_tercero','terceros.nombre')
           ->whereNull('contratos_pads_convenios.deleted_at')
           ->whereNull('contratos.deleted_at')
           ->whereNull('contratos_terceros.deleted_at')
           ->whereNull('terceros.deleted_at')
           ->distinct()
           ->get();

           if ($tercero == null || count($tercero) > 1) {
              
            $value->contraparte = "";
           }else{
            $value->contraparte = $tercero[0]->nombre;
           }

           $cuentas = patrimonios_cuentas::where('id_patrimonio',$value->id)
           ->select('id as id_cuenta','numero_de_cuenta','descripcion_cuenta','id_param_tipo_cuenta_texto as tipo_cuenta','valor_asignado')
           ->get();

           foreach ($cuentas as $cuenta) {
              
                $valor_aportado = patrimonios_cuentas::join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
                ->where('patrimonio_cuentas.id',$cuenta->id_cuenta)
                ->whereIn('patrimonio_cuenta_movimientos.id_param_tipo_movimiento', [1, 2])
                ->whereNull('patrimonio_cuentas.deleted_at')
                ->whereNull('patrimonio_cuenta_movimientos.deleted_at')
                ->select(DB::raw('sum(patrimonio_cuenta_movimientos.valor) as valor_aportado'))
                ->get();

                    if(count($valor_aportado) > 0){
                        $cuenta->valor_aportado = $valor_aportado[0]->valor_aportado;
                    }else{
                        $cuenta->valor_aportado = 0;
                    }

                $rendimientos = patrimonios_cuentas::join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
                ->where('patrimonio_cuentas.id',$cuenta->id_cuenta)
                ->where('patrimonio_cuenta_movimientos.id_param_tipo_movimiento',3)
                ->whereNull('patrimonio_cuenta_movimientos.deleted_at')
                ->select(DB::raw('sum(patrimonio_cuenta_movimientos.valor) as valor_rendimientos'))
                ->get();

                if(count($rendimientos) > 0){
                            $cuenta->valor_rendimientos = $rendimientos[0]->valor_rendimientos;
                }else{
                        $cuenta->valor_rendimientos = 0;
                }

                $cdrs = cdr_cuentas::LeftJoin('cdr_operaciones','cdrs_cuentas.id','=','cdr_operaciones.id_cdr_cuenta')
                ->where('cdrs_cuentas.id_cuenta',$cuenta->id_cuenta)
                ->whereNull('cdr_operaciones.deleted_at')
                ->select(DB::raw('sum(cdr_operaciones.valor_operacion) as valor_cdr'))
                ->get();

                if(count($cdrs) > 0){
                    $cuenta->cdrs = $cdrs[0]->valor_cdr;
                }else{
                    $cuenta->cdrs = 0;
                }

               
                $rps = rp_cuenta::LeftJoin('rp_operaciones','rp_operaciones.id_rp_cuenta','=','rps_cuentas.id')
                ->where('rps_cuentas.id_cuenta',$cuenta->id_cuenta)
                ->whereNull('rps_cuentas.deleted_at')
                ->whereNull('rp_operaciones.deleted_at')
                ->select(DB::raw('sum(rp_operaciones.valor_operacion_rp) as valor_rp'))
                ->get();

                if(count($rps) > 0){
                    $cuenta->rps = $rps[0]->valor_rp;
                }else{
                    $cuenta->rps = 0;
                }

                $obls = rp_cuenta::LeftJoin('obl_operaciones','obl_operaciones.id_rp_cuenta','=','rps_cuentas.id')
                ->where('rps_cuentas.id_cuenta',$cuenta->id_cuenta)
                ->whereNull('rps_cuentas.deleted_at')
                ->whereNull('obl_operaciones.deleted_at')
                ->select(DB::raw('sum(obl_operaciones.valor_operacion_obl) as valor_obl'))
                ->get();

                if(count($obls) > 0){
                    $cuenta->obls = $obls[0]->valor_obl;
                }else{
                    $cuenta->obls = 0;
                }
           }

           $value->cuentas = $cuentas;

           $fechas = pads_convenios::LeftJoin('contratos','contratos.id','=','contratos_pads_convenios.id_contrato_convenio')
           ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.id')
           ->where('contratos_pads_convenios.id_contrato_pad',$value->id_pad)
           ->select('contratos_fechas.id as id_fecha',DB::raw('max(contratos_fechas.fecha_terminacion_actual) as fecha_fin'))
           ->whereNull('contratos_pads_convenios.deleted_at')
           ->whereNull('contratos.deleted_at')
           ->whereNull('contratos_fechas.deleted_at')
           ->groupBy('contratos_fechas.id')
           ->get();

           $value->fecha_fin = $fechas[0]->fecha_fin;

           $fecha = contratos_fechas::where('id',$fechas[0]->id_fecha)
           ->select('fecha_inicio')
           ->first();

           $value->fecha_inicio = $fecha->fecha_inicio;
       }     

       return view('reportes.reporte_consolidado_pads.index',compact('patrimonios','search'));


    }
}
