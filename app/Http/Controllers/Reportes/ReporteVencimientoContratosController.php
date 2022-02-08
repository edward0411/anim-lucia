<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Reporte_vencimiento_contratos as vencimiento_contratos;
use App\Models\Contratos_pads_convenios as pad_convenio;
use App\Models\Cdrs_cuentas as cdr_cuentas;

class ReporteVencimientoContratosController extends Controller
{
    public function index()
    {
        $search = [];

        $dependencias = parametricas::where('categoria','=','contratos.dependencia')
        ->select('valor','texto')
        ->orderBy('valor','asc')
        ->get();


        return view('reportes.reporte_vencimiento_contratos.index',compact('dependencias','search'));
    }

    public function busqueda_vencimiento_contratos(Request $request){  
       
        $search = [];
        $olddata =$request->all();

        $dependencias = parametricas::where('categoria','=','contratos.dependencia')
        ->select('valor','texto')
        ->orderBy('valor','asc')
        ->get();

        $consulta = vencimiento_contratos::orderBy('id');

        if ($request->dependencia != null){
 
            $consulta = $consulta->where('valor',$request->dependencia);

        }
        if ($request->fecha_desde != null){

            $consulta = $consulta->where('fecha_terminacion_actual','>=',$request->fecha_desde);           
                
        }
        if ($request->fecha_hasta != null){
 
            $consulta = $consulta->where('fecha_terminacion_actual','<=',$request->fecha_hasta);
              
        }
        $consulta = $consulta->get();
       

        foreach ($consulta as $value) {

        //dd($value);
         
            $tipo_contrato = $value->param_valor_tipo_contrato;

            if ($tipo_contrato == 1) {

                $pads = pad_convenio::leftJoin('contratos','contratos.id','=','contratos_pads_convenios.id_contrato_pad')
                ->where('id_contrato_convenio',$value->id)
                ->whereNull('contratos.deleted_at')
                ->whereNull('contratos_pads_convenios.deleted_at')
                ->select('contratos_pads_convenios.id_contrato_pad','contratos.numero_contrato')
                ->get();

                if(count($pads) == 0){

                    $value->nombre_unificado = 'Sin relación de PAD';

                }elseif (count($pads) == 1) {
                  
                    $value->nombre_unificado = $pads[0]->numero_contrato;

                }else{

                    $value->nombre_unificado = 'Varios Pads';

                }
            }else{

                $id_cdr = $value->id_cdr;

                $id_pads = cdr_cuentas::leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
                ->leftJoin('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
                ->leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
                ->where('cdrs_cuentas.id_cdr',$id_cdr)
                ->whereNull('cdrs_cuentas.deleted_at')
                ->whereNull('patrimonio_cuentas.deleted_at')
                ->whereNull('patrimonios.deleted_at')
                ->select('patrimonios.id_contrato_pad','contratos.numero_contrato')
                ->get();

                if(count($id_pads) == 0){

                    $value->nombre_unificado = 'Sin relación de PAD';

                }elseif (count($id_pads) == 1) {
                  
                    $value->nombre_unificado = $id_pads[0]->numero_contrato;

                }else{

                    $array_pad = [];

                    foreach ($id_pads as $pad) {
                        array_push($array_pad, $pad->id_contrato_pad);                    
                    }

                    $pads = array_unique($array_pad);

                    if(count($pads) == 1)
                    {
                        $value->nombre_unificado = $id_pads[0]->numero_contrato;

                    }else{

                        $value->nombre_unificado = 'Varios Pads';
                    }
                }  
            }
        }
        
        $search = $consulta->toArray();

        return view('reportes.reporte_vencimiento_contratos.index',compact('dependencias','search'));

    }
}
