<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CsvImport;
use App\Models\Obl_operaciones as obl_operaciones;
use App\Models\Reporte_registro_carga_masiva as reporte_registro;
use App\Models\Informe_reporte_registro_carga_masiva as informe_reporte_registro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametricas;


class CargaMasivaController extends Controller
{
    public function index(){

        return view('carga_masiva.index');
    }

    public function store(Request $request){

        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $rules = [
            'num_gestdocs' => 'required',
            'fecha_informe' => 'required',
        ];

        $messages = [
            'num_gestdocs.required' => 'El número de Gesdoc es un campo obligatorio',
            'fecha_informe.required' => 'La fecha del informa es un campo obligatorio',
        ];

       $data = Excel::toArray(new CsvImport(), $request->file('file'));
       $datos = $data[0];
       $count = count($datos);

     for ($i=1; $i < $count; $i++) { 

        $id_obligacion = $datos[$i][0]; 
        $valor_pagar = $datos[$i][22];

        $obligacion = obl_operaciones::find($id_obligacion);

            if($obligacion == null){

                $num = $i + 1;
                $rules['file2'] = 'required';   
                $messages['file2.required'] ='El ID_OBLIGACION que se encuentra en la pocisión A'.$num.' no se encuentra registrado en el sistema.'; 

                $this->validate($request, $rules, $messages);

            }
            $valor_op = floatval($obligacion->valor_operacion_obl);

            if($valor_op != floatval($valor_pagar)){

                $num = $i + 1;
                $rules['file3'] = 'required';   
                $messages['file3.required'] ='El valor a pagar de la ID_OBLIGACION A'.$num.' que se encuentra en la pocisión W'.$num.' no coincide con el registrado en el sistema.'; 

                $this->validate($request, $rules, $messages);
            }
       }  


       $reporte = new reporte_registro();
       $reporte->numero_gest_doct = $request->num_gestdocs;
       $reporte->fecha_soperte  = $request->fecha_informe;
       $reporte->created_by = Auth::user()->id;
       $reporte->save();

       $id_reporte = $reporte->id;

       $fecha = Carbon::parse('1900-01-01');

       for ($i=1; $i < $count; $i++) { 

        $dias = $datos[$i][3] - 2;

        $fecha_pago = $fecha->add($dias, 'days');

        $fecha_pago = Carbon::parse($fecha_pago)->format('Y-m-d');

        $id_obligacion = $datos[$i][0];
        $cod_negocio = $datos[$i][1];
        $negocio = $datos[$i][2];
        $cuenta_debitada = $datos[$i][4];
        $cuenta_destino = $datos[$i][5];
        $mes_causacion = $datos[$i][6];
        $identificacion_tercero = $datos[$i][7];
        $tercero = $datos[$i][8];
        $identificacion_beneficiario = $datos[$i][9];
        $beneficiario = $datos[$i][10];
        $soporte = $datos[$i][11];
        $cargo = $datos[$i][12];
        $concepto = $datos[$i][13];
        $vr_orden_operacion = $datos[$i][14];
        $retefuente = $datos[$i][15];
        $reteiva = $datos[$i][16];
        $reteica = $datos[$i][17];
        $estampilla = $datos[$i][18];
        $contribucion = $datos[$i][19];
        $cxp = $datos[$i][20];
        $descuentos = $datos[$i][21];
        $valor_pagar = $datos[$i][22];

        if (is_numeric($retefuente)) {
           $valor_retefuente = $retefuente;
        }else{
            $valor_retefuente = 0;
        }

        if (is_numeric($reteiva)) {
            $valor_reteiva = $reteiva;
        }else{
            $valor_reteiva = 0;
        }

        if (is_numeric($reteica)) {
           $valor_reteica = $reteica;
        }else{
            $valor_reteica = 0;
        }

        if (is_numeric($estampilla)) {
            $valor_estampilla = $estampilla;
        }else{
            $valor_estampilla = 0;
        }

        if (is_numeric($contribucion)) {
            $valor_contribucion = $contribucion;
        }else{
            $valor_contribucion = 0;
        }

        if (is_numeric($cxp)) {
            $valor_cxp = $cxp;
        }else{
            $valor_cxp = 0;
        }

        if (is_numeric($descuentos)) {
            $valor_descuentos = $descuentos;
        }else{
            $valor_descuentos = 0;
        }

        if ($valor_pagar > 0) {

            $obligacion = obl_operaciones::find($id_obligacion);
            $obligacion->param_estado_obl_operacion_valor = 6;
            $obligacion->param_estado_obl_operacion_text = Parametricas::getTextFromValue('financiero.cdr.rp.obl.operaciones.estado',6);
            $obligacion->updated_by = Auth::user()->id;
            $obligacion->save();
            
            $registro = new informe_reporte_registro();
            $registro->id_reporte_registro = $id_reporte;
            $registro->id_obligacion = $id_obligacion;
            $registro->codigo_negocio = $cod_negocio;
            $registro->negocio = $negocio;
            $registro->fecha_pago = $fecha_pago;
            $registro->cuenta_debitada = $cuenta_debitada;
            $registro->cuenta_destino = $cuenta_destino;
            $registro->mes_causacion = $mes_causacion;
            $registro->identificacion_ter = $identificacion_tercero;
            $registro->tercero = $tercero;
            $registro->identificacion_ben = $identificacion_beneficiario;
            $registro->beneficiario = $beneficiario;
            $registro->soporte = $soporte;
            $registro->con_cargo  = $cargo;
            $registro->concepto = $concepto;
            $registro->vr_orden_operacion = $vr_orden_operacion;
            $registro->retefuente = $valor_retefuente;
            $registro->rete_iva = $valor_reteiva;
            $registro->rete_ica = $valor_reteica;
            $registro->estampilla = $valor_estampilla;
            $registro->contribucion = $valor_contribucion;
            $registro->cxp = $valor_cxp;
            $registro->descuento = $valor_descuentos;
            $registro->valor_pagar = $valor_pagar;
            $registro->created_by = Auth::user()->id;
            $registro->save();

        }

       }

       return redirect()->route('carga_masiva.index')->with('success','Información ha sido cargada y guardada de forma exitosa');

    }

}
