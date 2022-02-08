<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contratos as contratos;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs as cdr;
use App\Models\Cdrs_cuentas as cuenta_cdr;
use App\Models\Contratos_afectacion as contrato_afectacion;
use App\Models\Contratos_afectacion_detalle as contrato_afectacion_detalle;
use Auth;
use Log;
use Carbon\Carbon;

class ContratosAfectacionFinancieraController extends Controller
{
  public function get_info_cdr(Request $request){

        $id_cdr = $request->id_cdr_contrato;
        $respuesta = [];
        $cdr = cdr::find($id_cdr);
        $respuesta['valor'] = $cdr->saldo_cdr();
        $cuentas = cuenta_cdr::where('id_cdr',$id_cdr)->select('id','id_cuenta')->get();

        foreach ($cuentas as $value) {
          $dato = cuenta_cdr::find($value->id);      
          $id_cuenta = $value->id_cuenta;
          $cuenta = patrimonios_cuentas::where('id',$id_cuenta)->select('id_patrimonio','numero_de_cuenta','descripcion_cuenta')->first();
          $id_patrimonio = $cuenta->id_patrimonio;
          $patrimonio = patrimonio::find($id_patrimonio);
          $pad = contratos::find($patrimonio->id_contrato_pad);
          $value->numero_de_cuenta = $cuenta->numero_de_cuenta;
          $value->descripcion_cuenta = $cuenta->descripcion_cuenta;
          $value->pad = $pad->numero_contrato;
          $value->valor = $dato->saldo_cuenta_cdr();
        }

        $respuesta['cuentas'] = $cuentas;

        return response()->json($respuesta);
  }

  public function get_info_afectacion(Request $request){

    $consulta = contrato_afectacion::where('id_contrato',$request->id_contrato)->first();  
    $cdr = cdr::find($consulta->id_cdr);
    $consulta['valor'] = $cdr->saldo_cdr();

    $id_afectacion = $consulta->id;

    $relacion = contrato_afectacion_detalle::where('id_afectacion_financiera',$id_afectacion)->select('id_cdr_cuenta','valor_contratado')->get();


    foreach ($relacion as  $value) {
     
      $dato = cuenta_cdr::find($value->id_cdr_cuenta);  
      $id_cuenta = $dato->id_cuenta; 
      $cuenta = patrimonios_cuentas::where('id',$id_cuenta)->select('id_patrimonio','numero_de_cuenta','descripcion_cuenta')->first();
      $id_patrimonio = $cuenta->id_patrimonio;
      $patrimonio = patrimonio::find($id_patrimonio);
      $pad = contratos::find($patrimonio->id_contrato_pad);
      $value->numero_de_cuenta = $cuenta->numero_de_cuenta;
      $value->descripcion_cuenta = $cuenta->descripcion_cuenta;
      $value->pad = $pad->numero_contrato;
      $value->valor = $dato->saldo_cuenta_cdr();
    }

    $consulta['cuentas'] = $relacion;

    return response()->json($consulta);
  }

  public function store(Request $request){


   $consulta = contrato_afectacion::where('id_contrato',$request->id_contrato)->first(); 
   $rules = [
    'id_contrato' => 'required',            
];

$messages = [
    'id_contrato.required' => 'Debe seleccionar un tipo de contrato', 
        
];

   $id_contrato = $request->id_contrato;
   $contrato = contratos::find($id_contrato);
   $fechas = $contrato->contratos_fechas()->select('fecha_firma')->first();
   $fecha_firma = $fechas->fecha_firma;
   $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');

   if (isset($request->fecha_radicacion)) {
    if ($request->fecha_radicacion < $fecha_firma) {
      $rules['fecha_radicacion2'] = 'required';
      $messages['fecha_radicacion2.required'] ='La fecha radicación del acta no puede ser inferior a la fecha de la firma del acta.';          
    }
  
    if ($request->fecha_radicacion > $fecha_hoy) {
      $rules['fecha_radicacion3'] = 'required';
      $messages['fecha_radicacion3.required'] ='La fecha radicación del acta no puede ser superior a la fecha actual.';          
  }
   }
   if (isset($request->fecha_remision)) {
    if ($request->fecha_remision < $request->fecha_radicacion) {
      $rules['fecha_remision2'] = 'required';
      $messages['fecha_remision2.required'] ='La fecha remision del acta no puede ser inferior a la fecha de radicación del acta.';          
    }
  
    if ($request->fecha_remision > $fecha_hoy) {
      $rules['fecha_remision3'] = 'required';
      $messages['fecha_remision3.required'] ='La fecha radicación del acta no puede ser superior a la fecha actual.';          
  }
   }

   
  $this->validate($request, $rules, $messages);
             
        $i = 0;
      if($consulta == null){
        $i = 1;
        $relacion = new contrato_afectacion();
      }else{
        $relacion = contrato_afectacion::find($consulta->id);
      }
      $relacion->id_contrato = $request->id_contrato;
      $relacion->id_cdr = $request->id_cdr;
      $relacion->fecha_radicacion_acta = $request->fecha_radicacion;
      $relacion->numero_radicacion_gesdoc = $request->radicacion_gesdoc;
      $relacion->fecha_remision_acta = $request->fecha_remision;
      $relacion->numero_remision_gesdoc = $request->remision_gesdoc;
      if($i == 1){
        $relacion->created_by  =  Auth::user()->id;
      }else{
        $relacion->updated_by  =  Auth::user()->id;
      }
      $relacion->save();

      $id_afectacion = $relacion->id;

      $consulta_afectacion = contrato_afectacion_detalle::where('id_afectacion_financiera',$id_afectacion)->get();

      if($consulta_afectacion != null){
        foreach ($consulta_afectacion as $value) {          
          $registro = contrato_afectacion_detalle::find($value->id);
          $registro->delete();
        }       
      }
        if(isset($request->id_cdr_cuenta)){
          foreach ($request->id_cdr_cuenta as $key => $value) {
            $registro = new contrato_afectacion_detalle();
            $registro->id_afectacion_financiera = $id_afectacion;
            $registro->id_cdr_cuenta = $value;
            $registro->valor_contratado = $request->valor_contratado[$key];
            $registro->created_by  =  Auth::user()->id;
            $registro->updated_by  =  Auth::user()->id;
            $registro->save();
          }
        }
        
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información del otrosí";
        $respuesta['objeto'] = $relacion;

        return response()->json($respuesta);
  }
}
