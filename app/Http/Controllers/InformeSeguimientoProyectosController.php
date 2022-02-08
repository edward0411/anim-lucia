<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyectos as proyectos;
use App\Models\Fases as fases;
use App\Models\Fases_actuales as fases_act;
use App\Models\Fases_planes as fases_planes;
use App\Models\Proyectos_caracteristicas as proyectos_caracteristicas;
use Illuminate\Support\Facades\DB;
use App\Models\Cdrs as cdr;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\Plantillas_pagos as plantillas_pagos;
use App\Models\Plan_pagos_rps as plan_rp;
use App\Models\Rps_cuentas as rp_cuenta;
use App\Models\Obl_operaciones as obl_operaciones;
use App\Models\Gestiones_sociales as gestiones_sociales;
use App\Models\gestiones_ambientales as gestiones_ambientales;
use App\Models\Calidad_seguridad_industriales as calidad_seguridad_industriales;
use Carbon\Carbon;
use App\Models\Contratos as contratos;
use App\Models\Fases_Informe_semanal as fases_Informe_semanal;
use App\Models\Fases_Informe_semanal_bitacora as fases_Informe_semanal_bitacora;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;


class InformeSeguimientoProyectosController extends Controller
{
    //
    public function informe_seguimiento_index(){

       $proyecto = proyectos::all();
       $search = [];
       $id_proyecto=null;
       $nombre_proyecto = null;

        return view('informe_seguimiento_proyectos.informe_seguimiento_index',compact('proyecto','search','id_proyecto','nombre_proyecto'));
    }

