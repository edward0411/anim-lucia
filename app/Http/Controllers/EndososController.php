<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Endoso as endoso;
use App\Models\Terceros as terceros;
use App\Models\Obl_operaciones as obl_operaciones;
use App\Models\Rps_cuentas as rp_cuenta;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\Parametricas as parametricas;
use App\Models\Terceros_cuentas_bancarias as terceros_cuentas_bancarias;
use Auth;
use Log;

class EndososController extends Controller
{
    //

    public function index(Request $request){

        $id_relacion = obl_operaciones::where('id',(int)$request->id)->first();

        $relacion = rp_cuenta::where('id',$id_relacion->id_rp_cuenta)->first();

        $id_rp = $relacion->id_rp;
        $id_cuenta = $id_relacion->id_rp_cuenta;

        $rp = cdr_rp::find($id_rp);

        $tercero_original = $rp->terceros()->select('id','nombre','identificacion')->get();

        $terceros = terceros::all();

        $forma_pago = parametricas::where('categoria','=','Financiero.cdr.rp.pago.endoso.forma_pago')->select('valor','texto')->get();
        $tipo_giro = parametricas::where('categoria','=','Financiero.cdr.rp.pago.endoso.tipo_giro')->select('valor','texto')->get();

        return view('cdr.rps.cuentas.obligaciones_pagos.endosos.index',compact('id_relacion','terceros','rp','forma_pago','tipo_giro','id_cuenta'));
    }

    public function endosos_store(Request $request){

            $rules['tipo_endoso'] = 'required';   
            $messages['tipo_endoso.required'] ='Favor seleccione un tipo de tercero.'; 

            if($request->tipo_endoso == 0){
                $rules['tipo_endoso2'] = 'required';   
                $messages['tipo_endoso2.required'] ='Favor seleccione un tipo de tercero.'; 
            }
        if ($request->valor_endoso > $request->pendiente_pago) {
            $rules['tipo_endoso3'] = 'required';
            $messages['tipo_endoso3.required'] ='El valor de la operación no puede superar el valor pendiente por pagar.';
        }

        $this->validate($request, $rules, $messages);

        $registro = endoso::find($request->id_endoso);  
        
        if($registro == null )
        {
            if(isset($request->id_endoso_crear) &&  $request->id_endoso_crear==1)
            {   
                $registro = new endoso();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $registro;            
                return response()->json($respuesta);
            }
        }

        $registro->id_obl  = $request->id_obl;
        $registro->valor_endoso = $request->valor_endoso;
        $registro->id_param_tipo_giro  = $request->tipo_giro;
        $registro->id_param_tipo_giro_text = Parametricas::getTextFromValue('Financiero.cdr.rp.pago.endoso.tipo_giro', $request->tipo_giro);
        $registro->id_param_forma_pago = $request->forma_pago;
        $registro->id_param_forma_pago_text = Parametricas::getTextFromValue('Financiero.cdr.rp.pago.endoso.forma_pago', $request->forma_pago);
        $registro->instrucciones_adicionales = $request->instrucciones_adicionales;
        $registro->factura = $request->factura;
        $registro->comentarios = $request->comentarios;
        $registro->ciudad_tributacion = $request->ciudad_tributacion;
        if ($request->tipo_endoso == 1) {
            $registro->id_tercero = $request->id_tercero_original;        
        }elseif($request->tipo_endoso == 2){
            $registro->id_tercero = $request->id_tercero;  
        }
        $registro->tipo_endoso = $request->tipo_endoso;
        $registro->id_cuenta_tercero = $request->cuenta_bancaria;
        if($request->id_endoso==0)
        {
            $registro->created_by = Auth::user()->id;
        }else {
            $registro->updated_by = Auth::user()->id;
        }
        
        $registro->save();
      
        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la bitaora";
        $respuesta['objeto']= $registro;
    
        return response()->json($respuesta);


    }

    public function get_info_endosos(Request $request){

        $endosos = endoso::where('id_obl',$request->id_obl)->get(); 

        foreach($endosos as $endoso)
        {
            $tercero = $endoso->Tercero()->select('nombre','identificacion')->first();
            $endoso->nombre_tercero = $tercero->nombre;
            $endoso->identificacion_tercero = $tercero->identificacion;
            $id_cuenta = $endoso->id_cuenta_tercero;
            if($id_cuenta != null)
            {
                $cuenta = terceros_cuentas_bancarias::find($id_cuenta);
                $endoso->cuenta = $cuenta->numero_cuenta.' - '.$cuenta->param_tipo_cuenta_texto.' - '.$cuenta->param_banco_texto;
            }        
        }
       
        return response()->json($endosos); 
    }

    public function delete_endoso(Request $request){

        $endoso = endoso::find($request->id_endoso);
        $endoso->deleted_by = Auth::user()->id;
        $endoso->save();

        $informacionlog = 'Se ha eliminado la informacion del movimiento';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $endoso,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );

        $endoso->delete();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$endoso
        ;

        return response()->json($respuesta);
    }

    public function get_cuentas_terceros(Request $request)
    {
       $cuentas = terceros_cuentas_bancarias::where('id_tercero',$request->id_tercero)
                                            ->where('estado',1)->get();

       return response()->json($cuentas); 
    }
}
