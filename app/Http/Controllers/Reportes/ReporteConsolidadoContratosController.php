<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteConsolidadoContratosController extends Controller
{
    public function index()
    {

        $contratos = DB::table('contratos')
            ->where('param_valor_tipo_contrato', '3')
            ->whereNull('contratos.deleted_at')
            ->select('id', 'numero_contrato')
            ->get();
        //dd($contratos);
        $search =  [];
        return view('reportes.reporte_consolidado_contratos.index', compact('contratos', 'search'));
    }

    public function busqueda_consolidado_contratos(Request $request)
    {

        $active = true;
        $search = [];
        $olddata = $request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {

            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_consolidado_contratos.index')->with('error', 'Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
            }
        }
        $contratos = DB::table('contratos')
            ->where('param_valor_tipo_contrato', '3')
            ->whereNull('contratos.deleted_at')
            ->select('id', 'numero_contrato')
            ->get();

        $id_contrato = $request->id_contrato;

        $consulta = DB::table('contratos')
            ->leftJoin('contratos_fechas', 'contratos_fechas.id_contrato', '=', 'contratos.id')
            ->where('contratos.param_valor_tipo_contrato', '3')
            ->whereNull('contratos.deleted_at')
            ->select(
                'contratos.id as id_contrato',
                'contratos.param_texto_modalidad_contratacion',
                'contratos.numero_contrato',
                'contratos.vigencia',
                'contratos.id_cdr',
                'contratos.objeto_contrato',
                'contratos_fechas.valor_inicial',
                'contratos_fechas.valor_actual',
                'contratos_fechas.fecha_firma',
                'contratos_fechas.fecha_inicio',
                'contratos_fechas.fecha_terminacion',
                'contratos_fechas.plazo_inicial_meses',
                'contratos_fechas.fecha_terminacion_actual',
                'contratos.param_texto_estado_contrato',
                'contratos_fechas.fecha_suscripcion_acta_liquidacion',
                'contratos_fechas.fecha_arl',
                'contratos_fechas.fecha_acta_inicio'
            );
        if ($request->id_contrato != null) {

            $consulta = $consulta->where('contratos.id', $id_contrato);
        }
        if ($request->fecha_hasta != null) {

            $consulta = $consulta->where('fecha_firma', '<=', $request->fecha_hasta);
        }
        if ($request->fecha_desde != null) {

            $consulta = $consulta->where('fecha_firma', '>=', $request->fecha_desde);
        }
        $consulta = $consulta->get();
        $search = $consulta->toArray();
        // dd($search);

        $max_supervisores = 0;
        $max_interventores = 0;
        $max_apoyo = 0;
        $max_otrosi = 0;


        foreach ($search as $value) {
            //  dd($value);
            $consulta_contratista = DB::table('contratos_terceros')
                ->leftJoin('terceros', 'terceros.id', '=', 'contratos_terceros.id_terecero')
                ->where('contratos_terceros.id_contrato', $value->id_contrato)
                ->whereNull('contratos_terceros.deleted_at')
                ->select('terceros.nombre', 'terceros.identificacion')
                ->get();
            $contratista = $consulta_contratista->toArray();
            $value->contratista = $contratista;

            $consulta_polizas = DB::table('contratos_polizas')
                ->where('contratos_polizas.id_contrato', $value->id_contrato)
                ->whereNull('contratos_polizas.deleted_at')
                ->select('contratos_polizas.fecha_aprobacion', 'contratos_polizas.numero_poliza', 'contratos_polizas.aseguradora')
                ->orderBy('fecha_aprobacion')
                ->get();

            $polizas = $consulta_polizas->toArray();
            $array_polizas = [];
            if (count($polizas) == 0) {
                $array_polizas = [];
            } elseif (count($polizas) == 1) {
                $array_polizas[0] = reset($polizas);
            }elseif(count($polizas) > 1){
                $array_polizas[0] = reset($polizas);
                $array_polizas[1] = end($polizas);
                
            }
            $value->polizas = $array_polizas;

           // dd($value);


            $consulta_supervidores = DB::table('contratos_supervisores')
                ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
                ->where('contratos_supervisores.id_tipo_supervisor', 1)
                ->where('contratos_supervisores.estado', 1)
                ->where('contratos_supervisores.id_contrato', $value->id_contrato)
                ->whereNull('contratos_supervisores.deleted_at')
                ->select('terceros.nombre as nombre_supervisor', 'contratos_supervisores.Fecha_asociacion as fecha_supervisor', 'contratos_supervisores.estado as estado_supervisor')
                ->get();
            $supervisores = $consulta_supervidores->toArray();
            if (count($supervisores) > $max_supervisores) {
                $max_supervisores = count($supervisores);
            }
            $value->supervisores = $supervisores;
            //dd($supervisores);
            $consulta_interventor = DB::table('contratos_supervisores')
                ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
                ->where('contratos_supervisores.id_tipo_supervisor', 2)
                ->where('contratos_supervisores.estado', 1)
                ->where('contratos_supervisores.id_contrato', $value->id_contrato)
                ->whereNull('contratos_supervisores.deleted_at')
                ->select('terceros.nombre as nombre_intervertor', 'contratos_supervisores.Fecha_asociacion as fecha_interventor', 'contratos_supervisores.estado as estado_interventor')
                ->get();

            $interventores = $consulta_interventor->toArray();
            if (count($interventores) > $max_interventores) {
                $max_interventores = count($interventores);
            }
            $value->interventores = $interventores;

            $consulta_apoyo = DB::table('contratos_supervisores')
                ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
                ->where('contratos_supervisores.id_tipo_supervisor', 3)
                ->where('contratos_supervisores.estado', 1)
                ->where('contratos_supervisores.id_contrato', $value->id_contrato)
                ->whereNull('contratos_supervisores.deleted_at')
                ->select('terceros.nombre as nombre_apoyo', 'contratos_supervisores.Fecha_asociacion as fecha_apoyo', 'contratos_supervisores.estado as estado_apoyo')
                ->get();
            $apoyo = $consulta_apoyo->toArray();
            if (count($apoyo) > $max_apoyo) {
                $max_apoyo = count($apoyo);
            }
            $value->apoyo = $apoyo;

            $consulta_otrosi =  DB::table('contratos_otrosi')
                ->where('contratos_otrosi.id_contrato', $value->id_contrato)
                ->whereNull('contratos_otrosi.deleted_at')
                ->select('contratos_otrosi.fecha_firma as fecha_otrosi', 'contratos_otrosi.valor_adicion', 'contratos_otrosi.nueva_fecha_terminacion')
                ->get();
            $otrosi = $consulta_otrosi->toArray();
            if (count($otrosi) > $max_otrosi) {
                $max_otrosi = count($otrosi);
            }
            $value->otrosi = $otrosi;
        }
        //dd($search);
        //dd($max_supervisores,$max_interventores,$max_apoyo);

        return view('reportes.reporte_consolidado_contratos.index', compact(
            'search', 
            'olddata', 
            'contratos', 
            'active', 
            'max_supervisores', 
            'max_interventores', 
            'max_apoyo', 
            'max_otrosi'));
    }
}
