<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Patrimonio_bitacoras as patrimonio_bitacoras;
use App\Models\Patrimonio_bitacoras_seguimiento as bitacoras_seguimiento;
use App\Models\Patrimonio_cuenta_movimientos as cuentas_movimientos;
use App\Models\Contratos_pads_convenios as contratos_pads_convenios;
use App\Models\Contratos as contratos;
use App\Models\Parametricas;
use App\Models\Terceros as terceros;
use App\Models\Contratos_terceros as contratos_tercero;
use App\Models\Plantilla_plan as plantilla_plan;
use App\Models\Plantilla_plan_nivel as plantilla_plan_nivel;
use App\Models\Plantilla_plan_subnivel as plantilla_plan_subnivel;
use App\Models\Plantilla_plan_patrimonio as plantilla_plan_pat;
use App\Models\Plantilla_plan_nivel_patrimonio as plantilla_plan_nivel_pat;
use App\Models\Plantilla_plan_subnivel_patrimonio as plantilla_plan_subnivel_pat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PatrimoniosController extends Controller
{

    public function index()
    {

        $patrimonios = patrimonio::leftJoin('contratos', 'contratos.id', '=', 'patrimonios.id_contrato_pad')
            ->select('patrimonios.*', 'contratos.numero_contrato')
            ->get();

        return view('patrimonios.index', compact('patrimonios'));
    }

    public function crear()
    {

        $datos = [];
        $consulta = contratos_pads_convenios::leftJoin('contratos as conv', 'conv.id', '=', 'contratos_pads_convenios.id_contrato_convenio')
            ->select('contratos_pads_convenios.id_contrato_pad', 'contratos_pads_convenios.id_contrato_convenio', 'conv.numero_contrato', 'conv.valor_contrato')
            ->get();


        foreach ($consulta as $value) {

            $id = $value->id_contrato_convenio;
            $contrato = contratos::find($id);
            $id_tercero = $contrato->contratos_terceros()->select('id_terecero')->first();
            $tercero = terceros::where('id', $id_tercero->id_terecero ?? '0' )->select('nombre', 'identificacion')->first();
            $value->nombre_tercero = $tercero->nombre ?? 'No disponible';
            $value->ide_tercero = $tercero->identificacion ?? 'No disponible' ;
        }

        $convenios = $consulta->toArray();

        //dd($convenios);

        $consulta = DB::table('contratos')
            ->where('param_valor_tipo_contrato', 2)
            ->whereNotIn('id', DB::table('patrimonios')->select('id_contrato_pad'))
            ->whereNull('contratos.deleted_at')
            ->select('id', 'numero_contrato')
            ->get();

        $pads = $consulta->toArray();

        $consulta = DB::table('patrimonios')
            ->select('id')
            ->get()
            ->last();

        if ($consulta == null) {
            $string = 1;
        } else {
            $string = $consulta->id + 1;
        }

        return view('patrimonios.crear', compact('datos', 'convenios', 'string', 'pads'));
    }

    public function editar($id)
    {

        $patrimonio =  Crypt::decryptString($id);

        $patrimonios = patrimonio::leftJoin('contratos', 'contratos.id', '=', 'patrimonios.id_contrato_pad')
            ->select('patrimonios.*', 'contratos.numero_contrato')
            ->where('patrimonios.id', $patrimonio)
            ->get();



        $datos = [];
        $consulta = contratos_pads_convenios::leftJoin('contratos as conv', 'conv.id', '=', 'contratos_pads_convenios.id_contrato_convenio')
            ->select('contratos_pads_convenios.id_contrato_pad', 'contratos_pads_convenios.id_contrato_convenio', 'conv.numero_contrato', 'conv.valor_contrato')
            ->get();
        //dd($consulta);

        foreach ($consulta as $value) {

            $id = $value->id_contrato_convenio;
            $contrato = contratos::find($id);
            $id_tercero = $contrato->contratos_terceros()->select('id_terecero')->first();

            if($id_tercero == null){
                $value->nombre_tercero = '';
                $value->ide_tercero = '';
            }else{             
                $tercero = terceros::where('id', $id_tercero->id_terecero)->select('nombre', 'identificacion')->first();
                $value->nombre_tercero = $tercero->nombre;
                $value->ide_tercero = $tercero->identificacion;
            }
            
        }

        $convenios = $consulta->toArray();

        $consulta = DB::table('contratos')
            ->where('param_valor_tipo_contrato', 2)
            ->whereNotIn('id', DB::table('patrimonios')->select('id_contrato_pad'))
            ->select('id', 'numero_contrato')
            ->get();

        $pads = $consulta->toArray();

        $consulta = DB::table('patrimonios')
            ->select('id')
            ->get()
            ->last();

        if ($consulta == null) {
            $string = 1;
        } else {
            $string = $consulta->id + 1;
        }


        return view('patrimonios.editar', compact('patrimonios', 'datos', 'pads', 'string', 'convenios'));
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'nombre_pad' => 'required',
        ]);

        $patrimonio = patrimonio::where('id', '=', $request->id)->firstOrFail();
        $patrimonio->id_contrato_pad = $request->nombre_pad;
        $patrimonio->codigo_pad = $request->codigo_pad;
        $patrimonio->codigo_fid = $request->codigo_fid;
        $patrimonio->Observaciones = $request->observaciones;
        $patrimonio->created_by = Auth::user()->id;
        $patrimonio->update();


        return redirect()->route('patrimonios.index', $patrimonio->id)->with('success', 'Se ha actualizado la información del patrimonio');
    }

    //////////Plan financiero /////////

    public function plan_financiero($id)
    {

        $patrimonio =  Crypt::decryptString($id);

        $consulta = plantilla_plan_pat::where('id_patrimonio', $patrimonio)
            ->first();

        if ($consulta == null) {

            $plantilla_plan = plantilla_plan::select('id', 'nombre_plantilla')
                ->get();

            $registro = patrimonio::leftJoin('contratos', 'contratos.id', '=', 'patrimonios.id_contrato_pad')
                ->where('patrimonios.id', $patrimonio)
                ->select('patrimonios.*', 'contratos.numero_contrato')
                ->first();

            return view('patrimonios.plan_financiero', compact('plantilla_plan', 'registro'));
        } else {

            return redirect()->route('patrimonios.plan_financiero.view',$patrimonio);
          }
          
    }

    public function get_patrimonio_plan_financiero(Request $request)
    {
        //$id_cdr=Crypt::decryptString($cdr_token);

        $plantilla_plan = plantilla_plan::with('plantilla_plan_nivel')->where('id_plantilla_plan', $request->id_plantilla_plan)
            ->get();

        dd($plantilla_plan);

        // $info_contra = informacion_contractuals::all();
        return response()->json($plantilla_plan);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nombre_pad' => 'required',
        ]);

        $registro = new patrimonio();
        $registro->id_contrato_pad = $request->nombre_pad;
        $registro->codigo_pad = $request->codigo_pad;
        $registro->codigo_fid = $request->codigo_fid;
        $registro->Observaciones = $request->observaciones;
        $registro->created_by = Auth::user()->id;
        $registro->save();

        $id_registro = $registro->id;

        return redirect()->route('patrimonios.crear_informacion', $id_registro);
    }


    public function crear_informacion($id)
    {
        $valor_convenios = 0;

        $registro = patrimonio::leftJoin('contratos', 'contratos.id', '=', 'patrimonios.id_contrato_pad')
            ->where('patrimonios.id', $id)
            ->select('patrimonios.*', 'contratos.numero_contrato')
            ->first();

        $contrato_pad = patrimonio::leftJoin('contratos_pads_convenios', 'contratos_pads_convenios.id_contrato_pad', '=', 'patrimonios.id_contrato_pad')
            ->leftJoin('contratos', 'contratos.id', '=', 'contratos_pads_convenios.id_contrato_convenio')
            ->where('patrimonios.id', $id)
            ->whereNull('contratos_pads_convenios.deleted_at')
            ->select('contratos_pads_convenios.id_contrato_convenio', 'contratos.valor_contrato', 'contratos.numero_contrato')
            ->get();

        $relacion = $contrato_pad->toArray();

        for ($i = 0; $i < count($relacion); $i++) {

            $valor_convenios = $valor_convenios +  $relacion[$i]['valor_contrato'];

            $id_convenio = $relacion[$i]['id_contrato_convenio'];
            $contrato_tercero = contratos_tercero::where('id_contrato', $id_convenio)->first();
            if($contrato_tercero != null  ){
                $tercero = $contrato_tercero->Tercero()->select('nombre', 'identificacion')->first();
                $relacion[$i]['nombre_tercero'] = $tercero['nombre'];
                $relacion[$i]['ide_tercero'] = $tercero['identificacion'];
            } else {
                $relacion[$i]['nombre_tercero'] = 'No disponible';
                $relacion[$i]['ide_tercero'] = 'No disponible';
            }

        }

        $consulta = Parametricas::where('categoria', 'financiero.patrimonios.cuentas.tipo_cuenta')
            ->select('valor', 'texto')
            ->orderby('orden')
            ->get();

        $tipos = $consulta->toArray();


        return view('patrimonios.crear_datos', compact('registro', 'relacion', 'tipos', 'valor_convenios'));
    }
    ////////////patrimonio_cuentas////////

    public function patrimonios_cuentas_store(Request $request)
    {

        $valor_convenios = $request->valor_convenios;
        $suma_valor = patrimonios_cuentas::where('id_patrimonio',$request->id_patrimonio_c)->select( DB::raw('sum(valor_asignado) as valor'))->get();     
        $suma_ocupado = $suma_valor[0]->valor;
        $valor_disponible_ocupar = ((int)$valor_convenios - (int)$suma_ocupado);

        $rules['id_patrimonio_c'] = 'required';   
        $messages['id_patrimonio_c.required'] ='Favor seleccione un patrimonio disponible.'; 

        /*if($valor_disponible_ocupar == 0){
            $rules['id_patrimonio_c_2'] = 'required';   
            $messages['id_patrimonio_c_2.required'] ='El valor de los convenios ya fue asigando a otras cuentas.'; 
        }elseif($valor_disponible_ocupar < (int)$request->valor_cuenta){
            $rules['id_patrimonio_c_3'] = 'required';   
            $messages['id_patrimonio_c_3.required'] ='El valor que se intenta asignar a la cuenta supera el valor disponible de los convenios.'; 
        }*/

        $this->validate($request, $rules, $messages);

        $patrimonio_cuenta = patrimonios_cuentas::find($request->id_patrimonio_cuenta);

        if ($patrimonio_cuenta == null) {
            if (isset($request->id_patrimonio_cuenta_crear) &&  $request->id_patrimonio_cuenta_crear == 1) {
                $patrimonio_cuenta = new patrimonios_cuentas();
            } else {
                $respuesta['status'] = "error";
                $respuesta['message'] = "No tiene permiso para crear registros nuevos";
                $respuesta['objeto'] = $patrimonio_cuenta;
                return response()->json($respuesta);
            }
        }

        $patrimonio_cuenta->id_patrimonio = $request->id_patrimonio_c;
        $patrimonio_cuenta->numero_de_cuenta = $request->num_cuenta;
        $patrimonio_cuenta->id_param_tipo_cuenta = $request->id_tipo_cuenta;
        $patrimonio_cuenta->id_param_tipo_cuenta_texto = Parametricas::getTextFromValue('financiero.patrimonios.cuentas.tipo_cuenta', $request->id_tipo_cuenta);
        $patrimonio_cuenta->descripcion_cuenta = $request->nombre_cuenta;
        $patrimonio_cuenta->valor_asignado = $request->valor_cuenta;
        $patrimonio_cuenta->Observaciones = $request->observacion;

        if ($request->patrimonio_cuenta == 0) {
            $patrimonio_cuenta->created_by = Auth::user()->id;
        } else {
            $patrimonio_cuenta->updated_by = Auth::user()->id;
        }

        $patrimonio_cuenta->save();



        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la cuenta";
        $respuesta['objeto'] = $patrimonio_cuenta;

        return response()->json($respuesta);
    }

    public function get_infocuenta_por_patrimonio(Request $request)
    {


        $cuentas = patrimonios_cuentas::where('id_patrimonio', $request->id_patrimonio)
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
        }

        return response()->json($cuentas);
    }

    public function delete_info_cuenta(Request $request)
    {
        $patrimonio_cuenta = patrimonios_cuentas::find($request->id_patrimonio_cuenta);

        $patrimonio_cuenta->deleted_by = Auth::user()->id;
        $patrimonio_cuenta->save();

        $informacionlog = 'Se ha eliminado la informacion de la bitacora';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $patrimonio_cuenta,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );

        $patrimonio_cuenta->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $patrimonio_cuenta;


        return response()->json($respuesta);
    }


    ////////////patrimonio_bitacoras////////

    public function patrimonios_bitacora_store(Request $request)
    {
        $patrimonio_bitacoras = patrimonio_bitacoras::find($request->id_patrimonio_bitacora);

        //$patrimonio_bitacoras

        if ($patrimonio_bitacoras == null) {
            if (isset($request->id_patrimonio_bitacora_crear) &&  $request->id_patrimonio_bitacora_crear == 1) {
                $patrimonio_bitacoras = new patrimonio_bitacoras();
            } else {
                $respuesta['status'] = "error";
                $respuesta['message'] = "No tiene permiso para crear registros nuevos";
                $respuesta['objeto'] = $patrimonio_bitacoras;
                return response()->json($respuesta);
            }
        }

        $patrimonio_bitacoras->id_patrimonio = $request->id_patrimonio;
        $patrimonio_bitacoras->nombre_bitacora = $request->nombre_bitacora;
        $patrimonio_bitacoras->responsable = $request->responsable;
        $patrimonio_bitacoras->descripcion_bitacora = $request->descripcion_bitacora;

        if ($request->id_patrimonio_bitacora == 0) {
            $patrimonio_bitacoras->created_by = Auth::user()->id;
        } else {
            $patrimonio_bitacoras->updated_by = Auth::user()->id;
        }

        $patrimonio_bitacoras->save();

        $validacion= bitacoras_seguimiento::where('id_bitacora',$patrimonio_bitacoras->id)
                                         ->where('estado',1)
                                         ->first();

        $fecha_registro = Carbon::now()->parse()->format('Y-m-d');

        if($validacion == null )
        {
            if(isset($request->id_patrimonio_bitacora_crear) &&  $request->id_patrimonio_bitacora_crear==1)
            {
                
                $patrimonio_bitacoras_segumiento = new bitacoras_seguimiento();
                $patrimonio_bitacoras_segumiento->id_bitacora = $patrimonio_bitacoras->id;
                $patrimonio_bitacoras_segumiento->observaciones = $request->observaciones_bitacoras;
                $patrimonio_bitacoras_segumiento->param_estado_bitacora_valor = 1;
                $patrimonio_bitacoras_segumiento->param_estado_bitacora_texto = Parametricas::getTextFromValue('patrimonios.bitacora.estado',1);
                $patrimonio_bitacoras_segumiento->fecha_registro = $fecha_registro;
                $patrimonio_bitacoras_segumiento->estado = 1;
                $patrimonio_bitacoras_segumiento->created_by = Auth::user()->id;
                $patrimonio_bitacoras_segumiento->save();
            }
        }else{
                $patrimonio_bitacoras_segumiento = bitacoras_seguimiento::find($validacion->id);
                $patrimonio_bitacoras_segumiento->observaciones = $request->observaciones_bitacoras;
                $patrimonio_bitacoras_segumiento->fecha_registro = $fecha_registro;
                $patrimonio_bitacoras_segumiento->updated_by = Auth::user()->id;
                $patrimonio_bitacoras_segumiento->save();
        }

        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la bitaora";
        $respuesta['objeto'] = $patrimonio_bitacoras;

        return response()->json($respuesta);
    }

    public function get_infobitacora_por_patrimonio(Request $request)
    {
        $bitacoras = patrimonio_bitacoras::leftJoin('patrimonio_bitacoras_seguimiento','patrimonio_bitacoras_seguimiento.id_bitacora','=','patrimonio_bitacoras.id')
            ->where('patrimonio_bitacoras.id_patrimonio', $request->id_patrimonio)
            ->where('patrimonio_bitacoras_seguimiento.estado',1)
            ->select('patrimonio_bitacoras.id','patrimonio_bitacoras.nombre_bitacora','patrimonio_bitacoras_seguimiento.fecha_registro','patrimonio_bitacoras.descripcion_bitacora','patrimonio_bitacoras_seguimiento.param_estado_bitacora_texto','patrimonio_bitacoras.responsable')
            ->get();

        return response()->json($bitacoras);
    }

    public function delete_info_bitacora(Request $request)
    {
        $patrimonio_bitacoras = patrimonio_bitacoras::find($request->id_patrimonio_bitacora);

        $patrimonio_bitacoras->deleted_by = Auth::user()->id;
        $patrimonio_bitacoras->save();


        $informacionlog = 'Se ha eliminado la informacion de la bitacora';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $patrimonio_bitacoras,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );

        foreach ($patrimonio_bitacoras->patrimonio_bitacoras_seguimiento as $seguimiento) {
            $seguimiento->deleted_by = Auth::user()->id;
            $seguimiento->save();
            $seguimiento->delete();
        }
        $patrimonio_bitacoras->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $patrimonio_bitacoras;


        return response()->json($respuesta);
    }


    ////////////Cuentas_movimientos////////

    public function get_infocuenta_por_patrimonio_movimientos(Request $request)
    {
        $id_patrimonio = patrimonios_cuentas::where('id', $request->id)->select('id_patrimonio')->first();

        $consulta = patrimonios_cuentas::find($request->id);

        $cuenta = $consulta->toArray();

        $consulta = Parametricas::where('categoria', '=', 'financiero.patrimonios.cuentas.tipo_operacion')
            ->where(function ($query) {
                $query->where('valor', 1)
                    ->orWhere('valor', 2);
            })
            ->select('valor', 'texto')
            ->get();

        $tipo_uno = $consulta->toArray();

        $consulta = Parametricas::where('categoria', '=', 'financiero.patrimonios.cuentas.tipo_operacion')
            ->where('valor', 3)
            ->select('valor', 'texto')
            ->first();

        $tipo_dos = $consulta->toArray();

        return view('patrimonios.movimiento', compact('cuenta', 'tipo_uno', 'tipo_dos', 'id_patrimonio'));
    }

    public function patrimonios_cuentas_movimientos_store(Request $request)
    {
        $rules = [
            'valor' => 'required',
        ];

        $messages = [
            'valor.required' => 'Campo requerido',
        ];

        $relacion = patrimonios_cuentas::find($request->id_cuenta_movimiento);
        $valor_asignado = $relacion->valor_asignado;

        $valor_r = cuentas_movimientos::where('id_cuenta',$request->id_cuenta_movimiento)
        ->where(function ($query) {
            $query->where('id_param_tipo_movimiento', 1)
                ->orWhere('id_param_tipo_movimiento', 2);
        })
        ->select( DB::raw('sum(valor) as Valor'))
        ->get();

        $valor_comprometido = ($valor_r[0]->Valor);

        $disponible = $valor_asignado - $valor_comprometido;

        if ($request->valor > 0) {
            if($disponible == 0 ){

                $rules['valor_contrato3'] = 'required';
                $messages['valor_contrato3.required'] = 'El valor de los movimientos ya llego al valor asignado a esta cuenta!';

            }
            /*elseif($disponible < $request->valor){

                $rules['valor_contrato4'] = 'required';
                $messages['valor_contrato4.required'] = 'El valor del movimiento supera el valor disponible la cuenta';

            }*/
        }

           

        $this->validate($request, $rules, $messages);

        $cuenta_movimiento = cuentas_movimientos::find($request->id_patrimonio_cuenta_movimiento);
        if ($cuenta_movimiento == null) {
            if (isset($request->id_patrimonio_cuenta_movimiento_crear) &&  $request->id_patrimonio_cuenta_movimiento_crear == 1) {
              /*  if ($request->valor > $request->valor_disponible_c) {
                    $rules['valor_contrato2'] = 'required';
                    $messages['valor_contrato2.required'] = 'El valor del movimiento supera el valor disponible del convenio';
                }

                $this->validate($request, $rules, $messages);*/

                $cuenta_movimiento = new cuentas_movimientos();
            } else {
                $respuesta['status'] = "error";
                $respuesta['message'] = "No tiene permiso para crear registros nuevos";
                $respuesta['objeto'] = $cuenta_movimiento;
                return response()->json($respuesta);
            }
        }

        $cuenta_movimiento->id_cuenta = $request->id_cuenta_movimiento;
        $cuenta_movimiento->id_param_tipo_movimiento = $request->valor_tipo_movimiento;
        $cuenta_movimiento->id_param_tipo_movimiento_text = Parametricas::getTextFromValue('financiero.patrimonios.cuentas.tipo_operacion', $request->valor_tipo_movimiento);
        $cuenta_movimiento->concepto_movimiento = $request->concepto;
        $cuenta_movimiento->valor = $request->valor;
        $cuenta_movimiento->Observaciones =  $request->descripcion;

        if ($request->id_patrimonio_cuenta_movimiento == 0) {
            $cuenta_movimiento->created_by = Auth::user()->id;
        } else {
            $cuenta_movimiento->updated_by = Auth::user()->id;
        }

        $cuenta_movimiento->save();

        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la bitaora";
        $respuesta['objeto'] = $cuenta_movimiento;

        return response()->json($respuesta);
    }

    public function patrimonios_cuentas_rendimientos_store(Request $request)
    {

        $cuenta_movimiento = cuentas_movimientos::find($request->id_patrimonio_cuenta_rendimiento);

        if ($cuenta_movimiento == null) {
            if (isset($request->id_patrimonio_cuenta_rendimiento_crear) &&  $request->id_patrimonio_cuenta_rendimiento_crear == 1) {
                $cuenta_movimiento = new cuentas_movimientos();
            } else {
                $respuesta['status'] = "error";
                $respuesta['message'] = "No tiene permiso para crear registros nuevos";
                $respuesta['objeto'] = $cuenta_movimiento;
                return response()->json($respuesta);
            }
        }

        $cuenta_movimiento->id_cuenta = $request->id_cuenta_rendimiento;
        $cuenta_movimiento->id_param_tipo_movimiento = $request->valor_tipo_movimiento;
        $cuenta_movimiento->id_param_tipo_movimiento_text = Parametricas::getTextFromValue('financiero.patrimonios.cuentas.tipo_operacion', $request->valor_tipo_movimiento);
        $cuenta_movimiento->concepto_movimiento = $request->concepto_rendimiento;
        $cuenta_movimiento->valor = $request->valor_rendimiento;
        $cuenta_movimiento->Observaciones =  $request->descripcion_rendimiento;

        if ($request->id_patrimonio_cuenta_rendimiento == 0) {
            $cuenta_movimiento->created_by = Auth::user()->id;
        } else {
            $cuenta_movimiento->updated_by = Auth::user()->id;
        }

        $cuenta_movimiento->save();



        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la bitaora";
        $respuesta['objeto'] = $cuenta_movimiento;

        return response()->json($respuesta);
    }

    public function get_infomovimientos_por_cuenta(Request $request)
    {
        $movimientos = cuentas_movimientos::where('id_cuenta', $request->id_cuenta)
            ->where(function ($query) {
                $query->where('id_param_tipo_movimiento', 1)
                    ->orWhere('id_param_tipo_movimiento', 2);
            })
            ->get();

        return response()->json($movimientos);
    }


    public function get_inforendimientos_por_cuenta(Request $request)
    {
        $movimientos = cuentas_movimientos::where('id_cuenta', $request->id_cuenta)
            ->where('id_param_tipo_movimiento', 3)
            ->get();

        return response()->json($movimientos);
    }


    public function delete_info_movimiento(Request $request)
    {
        $cuenta_movimiento = cuentas_movimientos::find($request->id_cuenta_movimiento);

        $cuenta_movimiento->deleted_by = Auth::user()->id;
        $cuenta_movimiento->save();


        $informacionlog = 'Se ha eliminado la informacion del movimiento';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $cuenta_movimiento,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );


        $cuenta_movimiento->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $cuenta_movimiento;


        return response()->json($respuesta);
    }

    public function get_infocuenta_saldo(Request $request)
    {
        $saldo = patrimonios_cuentas::find($request->id_cuenta)->get_saldo_cuenta();
        $id_patrimonio = patrimonios_cuentas::where('id', $request->id_cuenta)->select('id_patrimonio')->first();
        $consulta_pad = patrimonio::where('id', $id_patrimonio->id_patrimonio)->select('id_contrato_pad')->first();


        $id_pad = $consulta_pad->id_contrato_pad;

        $consulta_convenio = contratos_pads_convenios::leftJoin('contratos', 'contratos.id', '=', 'contratos_pads_convenios.id_contrato_convenio')
            ->where('contratos_pads_convenios.id_contrato_pad', $id_pad)
            ->select('contratos.valor_contrato')
            ->get();

        $valor_total = 0;

        foreach ($consulta_convenio as $convenio) {

            $valor_total = $valor_total + $convenio->valor_contrato;
        }
        //dd($valor_total);

        $patrimonio = patrimonio::find($id_patrimonio->id_patrimonio);
        $valor_suma = $patrimonio->saldo_movimientos_patrimonio();

        $valor_resta = $valor_total - $valor_suma;

        $valores = [];

        $valores['saldo'] = $saldo;
        $valores['valor_convenios'] = $valor_total;
        $valores['valor_disponible'] = $valor_resta;


        return response()->json($valores);
    }
}