    public function consulta_seguimiento_crear($id,$id_semana_parametrica,$fecha){

        $Proyectos = Proyectos::where('proyectos.id','=',$id)
        ->leftJoin('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
        ->leftJoin('contratos','proyectos_convenios.id_contrato','=','contratos.id')
        ->leftJoin('contratos_fechas','contratos.id','=','contratos_fechas.id_contrato')
        ->whereNull('proyectos.deleted_at')
        ->whereNull('proyectos_convenios.deleted_at')
        ->whereNull('contratos_fechas.deleted_at')
        ->select('proyectos.id','contratos.id as id_convenio','contratos.numero_contrato','contratos_fechas.fecha_terminacion_actual','contratos_fechas.fecha_terminacion',
        'contratos.valor_contrato as valor_actual','proyectos.nombre_proyecto','proyectos.objeto_proyecto','contratos.param_texto_estado_contrato')->distinct()
        ->get();

        foreach($Proyectos as $convenio)
        {
            $tercero = contratos::where('contratos.id',$convenio->id_convenio)
            ->leftJoin('contratos_terceros','contratos_terceros.id_contrato','=','contratos.id')
            ->leftJoin('terceros','terceros.id','=','contratos_terceros.id_terecero')
            ->whereNull('contratos_terceros.deleted_at')
            ->select('terceros.nombre')
            ->first();

            if($tercero != null){
                $convenio->nombre = $tercero->nombre;
            }else{
                $convenio->nombre = '';
            }

        }

        /*Select distinct proyectos.id,  terceros.nombre,contratos.numero_contrato,  contratos_fechas.fecha_terminacion_actual,contratos_fechas.valor_actual
        from proyectos
        Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
        Inner join contratos on proyectos_convenios.id_contrato = contratos.id
        inner join contratos_terceros on contratos.id = contratos_terceros.id_contrato
        inner join terceros on contratos_terceros.id_terecero = terceros.id
        Inner join contratos_fechas on contratos.id =contratos_fechas.id_contrato
        where proyectos.deleted_at is null
        and proyectos_convenios.deleted_at is null
        and contratos_terceros.deleted_at is null
        and contratos_fechas.deleted_at is null*/

        $personas =Proyectos::where('proyectos.id','=',$id)
        ->Leftjoin('proyectos_personas as coo',function($join){
            $join->on('proyectos.id','=','coo.id_proyecto')
            ->where('coo.param_tipo_rol_valor','=','2');})
        ->Leftjoin('proyectos_personas as lid',function($join){
                $join->on('proyectos.id','=','lid.id_proyecto')
                ->where('lid.param_tipo_rol_valor','=','3');})
        ->Leftjoin('proyectos_personas as Sup',function($join){
                    $join->on('proyectos.id','=','Sup.id_proyecto')
                    ->where('Sup.param_tipo_rol_valor','=','1');})
        ->leftjoin('users as usecoo','coo.id_usuario','=','usecoo.id')
        ->leftjoin('users as uselid','lid.id_usuario','=','uselid.id')
        ->leftjoin('users as useSup','Sup.id_usuario','=','useSup.id')
        ->whereNull('coo.deleted_at')
        ->whereNull('lid.deleted_at')
        ->whereNull('Sup.deleted_at')
        ->select('usecoo.name as coordinador','uselid.name as Lider','useSup.name as Supervisor')
        ->get();
       // dd($personas);
        /*Select proyectos.id,usecoo.name coordinador,uselid.name Lider
            from proyectos
            left join proyectos_personas coo on proyectos.id = coo.id_proyecto
            left join proyectos_personas lid on proyectos.id = lid.id_proyecto
            left join users usecoo on coo.id_usuario = usecoo.id
            left join users uselid on lid.id_usuario = uselid.id
            where proyectos.id = 1
            and coo.param_tipo_rol_texto='Coordinador de proyecto'
            and lid.param_tipo_rol_texto='Lider de proyecto'
            and coo.deleted_at is null
            and lid.deleted_at is null
            '*/

        $licencias =Proyectos::where('proyectos.id','=',$id)
        ->join('proyectos_licencias','proyectos.id','=','proyectos_licencias.id_proyecto')
        ->whereNull('proyectos_licencias.deleted_at')
        ->select('proyectos_licencias.param_tipo_licencia_texto','proyectos_licencias.fecha_expedicion','proyectos_licencias.fecha_terminacion')
        ->get();
        //dd($licencias);
            /*
            SELECT proyectos.nombre_proyecto,
            proyectos_licencias.param_tipo_licencia_texto,proyectos_licencias.fecha_expedicion,proyectos_licencias.fecha_terminacion
            FROM proyectos
            Inner join proyectos_licencias on proyectos.id = proyectos_licencias.id_proyecto
            WHERE proyectos.id=1 and proyectos_licencias.estado=1
            and proyectos_licencias.deleted_at is null*/

        $contratos=Proyectos::where('proyectos.id','=',$id)
        ->join('fases','proyectos.id','=','fases.id_proyecto')
        ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase')
        ->join('contratos','contratos.id','=','fases_relaciones_contratos.id_contrato')
        ->LeftJoin('contratos_fechas','contratos.id','=','contratos_fechas.id_contrato')
        ->LeftJoin('contratos_terceros','contratos.id','=','contratos_terceros.id_contrato')
        ->LeftJoin('terceros','contratos_terceros.id_terecero','=','terceros.id')
        ->whereNull('fases.deleted_at')
        ->whereNull('fases_relaciones_contratos.deleted_at')
        ->whereNull('contratos_fechas.deleted_at')
        ->select('contratos.id as id_contrato','proyectos.nombre_proyecto','contratos.numero_contrato','contratos.objeto_contrato','contratos_fechas.valor_actual','contratos_fechas.fecha_terminacion',
        'contratos_fechas.fecha_inicio','contratos_fechas.fecha_terminacion_actual','contratos.param_texto_estado_contrato',
        'terceros.nombre','contratos.id_cdr')
        ->distinct()
        ->get();

        foreach ($contratos as $value) {

            $id_contrato = $value->id_contrato;

           $pagos = cdr_rp::join('rps_cuentas','rps_cuentas.id_rp','=','rps.id')
           ->join('obl_operaciones','obl_operaciones.id_rp_cuenta','rps_cuentas.id')
           ->join('endoso','endoso.id_obl','=','obl_operaciones.id')
           ->where('id_contrato', $id_contrato)
           ->whereNull('rps_cuentas.deleted_at')
           ->whereNull('obl_operaciones.deleted_at')
           ->whereNull('endoso.deleted_at')
           //->select('rps.id','rps_cuentas.id as id_cuenta')
           ->select(DB::raw('sum(endoso.valor_endoso) as valor_pagos'))
           ->get();

            if($pagos[0]->valor_pagos == null)
            {
                $value->pagos = 0;
            }else{
                $value->pagos = $pagos[0]->valor_pagos;
            }
          
        }

        $programado = Proyectos::where('proyectos.id','=',$id)
        ->join('fases','proyectos.id','=','fases.id_proyecto')
        ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase')
        ->join('contratos','contratos.id','=','fases_relaciones_contratos.id_contrato')
        ->join('rps','rps.id_contrato','=','contratos.id')
        ->join('plantilas_pagos','plantilas_pagos.id_rp','=','rps.id')
        ->join('plan_pagos_rps','plan_pagos_rps.id_plantilla','=','plantilas_pagos.id')
        ->select('rps.id as id_rp','plantilas_pagos.id as id_plantilla','plan_pagos_rps.mes','plan_pagos_rps.valor_mes')
        ->where('plan_pagos_rps.mes','<=',$fecha)
        ->whereNull('fases.deleted_at')
        ->whereNull('fases_relaciones_contratos.deleted_at')
        ->whereNull('contratos.deleted_at')
        ->whereNull('rps.deleted_at')
        ->whereNull('plantilas_pagos.deleted_at')
        ->whereNull('plan_pagos_rps.deleted_at')
        ->distinct()
        ->get();

        //dd($programado,$fecha);

        $sum_prog = 0;

        foreach ($programado as $value) {           
            $sum_prog =  $sum_prog + $value->valor_mes;          
        }

       // dd($sum_prog);

        $ejecutado = Proyectos::where('proyectos.id','=',$id)
        ->join('fases','proyectos.id','=','fases.id_proyecto')
        ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase')
        ->join('contratos','contratos.id','=','fases_relaciones_contratos.id_contrato')
        ->join('rps','rps.id_contrato','=','contratos.id')
        ->join('rps_cuentas','rps_cuentas.id_rp','=','rps.id')
        ->join('obl_operaciones','obl_operaciones.id_rp_cuenta','=','rps_cuentas.id')
        ->join('endoso','endoso.id_obl','=','obl_operaciones.id')
        ->where('obl_operaciones.fecha_obl_operacion','<=',$fecha)
        ->whereNull('fases.deleted_at')
        ->whereNull('fases_relaciones_contratos.deleted_at')
        ->whereNull('contratos.deleted_at')
        ->whereNull('rps.deleted_at')   
        ->whereNull('rps_cuentas.deleted_at')   
        ->whereNull('obl_operaciones.deleted_at')   
        ->whereNull('endoso.deleted_at')   
        ->select('contratos.id','rps_cuentas.id as id_rp_cuenta','obl_operaciones.id as id_op','endoso.id as id_pago','endoso.valor_endoso')     
        ->distinct()
        ->get();

        $sum_eject = 0;

        foreach ($ejecutado as $value) {           
            $sum_eject =  $sum_eject + $value->valor_endoso;          
        }

        //dd($sum_prog);

        $caracteristicas =Proyectos::where('proyectos.id','=',$id)
        ->join('proyectos_caracteristicas','proyectos.id','=','proyectos_caracteristicas.id_proyecto')
        ->select('proyectos_caracteristicas.param_tipo_proyecto_caracteristica_texto','proyectos_caracteristicas.decripcion_proyecto')
        ->whereNull('proyectos_caracteristicas.deleted_at')
        ->get();

      /*  SELECT proyectos.nombre_proyecto,contratos.numero_contrato,contratos.objeto_contrato,contratos_fechas.valor_actual,
        contratos_fechas.fecha_inicio,contratos_fechas.fecha_terminacion_actual,contratos.param_texto_estado_contrato,terceros.nombre
        FROM proyectos
        Inner join fases on proyectos.id = fases.id_proyecto
        inner join fases_relaciones_contratos on fases.id = fases_relaciones_contratos.id_fase
        inner join contratos on contratos.id = fases_relaciones_contratos.id_contrato
        left join contratos_fechas on contratos.id = contratos_fechas.id_contrato
        left join contratos_terceros on contratos.id = contratos_terceros.id_contrato
        left join terceros on contratos_terceros.id_terecero = terceros.id
        WHERE proyectos.id=1
        and fases.deleted_at is null
        and fases_relaciones_contratos.deleted_at is null
        and contratos_fechas.deleted_at is null*/

       /* $recursos=Proyectos::where('proyectos.id','=',$id)
        ->join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
        ->join('contratos','proyectos_convenios.id_contrato','=','contratos.id')
        ->whereNull('proyectos_convenios.deleted_at')
        ->select( DB::raw('sum(contratos.valor_contrato) as Valor'))
        ->get();*/

        $recursos=Proyectos::where('proyectos.id',$id)
        ->Join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
        ->Join('contratos','proyectos_convenios.id_contrato','=','contratos.id')
        ->Join('contratos_pads_convenios','contratos_pads_convenios.id_contrato_convenio','=','contratos.id')
        ->Join('contratos as pads','pads.id','=','contratos_pads_convenios.id_contrato_pad')
        ->Join('patrimonios','patrimonios.id_contrato_pad','=','pads.id')
        ->whereNull('proyectos_convenios.deleted_at')
        ->whereNull('contratos_pads_convenios.deleted_at')
        ->whereNull('patrimonios.deleted_at')
        ->select('pads.id as id_pads','pads.numero_contrato','patrimonios.id as id_patrimonio')
        ->distinct()
        ->get();



        foreach($recursos as $value){

            $valor_definido = 0;

           $id_patrimonio = $value->id_patrimonio;

           $cuentas = patrimonios_cuentas::where('id_patrimonio', $id_patrimonio)
           ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
           ->get();

            foreach ($cuentas as $cuenta) {
                $sumatoria = $cuenta->get_saldo_cuenta();
                $cuenta['valor_cuenta'] = $sumatoria;
                $movimento = $cuenta->get_movimento_cuenta();
                $redimiento = $cuenta->get_redimiento_cuenta();
                $cuenta['valor_movimiento'] = $movimento;
                $pendiente = $cuenta['valor_asignado'] - $movimento;
                $cuenta['valor_rendimiento'] = $redimiento;
                $cuenta['valor_pendiente'] = $pendiente;
                $valor_definido = $valor_definido + $cuenta['valor_asignado'];
            }

           $value->valor_definido = $valor_definido;


           $valor_aportado = patrimonios_cuentas::join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
           ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
           ->where('patrimonio_cuentas.id_patrimonio',$id_patrimonio)
           ->whereIn('patrimonio_cuenta_movimientos.id_param_tipo_movimiento', [1, 2])
           ->whereNull('patrimonio_cuentas.deleted_at')
           ->whereNull('patrimonio_cuenta_movimientos.deleted_at')
           ->select(DB::raw('sum(patrimonio_cuenta_movimientos.valor) as valor_aportado'))
           ->get();

           if(count($valor_aportado) > 0){
               
                $value->valor_aportado = $valor_aportado[0]->valor_aportado;
           }else{
                $value->valor_aportado = 0;
           }
          

           $rendimientos = patrimonios_cuentas::join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
           ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
           ->where('patrimonio_cuentas.id_patrimonio',$id_patrimonio)
           ->where('patrimonio_cuenta_movimientos.id_param_tipo_movimiento',3)
           ->select(DB::raw('sum(patrimonio_cuenta_movimientos.valor) as valor_rendimientos'))
           ->get();

           if(count($rendimientos) > 0){
                    $value->valor_rendimientos = $rendimientos[0]->valor_rendimientos;
            }else{
                    $value->valor_rendimientos = 0;
            }

          


           $rp_operaciones = patrimonios_cuentas::join('cdrs_cuentas as cdcu','patrimonio_cuentas.id','=','cdcu.id_cuenta')
           ->join('cdrs','cdrs.id','=','cdcu.id_cdr')
           ->join('rps','rps.id_cdr','=','cdrs.id')
           ->join('rps_cuentas','rps_cuentas.id_rp','=','rps.id')
           ->join('rp_operaciones','rp_operaciones.id_rp_cuenta','=','rps_cuentas.id')
           ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
           ->where('patrimonio_cuentas.id_patrimonio',$id_patrimonio)
           ->whereNull('patrimonio_cuentas.deleted_at')
           ->whereNull('cdcu.deleted_at')
           ->whereNull('cdrs.deleted_at')
           ->whereNull('rps.deleted_at')
           ->whereNull('rps_cuentas.deleted_at')
           ->whereNull('rp_operaciones.deleted_at')
           ->select( DB::raw('sum(rp_operaciones.valor_operacion_rp) as valor_rp_operaciones'))
           ->get();

           if(count($rp_operaciones) > 0){
            $value->valor_comprometido = $rp_operaciones[0]->valor_rp_operaciones;
            }else{
                $value->valor_comprometido= 0;
            }

           $valorPagos = patrimonios_cuentas::join('cdrs_cuentas as cdcu','patrimonio_cuentas.id','=','cdcu.id_cuenta')
           ->join('cdrs','cdrs.id','=','cdcu.id_cdr')
           ->join('rps','rps.id_cdr','=','cdrs.id')
           ->join('rps_cuentas','rps_cuentas.id_rp','=','rps.id')
           ->join('obl_operaciones','obl_operaciones.id_rp_cuenta','rps_cuentas.id')
           ->join('endoso','endoso.id_obl','=','obl_operaciones.id')
           ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
           ->where('patrimonio_cuentas.id_patrimonio',$id_patrimonio)
           ->whereNull('patrimonio_cuentas.deleted_at')
           ->whereNull('cdcu.deleted_at')
           ->whereNull('cdrs.deleted_at')
           ->whereNull('rps.deleted_at')
           ->whereNull('rps_cuentas.deleted_at')
           ->select( DB::raw('sum(endoso.valor_endoso) as valor_pagos'))
           ->get();

          // dd($valorPagos[0]->valor_pagos);

           if(count($valorPagos) > 0){
                $value->valor_pagos = $valorPagos[0]->valor_pagos;
            }else{
                $value->valor_pagos = 0;
            }

        }

        //dd($recursos);


        /*->Join('patrimonio_cuentas','patrimonio_cuentas.id_patrimonio','=','patrimonios.id')
        ->Join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
        ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
        
        ->whereNull('patrimonio_cuentas.deleted_at')
        ->whereNull('patrimonio_cuenta_movimientos.deleted_at')*/

            /*Select proyectos.id,sum(contratos.valor_contrato)
            from proyectos
            Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
            Inner join contratos on proyectos_convenios.id_contrato = contratos.id
            where proyectos.id=1
            and proyectos_convenios.deleted_at is null
            group by proyectos.id*/

            /*$ValorDesembolso = Proyectos::where('proyectos.id','=',$id)
            ->join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
            ->join('contratos as c','proyectos_convenios.id_contrato','=','c.id')
            ->join('contratos_pads_convenios as cc','c.id','=','cc.id_contrato_convenio')
            ->join('contratos as cpd','cc.id_contrato_pad','=','cpd.id')
            ->join('patrimonios as pa','cpd.id','=','pa.id_contrato_pad')
            ->join('patrimonio_cuentas as pcu','pa.id','=','pcu.id_patrimonio')
            ->join('cdrs_cuentas as cdcu','pcu.id','=','cdcu.id_cuenta')
            ->join('cdr_operaciones as cdop','cdcu.id','=','cdop.id_cdr_cuenta')
            ->where('cdop.fecha_operacion','<=',$fecha)
            ->whereNull('proyectos_convenios.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('cdop.deleted_at')
            ->whereNull('pcu.deleted_at')
            ->whereNull('cdop.deleted_at')
            ->select( DB::raw('sum(cdop.valor_operacion) as Valor'))
            ->get();*/

            /*$ValorDesembolso = Proyectos::where('proyectos.id','=',$id)
            ->join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
            ->join('contratos as c','proyectos_convenios.id_contrato','=','c.id')
            ->join('contratos_pads_convenios as cc','c.id','=','cc.id_contrato_convenio')
            ->join('contratos as cpd','cc.id_contrato_pad','=','cpd.id')
            ->join('patrimonios as pa','cpd.id','=','pa.id_contrato_pad')
            ->join('patrimonio_cuentas as pcu','pa.id','=','pcu.id_patrimonio')
            ->join('cdrs_cuentas as cdcu','pcu.id','=','cdcu.id_cuenta')
            ->join('cdr_operaciones as cdop','cdcu.id','=','cdop.id_cdr_cuenta')
            ->whereNull('proyectos_convenios.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('cdop.deleted_at')
            ->whereNull('pcu.deleted_at')
            ->whereNull('cdop.deleted_at')
            ->select( DB::raw('sum(cdop.valor_operacion) as Valor'))
            ->distinct()
            ->get();*/

            $ValorDesembolso=Proyectos::where('proyectos.id','=',$id)
            ->Join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
            ->Join('contratos','proyectos_convenios.id_contrato','=','contratos.id')
            ->Join('contratos_pads_convenios','contratos_pads_convenios.id_contrato_convenio','=','contratos.id')
            ->Join('contratos as pads','pads.id','=','contratos_pads_convenios.id_contrato_pad')
            ->Join('patrimonios','patrimonios.id_contrato_pad','=','pads.id')
            ->Join('patrimonio_cuentas','patrimonio_cuentas.id_patrimonio','=','patrimonios.id')
            ->Join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
            ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
            ->whereIn('patrimonio_cuenta_movimientos.id_param_tipo_movimiento', [1, 2])
            ->whereNull('proyectos_convenios.deleted_at')
            ->whereNull('contratos_pads_convenios.deleted_at')
            ->whereNull('patrimonios.deleted_at')
            ->whereNull('patrimonio_cuentas.deleted_at')
            ->whereNull('patrimonio_cuenta_movimientos.deleted_at')
            ->select( DB::raw('sum(patrimonio_cuenta_movimientos.valor) as Valor'))
            ->get();

            //dd($ValorDesembolso);


        /*Select proyectos.id,sum(cdop.valor_operacion)
        from proyectos
        Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
        Inner join contratos c on proyectos_convenios.id_contrato = c.id
        Inner join contratos_pads_convenios cc on c.id= cc.id_contrato_convenio
        Inner join contratos cpd on cc.id_contrato_pad = cpd.id
        Inner join patrimonios pa on cpd.id = pa.id_contrato_pad
        Inner join patrimonio_cuentas pcu on pa.id = pcu.id_patrimonio
        inner join cdrs_cuentas cdcu on pcu.id = cdcu.id_cuenta
        inner join cdr_operaciones cdop on cdcu.id = cdop.id_cdr_cuenta
        where proyectos.id = 1
        and proyectos_convenios.deleted_at is null
        and cc.deleted_at is null
        and cdop.deleted_at is null
        and pcu.deleted_at  is null
        and cdop.deleted_at is null*/

        $valorComprometido= Proyectos::where('proyectos.id','=',$id)
        ->join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
        ->join('contratos as c','proyectos_convenios.id_contrato','=','c.id')
        ->join('contratos_pads_convenios as cc','c.id','=','cc.id_contrato_convenio')
        ->join('contratos as cpd','cc.id_contrato_pad','=','cpd.id')
        ->join('patrimonios as pa','cpd.id','=','pa.id_contrato_pad')
        ->join('patrimonio_cuentas as pcu','pa.id','=','pcu.id_patrimonio')
        ->join('cdrs_cuentas as cdcu','pcu.id','=','cdcu.id_cuenta')
        ->join('cdr_operaciones as cdop','cdop.id_cdr_cuenta','=','cdcu.id')
        ->where('pcu.id_param_tipo_cuenta',1)
        ->whereNull('proyectos_convenios.deleted_at')
        ->whereNull('cc.deleted_at')
        ->whereNull('pcu.deleted_at')
        ->whereNull('cdcu.deleted_at')
        ->whereNull('cdop.deleted_at')
        ->select( DB::raw('sum(cdop.valor_operacion) as Valor'))
        ->get();

        //dd($valorComprometido);

       /* Select proyectos.id,sum(rpop.valor_operacion_rp)
        from proyectos
        Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
        Inner join contratos c on proyectos_convenios.id_contrato = c.id
        Inner join contratos_pads_convenios cc on c.id= cc.id_contrato_convenio
        Inner join contratos cpd on cc.id_contrato_pad = cpd.id
        Inner join patrimonios pa on cpd.id = pa.id_contrato_pad
        Inner join patrimonio_cuentas pcu on pa.id = pcu.id_patrimonio
        inner join cdrs_cuentas cdcu on pcu.id = cdcu.id_cuenta
        inner join cdrs on cdcu.id_cdr = cdrs.id
        inner join rps on cdrs.id = rps.id_cdr
        INNER join rps_cuentas rpcu on rps.id = rpcu.id_rp
        inner join rp_operaciones rpop on rpcu.id = rpop.id_rp_cuenta
        where proyectos.id = 1
        and proyectos_convenios.deleted_at is null
        and cc.deleted_at is null
        and pcu.deleted_at is null
        and cdcu.deleted_at is null
        and cdrs.deleted_at is null
        and rps.deleted_at is null
        and rpcu.deleted_at is null
        and rpop.deleted_at is null*/

       /* $valorRendimientoFinanciero= Proyectos::where('proyectos.id','=',$id)
        ->join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
        ->join('contratos as c','proyectos_convenios.id_contrato','=','c.id')
        ->join('contratos_pads_convenios as cc','c.id','=','cc.id_contrato_convenio')
        ->join('contratos as cpd','cc.id_contrato_pad','=','cpd.id')
        ->join('patrimonios as pa','cpd.id','=','pa.id_contrato_pad')
        ->join('patrimonio_cuentas as pcu','pa.id','=','pcu.id_patrimonio')
        ->join('patrimonio_cuenta_movimientos as pcm','pcu.id','=','pcm.id_cuenta')
        ->where('pcm.id_param_tipo_movimiento','=',3)
        ->where('pcm.created_at', '<=', date($fecha).' 23:59:59')
        ->whereNull('proyectos_convenios.deleted_at')
        ->whereNull('cc.deleted_at')
        ->whereNull('pcu.deleted_at')
        ->whereNull('pcm.deleted_at')
        ->select( DB::raw('sum(pcm.valor) as Valor'))
        ->distinct()
        ->get();*/


        $valorRendimientoFinanciero=Proyectos::where('proyectos.id','=',$id)
            ->Join('proyectos_convenios','proyectos.id','=','proyectos_convenios.id_proyecto')
            ->Join('contratos','proyectos_convenios.id_contrato','=','contratos.id')
            ->Join('contratos_pads_convenios','contratos_pads_convenios.id_contrato_convenio','=','contratos.id')
            ->Join('contratos as pads','pads.id','=','contratos_pads_convenios.id_contrato_pad')
            ->Join('patrimonios','patrimonios.id_contrato_pad','=','pads.id')
            ->Join('patrimonio_cuentas','patrimonio_cuentas.id_patrimonio','=','patrimonios.id')
            ->Join('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
            ->where('patrimonio_cuentas.id_param_tipo_cuenta',1)
            ->where('patrimonio_cuenta_movimientos.id_param_tipo_movimiento',3)
            ->whereNull('proyectos_convenios.deleted_at')
            ->whereNull('contratos_pads_convenios.deleted_at')
            ->whereNull('patrimonios.deleted_at')
            ->whereNull('patrimonio_cuentas.deleted_at')
            ->whereNull('patrimonio_cuenta_movimientos.deleted_at')
            ->select( DB::raw('sum(patrimonio_cuenta_movimientos.valor) as Valor'))
            ->get();



       /* Select proyectos.id,pcm.*
        from proyectos
        Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
        Inner join contratos c on proyectos_convenios.id_contrato = c.id
        Inner join contratos_pads_convenios cc on c.id= cc.id_contrato_convenio
         Inner join contratos cpd on cc.id_contrato_pad = cpd.id
         Inner join patrimonios pa on cpd.id = pa.id_contrato_pad
         Inner join patrimonio_cuentas pcu on pa.id = pcu.id_patrimonio
         inner join patrimonio_cuenta_movimientos pcm on pcu.id = pcm.id_cuenta
         where proyectos.id = 1
         and id_param_tipo_movimiento=3*/

        /*$pagos= Proyectos::where('proyectos.id','=',$id)
         ->join('fases','proyectos.id','=','fases.id_proyecto')
         ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase')
         ->join('contratos','contratos.id','=','fases_relaciones_contratos.id_contrato')
         ->join('contratos_terceros','contratos.id','=','contratos_terceros.id_contrato')
         ->join('terceros','contratos_terceros.id_terecero','=','terceros.id')
         ->join('rps','contratos.id','=','rps.id_contrato')
         ->join('rps_cuentas','rps.id','=','rps_cuentas.id_rp')
         ->join('obl_operaciones','rps_cuentas.id','=','obl_operaciones.id_rp_cuenta')
        ->where('obl_operaciones.param_estado_obl_operacion_valor','=',1)
        ->where('obl_operaciones.fecha_obl_operacion','<=',$fecha)
        ->whereNull('fases_relaciones_contratos.deleted_at')
        ->whereNull('contratos_terceros.deleted_at')
        ->whereNull('rps_cuentas.deleted_at')
        ->whereNull('obl_operaciones.deleted_at')
        ->select('obl_operaciones.fecha_obl_operacion','terceros.nombre','contratos.valor_contrato','rps.objeto_rp','obl_operaciones.valor_operacion_obl','contratos.id','contratos.numero_contrato')
        ->OrderBy('contratos.id')
        ->get();*/






         /*
         Select distinct proyectos.id,terceros.nombre,contratos.valor_contrato,rps.objeto_rp,obl_operaciones.valor_operacion_obl,contratos.valor_contrato-obl_operaciones.valor_operacion_obl ValorSaldo
        from proyectos
        Inner join proyectos_convenios on proyectos.id = proyectos_convenios.id_proyecto
        Inner join contratos on proyectos_convenios.id_contrato = contratos.id
        inner join contratos_terceros on contratos.id = contratos_terceros.id_contrato
        Inner join terceros on contratos_terceros.id_terecero = terceros.id
        inner join rps on contratos.id = rps.id_contrato
        inner join rps_cuentas on rps.id = rps_cuentas.id_rp
        Inner join obl_operaciones on rps_cuentas.id=obl_operaciones.id_rp_cuenta
         Where proyectos.id = 1
        and obl_operaciones.param_estado_obl_operacion_valor=1*/


        $fases_val = fases::whereNull('fases.deleted_at')
                      ->select('fases.peso_porcentual_fase','fases.id','fases.param_tipo_fase_texto')
                      ->where('id_proyecto',$id)
                      ->get();

        $datos = 0;


        foreach ($fases_val as $value) {

            if($value->peso_porcentual_fase == null)
            {
            $validate = 1;
            }

            $id_fase = $value->id;

            $fases_planes_val = fases_planes::whereNull('fases_planes.deleted_at')
                ->select('fases_planes.peso_porcentual_etapa','fases_planes.id','fases_planes.nombre_plan')
                ->where('id_fase',$id_fase)
                ->get();

                foreach ($fases_planes_val as $plan) {

                    if($plan->peso_porcentual_etapa == null)
                    {
                       $validate = 1;
                    }
                    $id_actividad = $plan->id;
                }
        }

        //dd($fases_val);

       /* leftJoin('fases_planes','fases_planes.id_fase','=','fases.id')
                      ->leftJoin('fases_actividades','fases_actividades.id_fase_plan','=','fases_planes.id')
                      ->
                      ->
                      ->whereNull('fases_actividades.deleted_at')
                      ->where('fases_actividades.param_tipo_caracteristica_actividad_valor',1)
                      ->select('fases.peso_porcentual_fase','fases_planes.peso_porcentual_etapa','fases_actividades.peso_porcentual_hito','fases_actividades.peso_porcentual_proyecto')
                      ->groupBy('fases.peso_porcentual_fase')*/


        $tecnicos =   DB::select('call usp_proyecto_consultarAvanceFaseGrafica(?,?)',array($id,$id_semana_parametrica));

        //dd($tecnicos);

       $fechaInicio = date("y-m-d",strtotime($fecha."-14 days"));

       /* $bitacoras= fases::where('fases.id_proyecto','=',$id)
        ->join('fases_Informe_semanal','fases.id','=','fases_Informe_semanal.id_fase')
        ->join('fases_informe_semanal_bitacora','fases_Informe_semanal.id','=','fases_informe_semanal_bitacora.id_fases_Informe_semanal')
        ->select('fases_informe_semanal_bitacora.fecha','fases_informe_semanal_bitacora.Descripcion_gestion','fases_informe_semanal_bitacora.image')
        ->where('fases_Informe_semanal.fecha_elaboracion','>=',$fechaInicio)
        ->where('fases_Informe_semanal.fecha_elaboracion','<=',$fecha)
        ->get();*/

        $fases = fases_act::where('id_proyecto',$id)
        ->whereNull('deleted_at')
        ->select('id')
        ->get();

        $id_fases = $fases->toArray();

        $id_semana_actual = $id_semana_parametrica;
        $id_semana_anterior = $id_semana_parametrica - 1;

        $bitacoras = [];
        $bitacoras_anterior = [];

        $i=0;

        foreach ($id_fases as  $value) {

            $id_fase = $value['id'];

            $informe_semanal_actual = fases_Informe_semanal::where('id_fase',$id_fase)
            ->where('id_semana_parametrica',$id_semana_actual)
            ->whereNull('deleted_at')
            ->select('id')
            ->first();

            if($informe_semanal_actual != null)
            {
                $id_informe = $informe_semanal_actual->id;

                $consulta_bitacoras = fases_Informe_semanal_bitacora::where('id_fases_Informe_semanal',$id_informe)
                ->whereNull('deleted_at')
                ->get();

                if(count($consulta_bitacoras) > 0)
                {
                    $bitacoras[$i] = $consulta_bitacoras;
                }
            }

            $informe_semanal_anterior = fases_Informe_semanal::where('id_fase',$id_fase)
            ->where('id_semana_parametrica',$id_semana_anterior)
            ->whereNull('deleted_at')
            ->select('id')
            ->first();

            if($informe_semanal_anterior != null)
            {
                $id_informe_anterior = $informe_semanal_anterior->id;

                $consulta_bitacoras_anteriores = fases_Informe_semanal_bitacora::where('id_fases_Informe_semanal',$id_informe_anterior)
                ->whereNull('deleted_at')
                ->get();

                if(count($consulta_bitacoras_anteriores) > 0)
                {
                    $bitacoras_anterior[$i] = $consulta_bitacoras_anteriores;
                }
            }

            $i++;
        }

       /* SELECT fases_Informe_semanal_bitacora.fecha,fases_Informe_semanal_bitacora.Descripcion_gestion
        FROM fases
       left join fases_Informe_semanal on fases.id = fases_Informe_semanal.id_fase
        left join fases_Informe_semanal_bitacora on fases_Informe_semanal.id = fases_Informe_semanal_bitacora.id_fases_Informe_semanal
        WHERE id_proyecto=1*/

        $AreaMetro =proyectos_caracteristicas::where([['id_proyecto','=',$id],
                                                ['param_tipo_proyecto_caracteristica_valor','=',2]])
        ->get();

       /*$detalleEjecuciones = fases::where('fases.id_proyecto','=',$id)
        ->join('fases_planes','fases.id','=','fases_planes.id_fase')
        ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->leftjoin('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->leftjoin('semanas_parametrica','fases_actividades_planeacion.id_semana_parametrica','=','semanas_parametrica.id')
        ->leftjoin('fases_Informe_semanal',function($join){
            $join->on('fases_Informe_semanal.id_fase','=','fases.id')
            ->on('fases_Informe_semanal.id_semana_parametrica','=','semanas_parametrica.id');})
        ->where('fases_actividades_planeacion.id_semana_parametrica','<=',$id_semana_parametrica)
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades.deleted_at')
        ->whereNull('fases_actividades_planeacion.deleted_at')
        ->where('fases_actividades.param_tipo_caracteristica_actividad_valor','=',1)
        ->select('fases.param_tipo_fase_texto','fases_actividades_planeacion.id_semana_parametrica','semanas_parametrica.fecha_inicial','fases.id as idFase',
            DB::raw('sum(fases_actividades_planeacion.porcentaje_programado)/count(fases_actividades_planeacion.id) as porcentaje_programado'),
            DB::raw('Sum(IFNULL(fases_actividades_planeacion.porcentaje_ejecutado,0))/count(fases_actividades_planeacion.id) as porcentaje_ejecutado'),
            DB::raw('CONCAT(fases.param_tipo_fase_texto,ifnull(CONCAT("-",fases.id_padre),"")) as fase'))
               ->groupby('fases_actividades_planeacion.id_semana_parametrica','fases.param_tipo_fase_texto','semanas_parametrica.fecha_inicial','fases.id_padre','fases.id')
            ->orderby('fases.param_tipo_fase_texto','asc')->orderby('fases_actividades_planeacion.id_semana_parametrica','Asc')

        ->get();*/



        /*$detalleEjecuciones = DB::select('call usp_consulta_avance_por_semana(?,?)',array($id,$id_semana_parametrica));

        //dd($detalleEjecuciones);

        $fases = array();
        foreach($detalleEjecuciones as $detalleEjecucione)
        {
            $fases = $detalleEjecucione->param_tipo_fase_texto;
        }*/

      /*$fechas = fases::where('fases.id_proyecto','=',$id)
        ->join('fases_planes','fases.id','=','fases_planes.id_fase')
        ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->join('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->join('semanas_parametrica','fases_actividades_planeacion.id_semana_parametrica','=','semanas_parametrica.id')
        ->leftjoin('fases_Informe_semanal',function($join){
            $join->on('fases_Informe_semanal.id_fase','=','fases.id')
            ->on('fases_Informe_semanal.id_semana_parametrica','=','semanas_parametrica.id');})
        ->where('fases_actividades_planeacion.id_semana_parametrica','<=',$id_semana_parametrica)
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades.deleted_at')
        ->whereNull('fases_actividades_planeacion.deleted_at')
        ->where('fases_actividades.param_tipo_caracteristica_actividad_valor','=',1)
        ->select('semanas_parametrica.fecha_inicial','fases_actividades_planeacion.id_semana_parametrica')->distinct()
        ->orderby('fases_actividades_planeacion.id_semana_parametrica','Asc')

        ->get();*/

            /*select distinct
            sp.id,
            sp.fecha_inicial
            from
            fases f inner join
            fases_planes fp on f.id = fp.id_fase inner join
            fases_actividades fa on fp.id = fa.id_fase_plan inner join
            fases_actividades_planeacion fap on fa.id = fap.id_fase_actividad inner JOIN
            semanas_parametrica sp on fap.id_semana_parametrica = sp.id
            where
            f.id_proyecto  = 42 AND
            fa.deleted_at is null AND
            fp.deleted_at is null AND
            fap.deleted_at is null
            order by fecha_inicial

            $fechas = fases::where('fases.id_proyecto','=',$id)
            ->join('fases_planes','fases.id','=','fases_planes.id_fase')
            ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
            ->join('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
            ->join('semanas_parametrica','fases_actividades_planeacion.id_semana_parametrica','=','semanas_parametrica.id')
            ->whereNull('fases_planes.deleted_at')
            ->whereNull('fases_actividades.deleted_at')
            ->whereNull('fases_actividades_planeacion.deleted_at')
            ->where('fases_actividades.param_tipo_caracteristica_actividad_valor','=',1)
            ->select('semanas_parametrica.fecha_inicial','semanas_parametrica.id')
            ->distinct()
            ->orderby('semanas_parametrica.fecha_inicial','Asc')
            ->get();*/

           $fechas = DB::select('call usp_consulta_avance_por_semana_fechas(?)',array($id));

            $fechas_array = [];

            foreach ($fechas as  $value) {

                $fechas_array[$value->id_semana_parametrica] = $value->fecha_inicial;

            };

            $datos_proceso = DB::select('call usp_consulta_Avance_Programado_Ejecutado(?,?)',array($id,$id_semana_parametrica));

            $datos_procesos_array = [];
            $datos_semaforo_array = [];
            $acumulado_ejec = 0;
            $acumulado_prog = 0;
            $fase = '';

            foreach($datos_proceso as $item){

               if($fase != $item->param_tipo_fase_texto){

                $acumulado_ejec = 0;
                $acumulado_prog = 0;

               }
               $fase = $item->param_tipo_fase_texto;

                $datos_procesos_array[$item->param_tipo_fase_texto.'- Programado'][$item->id_semana_parametrica] = $item->programado;

                $acumulado_prog += $item->programado;

                if($item->mostrarEjecucion == 1){
                    $datos_procesos_array[$item->param_tipo_fase_texto.'- Ejecutado'][$item->id_semana_parametrica] = $item->ejecutado;

                    $acumulado_ejec += $item->ejecutado;
                    $diferencia =  $acumulado_prog -  $acumulado_ejec;

                    //dd($diferencia);


                        if($diferencia < 5) {

                            $datos_semaforo_array['Green'][$item->id_semana_parametrica] = 1;

                        }else if( $diferencia < 15){

                            $datos_semaforo_array['Yellow'][$item->id_semana_parametrica] = 1;

                        }else{

                            $datos_semaforo_array['Red'][$item->id_semana_parametrica] = 1;

                        }


                }
            }

           // dd($id,$id_semana_parametrica,$datos_proceso,$datos_procesos_array ,$datos_semaforo_array);

       //dd( $detalleEjecuciones);
        /*Select fases.param_tipo_fase_texto,fases_actividades_planeacion.id_semana_parametrica,semanas_parametrica.fecha_inicial,fases.id as idFase,sum(fases_actividades_planeacion.porcentaje_programado)/count(fases_actividades_planeacion.id) as porcentaje_programado,Sum(IFNULL(fases_actividades_planeacion.porcentaje_ejecutado,0))/count(fases_actividades_planeacion.id) as porcentaje_ejecutado,CONCAT(fases.param_tipo_fase_texto,ifnull(CONCAT("-",fases.id_padre),"")) as fase
        from fases
        inner join fases_planes on fases.id=fases_planes.id_fase
        Inner join fases_actividades on fases_planes.id=fases_actividades.id_fase_plan
        Inner join fases_actividades_planeacion on fases_actividades.id=fases_actividades_planeacion.id_fase_actividad
        inner join semanas_parametrica on fases_actividades_planeacion.id_semana_parametrica=semanas_parametrica.id
        left join fases_Informe_semanal on fases_Informe_semanal.id_fase=fases.id and
        fases_Informe_semanal.id_semana_parametrica=semanas_parametrica.id
        where fases.id_proyecto = 29
        and fases_Informe_semanal.fecha_elaboracion<='2021-02-28'
        group by fases_actividades_planeacion.id_semana_parametrica,fases.param_tipo_fase_texto,semanas_parametrica.fecha_inicial,fases.id_padre,fases.id */



        $gestiones_sociales  = gestiones_sociales ::where('gestiones_sociales.id_proyecto','=',$id)
        ->join('fases_relaciones_contratos','gestiones_sociales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->join('users','gestiones_sociales.id_usuario','=','users.id')
        ->select('gestiones_sociales.consecutivo','gestiones_sociales.fecha_informe','contratos.numero_contrato','users.name',
        'gestiones_sociales.id as id_gestion_social')
        ->where('gestiones_sociales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_sociales.fecha_informe','<=',$fecha)
        ->get();

        //dd($fechaInicio,$fecha, $gestiones_sociales);
        /*
        SELECT gestiones_sociales.consecutivo,gestiones_sociales.fecha_informe,contratos.numero_contrato,users.name
        FROM gestiones_sociales
        Inner join fases_relaciones_contratos on gestiones_sociales.id_fases_relaciones_contratos = fases_relaciones_contratos.id
        Inner join contratos on fases_relaciones_contratos.id_contrato = contratos.id
        inner join users on gestiones_sociales.id_usuario = users.id*/

        $gestiones_sociales_detalles  = gestiones_sociales ::where('gestiones_sociales.id_proyecto','=',$id)
        ->join('gestiones_sociales_sociales','gestiones_sociales.id','=','gestiones_sociales_sociales.id_gestiones_sociales')
        ->select('gestiones_sociales_sociales.param_caracteristicas_texto','gestiones_sociales_sociales.valor',
        'gestiones_sociales_sociales.observaciones','gestiones_sociales.id as id_gestion_social')
        ->where('gestiones_sociales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_sociales.fecha_informe','<=',$fecha)
        ->get();


        $gestiones_sociales_bitacora  = gestiones_sociales ::where('gestiones_sociales.id_proyecto','=',$id)
        ->join('gestion_social_bitacora','gestiones_sociales.id','=','gestion_social_bitacora.id_gestion_social')
        ->select('gestion_social_bitacora.fecha','gestion_social_bitacora.descripcion_gestion',
        'gestion_social_bitacora.vinculo','gestiones_sociales.id as id_gestion_social')
        ->where('gestiones_sociales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_sociales.fecha_informe','<=',$fecha)
        ->get();

            

        /*SELECT gestiones_sociales_sociales.param_caracteristicas_texto,gestiones_sociales_sociales.valor,gestiones_sociales_sociales.observaciones
        FROM gestiones_sociales
        Inner join gestiones_sociales_sociales on gestiones_sociales.id = gestiones_sociales_sociales.id_gestiones_sociales
        Where gestiones_sociales.id_proyecto=29*/

        $gestiones_ambientales  = gestiones_ambientales ::where('gestiones_ambientales.id_proyecto','=',$id)
        ->join('fases_relaciones_contratos','gestiones_ambientales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->join('users','gestiones_ambientales.id_usuario','=','users.id')
        ->select('gestiones_ambientales.consecutivo','gestiones_ambientales.fecha_informe','contratos.numero_contrato','users.name',
        'gestiones_ambientales.id as id_gestiones_ambientales')
        ->where('gestiones_ambientales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_ambientales.fecha_informe','<=',$fecha)
        ->get();

        /*SELECT gestiones_ambientales.consecutivo,gestiones_ambientales.fecha_informe,contratos.numero_contrato,users.name
        FROM gestiones_ambientales
        Inner join fases_relaciones_contratos on gestiones_ambientales.id_fases_relaciones_contratos = fases_relaciones_contratos.id
        Inner join contratos on fases_relaciones_contratos.id_contrato = contratos.id
        inner join users on gestiones_ambientales.id_usuario = users.id*/

        $gestiones_ambientales_fuentes  = gestiones_ambientales ::where('gestiones_ambientales.id_proyecto','=',$id)
        ->join('gestiones_ambientales_fuente_materiales','gestiones_ambientales.id','=','gestiones_ambientales_fuente_materiales.id_gestiones_ambientales')
        ->join('municipios','gestiones_ambientales_fuente_materiales.id_municipios','=','municipios.id')
        ->join('departamentos','municipios.id_departamento','=','departamentos.id')
        ->select('departamentos.nombre_departamento','municipios.nombre_municipio','gestiones_ambientales_fuente_materiales.ubicacion',
            DB::raw('case gestiones_ambientales_fuente_materiales.permiso_minero when "S" then "Si" when "N" then "No" when "X" then "No Aplica" end permiso'),
            DB::raw('case gestiones_ambientales_fuente_materiales.permiso_ambiental when "S" then "Si" when "N" then "No" when "X" then "No Aplica" end FuenteMateriales') ,
            'gestiones_ambientales_fuente_materiales.observaciones','gestiones_ambientales_fuente_materiales.id_gestiones_ambientales')
        ->where('gestiones_ambientales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_ambientales.fecha_informe','<=',$fecha)
        ->get();


        /*SELECT departamentos.nombre_departamento,municipios.nombre_municipio,gestiones_ambientales_fuente_materiales.ubicacion,case gestiones_ambientales_fuente_materiales.permiso_minero when 'S' then 'Si' when 'N' then 'No' when 'X' then 'No Aplica' end permiso, case gestiones_ambientales_fuente_materiales.permiso_ambiental when 'S' then 'Si' when 'N' then 'No' when 'X' then 'No Aplica' end FuenteMateriales ,gestiones_ambientales_fuente_materiales.observaciones,gestiones_ambientales_fuente_materiales.id_gestiones_ambientales
        FROM gestiones_ambientales
        Inner join gestiones_ambientales_fuente_materiales on gestiones_ambientales.id = gestiones_ambientales_fuente_materiales.id_gestiones_ambientales
        inner join municipios on gestiones_ambientales_fuente_materiales.id_municipios = municipios.id
        inner JOIN departamentos on municipios.id_departamento = departamentos.id
        WHERE gestiones_ambientales.id_proyecto=29*/

        $gestiones_ambientales_permisos  = gestiones_ambientales ::where('gestiones_ambientales.id_proyecto','=',$id)
        ->join('gestiones_ambientales_permisos_ambientales','gestiones_ambientales.id','=','gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales')
        ->select('gestiones_ambientales_permisos_ambientales.param_tipo_permiso_text','gestiones_ambientales_permisos_ambientales.documento_soporte',
            'gestiones_ambientales_permisos_ambientales.seguimiento','gestiones_ambientales_permisos_ambientales.observaciones',
            'gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales')
        ->where('gestiones_ambientales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_ambientales.fecha_informe','<=',$fecha)
        ->whereNull('gestiones_ambientales_permisos_ambientales.deleted_at')
        ->get();


        $gestiones_ambientales_bitacora  = gestiones_ambientales ::where('gestiones_ambientales.id_proyecto','=',$id)
        ->join('gestiones_ambientales_bitacora','gestiones_ambientales.id','=','gestiones_ambientales_bitacora.id_gestion_ambiental')
        ->select('gestiones_ambientales_bitacora.fecha','gestiones_ambientales_bitacora.descripcion_gestion',
            'gestiones_ambientales_bitacora.vinculo','gestiones_ambientales_bitacora.imagen',
            'gestiones_ambientales_bitacora.id_gestion_ambiental')
        ->where('gestiones_ambientales.fecha_informe','>=',$fechaInicio)
        ->where('gestiones_ambientales.fecha_informe','<=',$fecha)
        ->whereNull('gestiones_ambientales_bitacora.deleted_at')
        ->get();




        /*SELECT gestiones_ambientales_permisos_ambientales.param_tipo_permiso_text,gestiones_ambientales_permisos_ambientales.documento_soporte,gestiones_ambientales_permisos_ambientales.seguimiento,gestiones_ambientales_permisos_ambientales.observaciones,gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales
            FROM gestiones_ambientales
            Inner join gestiones_ambientales_permisos_ambientales on gestiones_ambientales.id = gestiones_ambientales_permisos_ambientales.id_gestiones_ambientales
            Where gestiones_ambientales.id_proyecto=29*/

        $calidad_seguridad_industriales  = calidad_seguridad_industriales ::where('calidad_seguridad_industriales.id_proyecto','=',$id)
            ->join('fases_relaciones_contratos','calidad_seguridad_industriales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
            ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
            ->join('users','calidad_seguridad_industriales.id_usuario','=','users.id')
            ->select('calidad_seguridad_industriales.consecutivo','calidad_seguridad_industriales.fecha_informe','contratos.numero_contrato','users.name',
            'calidad_seguridad_industriales.id as id_calidad_seguridad_industrial')
            ->where('calidad_seguridad_industriales.fecha_informe','>=',$fechaInicio)
            ->where('calidad_seguridad_industriales.fecha_informe','<=',$fecha)
            ->get();

          /*SELECT calidad_seguridad_industriales.consecutivo,calidad_seguridad_industriales.fecha_informe,contratos.numero_contrato,users.name
            FROM calidad_seguridad_industriales
            Inner join fases_relaciones_contratos on calidad_seguridad_industriales.id_fases_relaciones_contratos = fases_relaciones_contratos.id
            Inner join contratos on fases_relaciones_contratos.id_contrato = contratos.id
            inner join users on calidad_seguridad_industriales.id_usuario = users.id
            WHERE 1*/

            $calidad_seguridad_industriales_inspecciones  = calidad_seguridad_industriales ::where('calidad_seguridad_industriales.id_proyecto','=',$id)
            ->join('calidad_seguridad_industrial_inspeccion_ensayos','calidad_seguridad_industriales.id','=','calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial')
            ->select(
            'calidad_seguridad_industrial_inspeccion_ensayos.control_inspeccion_ensayos',
            'calidad_seguridad_industrial_inspeccion_ensayos.recomendaciones',
            'calidad_seguridad_industrial_inspeccion_ensayos.param_tipo_prueba_texto',
            'calidad_seguridad_industrial_inspeccion_ensayos.unidad_ejecutora',
            'calidad_seguridad_industrial_inspeccion_ensayos.nombre_especialista',
            'calidad_seguridad_industrial_inspeccion_ensayos.localizacion',
            'calidad_seguridad_industrial_inspeccion_ensayos.fecha_toma_prueba',
            'calidad_seguridad_industrial_inspeccion_ensayos.resultados_prueba',
            'calidad_seguridad_industrial_inspeccion_ensayos.fecha_resultado_prueba',
            'calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial'
            )
            ->where('calidad_seguridad_industriales.fecha_informe','>=',$fechaInicio)
            ->where('calidad_seguridad_industriales.fecha_informe','<=',$fecha)
            ->get();

            /*SELECT calidad_seguridad_industrial_inspeccion_ensayos.control_inspeccion_ensayos,calidad_seguridad_industrial_inspeccion_ensayos.recomendaciones,calidad_seguridad_industrial_inspeccion_ensayos.param_tipo_prueba_texto,calidad_seguridad_industrial_inspeccion_ensayos.unidad_ejecutora,calidad_seguridad_industrial_inspeccion_ensayos.nombre_especialista,calidad_seguridad_industrial_inspeccion_ensayos.localizacion,calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial
            FROM calidad_seguridad_industriales
            Inner join calidad_seguridad_industrial_inspeccion_ensayos on calidad_seguridad_industriales.id = calidad_seguridad_industrial_inspeccion_ensayos.id_calidad_seguridad_industrial
            Where calidad_seguridad_industriales.id_proyecto=29*/

            $calidad_seguridad_industriales_obras  = calidad_seguridad_industriales ::where('calidad_seguridad_industriales.id_proyecto','=',$id)
            ->join('calidad_seguridad_industrial_equipos_obras','calidad_seguridad_industriales.id','=','calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial')
            ->select('calidad_seguridad_industrial_equipos_obras.control_equipos_obra','calidad_seguridad_industrial_equipos_obras.recomendaciones',
            'calidad_seguridad_industrial_equipos_obras.actividad_labor_realizada','calidad_seguridad_industrial_equipos_obras.equipo_utilizado',
            'calidad_seguridad_industrial_equipos_obras.nombre_especialista','calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial')
            ->where('calidad_seguridad_industriales.fecha_informe','>=',$fechaInicio)
            ->where('calidad_seguridad_industriales.fecha_informe','<=',$fecha)
            ->get();

            /*
            SELECT calidad_seguridad_industrial_equipos_obras.control_equipos_obra,calidad_seguridad_industrial_equipos_obras.recomendaciones,calidad_seguridad_industrial_equipos_obras.actividad_labor_realizada,calidad_seguridad_industrial_equipos_obras.equipo_utilizado,calidad_seguridad_industrial_equipos_obras.nombre_especialista
            FROM calidad_seguridad_industriales
            Inner join calidad_seguridad_industrial_equipos_obras on calidad_seguridad_industriales.id = calidad_seguridad_industrial_equipos_obras.id_calidad_seguridad_industrial
            Where calidad_seguridad_industriales.id_proyecto=29*/

            $calidad_seguridad_industriales_Seguridad  = calidad_seguridad_industriales ::where('calidad_seguridad_industriales.id_proyecto','=',$id)
            ->join('calidad_seguridad_industrial_seguridad_industrial','calidad_seguridad_industriales.id','=','calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial')
            ->select(DB::raw('case calidad_seguridad_industrial_seguridad_industrial.accidente_laboral_incidente when 1 then "Si" when 0 then "No" end accidente'),
                'calidad_seguridad_industrial_seguridad_industrial.param_tipo_accidente_texto','calidad_seguridad_industrial_seguridad_industrial.fecha',
                'calidad_seguridad_industrial_seguridad_industrial.plan_mejora_leccion_aprendida','calidad_seguridad_industrial_seguridad_industrial.adoptado',
                'calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial')
                ->where('calidad_seguridad_industriales.fecha_informe','>=',$fechaInicio)
                ->where('calidad_seguridad_industriales.fecha_informe','<=',$fecha)
            ->get();

            /*
            SELECT case calidad_seguridad_industrial_seguridad_industrial.accidente_laboral_incidente when 1 then 'Si' when 0 then 'No' end accidente,calidad_seguridad_industrial_seguridad_industrial.param_tipo_accidente_texto,calidad_seguridad_industrial_seguridad_industrial.fecha,calidad_seguridad_industrial_seguridad_industrial.plan_mejora_leccion_aprendida,calidad_seguridad_industrial_seguridad_industrial.adoptado,calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial
            FROM calidad_seguridad_industriales
            Inner join calidad_seguridad_industrial_seguridad_industrial on calidad_seguridad_industriales.id = calidad_seguridad_industrial_seguridad_industrial.id_calidad_seguridad_industrial
            Where calidad_seguridad_industriales.id_proyecto=29*/

            $calidad_seguridad_industriales_actividades  = calidad_seguridad_industriales ::where('calidad_seguridad_industriales.id_proyecto','=',$id)
            ->join('calidad_seguridad_industrial_actividades_realizadas','calidad_seguridad_industriales.id','=','calidad_seguridad_industrial_actividades_realizadas.id_calidad_seguridad_industrial')
            ->select('calidad_seguridad_industrial_actividades_realizadas.de_medida_preventiva','calidad_seguridad_industrial_actividades_realizadas.actividades_higiene_seguridad_industrial',
            'calidad_seguridad_industrial_actividades_realizadas.id_calidad_seguridad_industrial')
            ->where('calidad_seguridad_industriales.fecha_informe','>=',$fechaInicio)
            ->where('calidad_seguridad_industriales.fecha_informe','<=',$fecha)
            ->get();

            /*
            SELECT calidad_seguridad_industrial_actividades_realizadas.de_medida_preventiva,calidad_seguridad_industrial_actividades_realizadas.actividades_higiene_seguridad_industrial,calidad_seguridad_industrial_actividades_realizadas.id_calidad_seguridad_industrial
            FROM calidad_seguridad_industriales
            Inner join calidad_seguridad_industrial_actividades_realizadas on calidad_seguridad_industriales.id = calidad_seguridad_industrial_actividades_realizadas.id_calidad_seguridad_industrial
            Where calidad_seguridad_industriales.id_proyecto=29*/

            $now = Carbon::now();
            $fecha_reporte = $now->format('Y-m-d');
            $hora_reporte = $now->format('H:i');






        return view('informe_seguimiento_proyectos.consulta_seguimiento_crear',
               compact(
                    'Proyectos',
                    'personas',
                    'licencias',
                    'contratos',
                    'recursos',
                    'tecnicos',
                    'bitacoras',
                    'bitacoras_anterior',
                    'AreaMetro',
                    'caracteristicas',
                    'fases',
                    'gestiones_sociales',
                    'gestiones_sociales_detalles',
                    'gestiones_sociales_bitacora',
                    'gestiones_ambientales',
                    'gestiones_ambientales_fuentes',
                    'gestiones_ambientales_permisos',
                    'gestiones_ambientales_bitacora',
                    'calidad_seguridad_industriales',
                    'calidad_seguridad_industriales_inspecciones',
                    'calidad_seguridad_industriales_obras',
                    'calidad_seguridad_industriales_Seguridad',
                    'calidad_seguridad_industriales_actividades',
                    'fecha_reporte',
                    'hora_reporte',
                    'fechas_array',
                    'datos_procesos_array',
                    'datos_semaforo_array',
                    'id_semana_parametrica',
                    'sum_prog',
                    'sum_eject'));



    }

    public function busqueda_proyecto(Request $request){

       //dd($request);
        $active = true;
        $search = [];
        $olddata =$request->all();


          $proyecto = proyectos::all();

          $id_proyecto = $request->id_proyecto;
          $nombre_proyecto = $request->proyecto;


          $search = proyectos::join('fases','fases.id_proyecto','=','proyectos.id')
          ->join('fases_Informe_semanal','fases_Informe_semanal.id_fase','=','fases.id')
          ->join('semanas_parametrica','semanas_parametrica.id','=','fases_Informe_semanal.id_semana_parametrica')
          ->select('proyectos.id','proyectos.nombre_proyecto','semanas_parametrica.fecha_fin','fases_Informe_semanal.id_semana_parametrica')
          ->orderBy('fases_Informe_semanal.id_semana_parametrica')
          ->where('proyectos.id',$id_proyecto)->distinct()
          ->get();
        //dd( $search);

          return view('informe_seguimiento_proyectos.informe_seguimiento_index',compact('search','proyecto','id_proyecto','nombre_proyecto'));

    }
}
