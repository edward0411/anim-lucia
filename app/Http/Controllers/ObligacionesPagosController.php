<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obl_operaciones as obl_operaciones;
use App\Models\Rps_cuentas as rp_cuenta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Parametricas;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use Carbon\Carbon;
use App\Models\Endoso as endoso;
use App\Models\Terceros as terceros;
use App\Models\Terceros_cuentas_bancarias as terceros_cuentas_bancarias;


class ObligacionesPagosController extends Controller
{

    public function index(Request $request)
    {
        $relacion = rp_cuenta::find($request->id);
        return view('cdr.rps.cuentas.obligaciones_pagos.index',compact('relacion'));
    }

    public function rp_cuenta_pagos_store(Request $request)
    {

        $rules = [
            'valor_operacion' => 'required',
        ];

        $messages = [
            'valor_operacion.required' => 'El valor de la operación es un campo obligatorio',
        ];

        $id_rp_cuenta = $request->rp_cuenta;
        $rp_cuenta = rp_cuenta::find((int)$id_rp_cuenta);
        $id_cuenta = $rp_cuenta->id_cuenta; 
        $patrimonio_cuenta = patrimonios_cuentas::find($id_cuenta);
        $patrimonio = patrimonio::find($patrimonio_cuenta->id_patrimonio);
        $id_pad = $patrimonio->id_contrato_pad;

        $apfs = patrimonio::Leftjoin('patrimonio_cuentas','patrimonio_cuentas.id_patrimonio','=','patrimonios.id')
        ->leftJoin('rps_cuentas','rps_cuentas.id_cuenta','=','patrimonio_cuentas.id')
        ->leftJoin('obl_operaciones','obl_operaciones.id_rp_cuenta','=','rps_cuentas.id')
        ->where('patrimonios.id_contrato_pad',$id_pad)
        ->whereNull('patrimonio_cuentas.deleted_at')
        ->whereNull('rps_cuentas.deleted_at')
        ->select('obl_operaciones.apf')
        ->get();
        $array_apfs = $apfs->toArray();

        if ($request->valor_operacion > $request->valor_pendiente_pago) {
            $rules['valor_operacion_2'] = 'required';
            $messages['valor_operacion_2.required'] ='El valor de la operación no puede superar el valor pendiente por pagar.';
        }

        $this->validate($request, $rules, $messages);
        

        $fecha_operacion = Carbon::now()->parse()->format('Y-m-d');

        $obigaciones_operaciones = obl_operaciones::find($request->rp_cuenta_pago);

        if($obigaciones_operaciones == null )
        {
            if(isset($request->rp_cuenta_pago_crear) &&  $request->rp_cuenta_pago_crear==1)
            {
                foreach($array_apfs as $apf)
                {
                    if($apf['apf'] != Null)
                    {
                        if($apf['apf'] == $request->numero_apf)
                        {
                            $rules['valor_operacion_3'] = 'required';
                            $messages['valor_operacion_3.required'] ='El valor del APF ya se encuentra registrado en el sistema.';
                        }
                    }
                }
                $this->validate($request, $rules, $messages);
        

                $obigaciones_operaciones = new obl_operaciones();
            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $obigaciones_operaciones;
                return response()->json($respuesta);
            }
        }else{
            if($obigaciones_operaciones->apf != null)
            {
                if($obigaciones_operaciones->apf != $request->numero_apf)
                {
                    foreach($array_apfs as $apf)
                    {
                        if($apf['apf'] != Null)
                        {
                            if($apf['apf'] == $request->numero_apf)
                            {
                                $rules['valor_operacion_3'] = 'required';
                                $messages['valor_operacion_3.required'] ='El valor del APF ya se encuentra registrado en el sistema.';
                            }
                        }
                    }
                    $this->validate($request, $rules, $messages);
                }
            }
        }

         $obigaciones_operaciones->id_rp_cuenta	 = $request->rp_cuenta;
         $obigaciones_operaciones->fecha_obl_operacion = $fecha_operacion;
         $obigaciones_operaciones->valor_operacion_obl = $request->valor_operacion;
         $obigaciones_operaciones->apf = $request->numero_apf;
         $obigaciones_operaciones->observaciones = $request->observaciones;
         $obigaciones_operaciones->param_estado_obl_operacion_valor = 1;
         $obigaciones_operaciones->param_estado_obl_operacion_text = Parametricas::getTextFromValue('financiero.cdr.rp.obl.operaciones.estado',1);
         if($request->rp_cuenta_pago==0)
         {
             $obigaciones_operaciones->created_by = Auth::user()->id;
         }else {
             $obigaciones_operaciones->updated_by = Auth::user()->id;
         }
         $obigaciones_operaciones->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la cuenta";
         $respuesta['objeto']= $obigaciones_operaciones;

          return response()->json($respuesta);
    }

