<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs as cdr;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use App\Models\Cdr_operaciones as cdr_operacion;
use Illuminate\Support\Facades\DB;
use Auth;
use Log;

use Carbon\Carbon;

class CdrCuentasController extends Controller
{
    //
    public function index($id){

        $cdr = cdr::where('id',$id)->select('id','fecha_registro_cdr','objeto_cdr')->first();

        $consulta = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->select('patrimonios.id','contratos.numero_contrato','patrimonios.codigo_fid')
        ->get();

        $patrimonios = $consulta->toArray();

        $cuentas = patrimonios_cuentas::leftJoin('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
        ->select('patrimonio_cuentas.id', 'patrimonio_cuentas.id_patrimonio','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto', DB::raw('SUM(patrimonio_cuenta_movimientos.valor) as valor_cuenta'))
        ->groupBy('patrimonio_cuentas.id', 'patrimonio_cuentas.id_patrimonio','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto')
        ->where('patrimonio_cuenta_movimientos.deleted_at',null)
        ->get();

        return view('cdr.movimientos.index',compact('cdr','patrimonios','cuentas'));
    }

    public function index_get(Request $request){

        $cdr = cdr::where('id',$request->id)->select('id','fecha_registro_cdr','objeto_cdr')->first();

        $consulta = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->select('patrimonios.id','contratos.numero_contrato','patrimonios.codigo_fid')
        ->get();

        $patrimonios = $consulta->toArray();

        $cuentas = patrimonios_cuentas::leftJoin('patrimonio_cuenta_movimientos','patrimonio_cuenta_movimientos.id_cuenta','=','patrimonio_cuentas.id')
        ->select('patrimonio_cuentas.id', 'patrimonio_cuentas.id_patrimonio','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto', DB::raw('SUM(patrimonio_cuenta_movimientos.valor) as valor_cuenta'))
        ->groupBy('patrimonio_cuentas.id', 'patrimonio_cuentas.id_patrimonio','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.id_param_tipo_cuenta_texto')
        ->where('patrimonio_cuenta_movimientos.deleted_at',null)
        ->get();

        return view('cdr.movimientos.index',compact('cdr','patrimonios','cuentas'));
    }

    public function store(Request $request){

        $rules = [
            'id_patrimonio' => 'required',
            'id_cuenta' => 'required',
        ];

        $messages = [
            'id_cuenta.required' => 'La cuenta es un campo obligatorio',
            'id_patrimonio.required' => 'El campo de patrimonio es obligatorio',
        ];

        $cdr_cuenta = cdr_cuentas::where('id_cdr', $request->id_cdr)->where('id_cuenta',$request->id_cuenta)->first();

        if ($cdr_cuenta != null) {
            $rules['cdr_cuenta_2'] = 'required';
            $messages['cdr_cuenta_2.required'] ='La relaciòn entre el CDP y la cuenta ya existe.';
        }

        $this->validate($request, $rules, $messages);

        $registro = null;

        if(isset($request->id_cdr_cuenta_crear) &&  $request->id_cdr_cuenta_crear==1)
        {
            $registro = new cdr_cuentas();
        } else
        {
            $respuesta['status']="error";
            $respuesta['message']="No tiene permiso para crear registros nuevos";
            $respuesta['objeto']= $registro;
            return response()->json($respuesta);
        }

        $registro->id_cdr = $request->id_cdr;
        $registro->id_cuenta = $request->id_cuenta;
        $registro->created_by = Auth::user()->id;
        $registro->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la cuenta";
        $respuesta['objeto']= $registro;

        return response()->json($respuesta);
    }


    public function get_infocuentas_por_cdr(Request $request)
    {
        $cuentas = cdr_cuentas::leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
        ->leftJoin('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->select('cdrs_cuentas.*','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.id_patrimonio','patrimonios.codigo_fid','patrimonio_cuentas.id_param_tipo_cuenta_texto')
        ->where('cdrs_cuentas.id_cdr',$request->id_cdr)
        ->get();

        foreach ($cuentas as $cuenta){

            $cuenta['valor_cuenta'] = $cuenta->saldo_cuenta_cdr();

        }

        return response()->json($cuentas);

    }

    public function delete_relacion_cuenta(Request $request)
    {

        $cdr_cuenta = cdr_cuentas::find($request->id_cdr_cuenta);

        $cdr_cuenta->deleted_by = Auth::user()->id;
        $cdr_cuenta->save();


        $informacionlog = 'Se ha eliminado la informacion de la operacion';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $cdr_cuenta,
                ];

        Log::channel('database')->info(
            $informacionlog ,
            $objetolog
        );

        $cdr_cuenta->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$cdr_cuenta;


        return response()->json($respuesta);

    }

}