    public function get_info_rp_cuenta_pagos(Request $request)
    {
        $registro = obl_operaciones::where('id_rp_cuenta',$request->id_rp_cuenta)
        ->select('id','fecha_obl_operacion','valor_operacion_obl','observaciones','param_estado_obl_operacion_valor','param_estado_obl_operacion_text','apf')
        ->get();

        $pendiente = 0;

        foreach ($registro as $value) {           
            $relacion = obl_operaciones::find($value->id);
            $pendiente = $value->valor_operacion_obl - $relacion->suma_obl();
            $value->pendiente = $pendiente;
        }

        return response()->json($registro);
    }

    public function rp_cuenta_pagos_delete(Request $request)
    {
        $rp_cuenta_pago = obl_operaciones::find($request->id_rp_cuenta_pago);

        if(count($rp_cuenta_pago->Endoso) == 0){

            $rp_cuenta_pago->deleted_by = Auth::user()->id;
            $rp_cuenta_pago->save();

            $informacionlog = 'Se ha eliminado la informacion del movimiento';
            $objetolog = [
                    'user_id' => Auth::user()->id,
                    'user_email' => Auth::user()->mail,
                    'Objeto Eliminado' => $rp_cuenta_pago,
                    ];

            Log::channel('database')->info(
                $informacionlog ,
                $objetolog
            );

            $rp_cuenta_pago->delete();
            $respuesta['status']="success";
            $respuesta['message']="Se ha eliminado registro";
            $respuesta['objeto']=$rp_cuenta_pago;
            
        }else{
            $respuesta['status']="error";
            $respuesta['message'] = "La obligación N° ".$rp_cuenta_pago->id." no puede ser eliminada por que ya tiene beneficiarios creados.";
            $respuesta['objeto']= $rp_cuenta_pago;
        }
        return response()->json($respuesta);
    }

    public function get_info_rp_cuenta_pagos_consultar_valores(Request $request)
    {
        $rp_c = rp_cuenta::find($request->rp_cuenta);

        $valor_cuenta = $rp_c->saldo_rp_cuenta();
        $valor_pagado = $rp_c->valor_rp_pagos();
        $valor_pendiente = $rp_c->rp_cuenta_pendiente_pago();

        $valores = [];

        $valores[0] = $valor_cuenta;
        $valores[1] = $valor_pagado;
        $valores[2] = $valor_pendiente;

        return response()->json($valores);
    }

    public function rp_cuenta_pagos_change_state(Request $request)
    {
        $id_obl = $request->id_obl;
        $consulta = obl_operaciones::where('id',$id_obl)->select('param_estado_obl_operacion_valor')->first();
        $valor = $consulta->param_estado_obl_operacion_valor + 1;

        $relacion = obl_operaciones::find($id_obl);
        $relacion->param_estado_obl_operacion_valor = $valor;
        $relacion->param_estado_obl_operacion_text = Parametricas::getTextFromValue('financiero.cdr.rp.obl.operaciones.estado',$valor);
        $relacion->updated_by = Auth::user()->id;
        $relacion->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha actualizado el estado exitosamente";
        $respuesta['objeto']= $relacion;

        return response()->json($respuesta);
    }

    public function reporte_obl(Request $request)
    {
        $id_obligacion = $request->id;
        $fecha = Carbon::now()->format('Y-m-d');

        $obligacion = obl_operaciones::where('obl_operaciones.id',$id_obligacion)
        ->join('rps_cuentas','rps_cuentas.id','=','obl_operaciones.id_rp_cuenta')
        ->join('patrimonio_cuentas','patrimonio_cuentas.id','=','rps_cuentas.id_cuenta')
        ->join('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->join('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->join('rps','rps.id','=','rps_cuentas.id_rp')
        ->join('terceros','terceros.id','=','rps.id_tercero')
        ->select(
            'obl_operaciones.id as id_obligacion',
            'obl_operaciones.apf as numero_orden_apf',
            'obl_operaciones.valor_operacion_obl as valor_orden',
            'obl_operaciones.observaciones',
            'patrimonio_cuentas.numero_de_cuenta as numero_cuenta',
            'patrimonio_cuentas.descripcion_cuenta as nombre_cuenta',
            'patrimonios.codigo_fid as codigo_fideicomiso',
            'terceros.identificacion as identificacion_tercero',
            'terceros.nombre as nombre_tercero',
            'contratos.numero_contrato'
            )
        ->first();

        //dd($obligacion);
       
        $tipo_orden = '';
        $instruccion = 'Causar y Girar';

        $obligacion->fecha = $fecha;
        $obligacion->tipo_orden = $tipo_orden;
        $obligacion->instruccion = $instruccion;

        
        $pagos = endoso::where('id_obl',$id_obligacion)
        ->join('terceros','terceros.id','=','endoso.id_tercero')
        ->select('endoso.id as id_endoso',
                 'endoso.instrucciones_adicionales as prefijo',
                 'endoso.factura',
                 'endoso.created_at as fecha_factura',
                 'endoso.valor_endoso',
                 'endoso.id_param_forma_pago_text as forma_pago',
                 'endoso.id_cuenta_tercero as id_cuenta_tercero',
                 'endoso.ciudad_tributacion',
                 'endoso.comentarios',
                 'terceros.param_tipodocumento_texto as tipo_identificacion_beneficiario',
                 'terceros.identificacion as identificacion_beneficiario',
                 'terceros.nombre as nombre_beneficiario'
                 )
        ->get();

        foreach ($pagos as  $value) {    

            $nombre_banco = 'Red Multibanca Colpatria';
            $value->nombre_banco = $nombre_banco; 

            $value->numero_cuenta = $obligacion->numero_cuenta; 
            
            $tipo_movimiento = 'Pago a Proveedores';
            $value->tipo_movimiento = $tipo_movimiento;

            $concepto_contable = '';
            $value->concepto_contable = $concepto_contable;

            $value->identificacion_tercero = $obligacion->identificacion_tercero;
            $value->nombre_tercero = $obligacion->nombre_tercero;

           
            $value->prefijo_factura = $value->prefijo;

            $multiple_beneficiario = 'No';
            $value->multiple_beneficiario = $multiple_beneficiario;

            if ($value->id_cuenta_tercero == null) {

                $value->banco_destino = '';
                $value->tipo_cuenta = '';
                $value->cuenta_destino_beneficiario = '';

            }else {

                $id_cuenta_tercero = $value->id_cuenta_tercero;

                $datos = terceros_cuentas_bancarias::where('id',$id_cuenta_tercero)
                ->select('param_banco_texto','param_tipo_cuenta_texto','numero_cuenta')
                ->first();

                $value->banco_destino = $datos->param_banco_texto;
                $value->tipo_cuenta = $datos->param_tipo_cuenta_texto;
                $value->cuenta_destino_beneficiario = $datos->numero_cuenta;
               
            }

            $value->observaciones = $value->comentarios;
            $value->centro_costo = 0;
            
        }  
        
        $obligacion->pagos = $pagos;


        if($request->tipo == 1){
            return view('cdr.rps.cuentas.obligaciones_pagos.reporte',compact('obligacion'));
        }else{
            return view('cdr.rps.cuentas.obligaciones_pagos.tabla',compact('obligacion'));
        }


       
    }

    public function archivo_plano_obl(Request $request)
    {
        $id_obligacion = $request->id;
    }

}
