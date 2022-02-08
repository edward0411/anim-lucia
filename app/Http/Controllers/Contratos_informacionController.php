<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contratos as contratos;
use App\Models\Cdrs as cdrs;
use App\Models\Cdrs_movimientos as cdrs_movimientos;
use App\Models\Parametricas as parametricas;
use App\Models\Terceros as terceros;
use App\Models\Contratos_terceros as contratos_tercero;
use App\Models\Contratos_polizas as contrato_poliza;
use App\Models\Contratos_fechas as contratos_fechas;
use App\Models\Contratos_supervisores as contratos_supervisores;
use App\Models\Contratos_comites as contratos_comites;
use App\Models\Contratos_pads_convenios as pads_convenios;
use App\Models\Terceros_cuentas_bancarias as terceros_cuentas_bancarias;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Crypt;
use Auth;

class Contratos_informacionController extends Controller
{

    public function index_convenios()
    {
        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

        $contratos_info = contratos::where('param_valor_tipo_contrato', 1)->get();
        $titulo = 'Convenio';
        $active_menu = 19;
        $param_valor_tipo_contrato = 1;
        $token = Crypt::encryptString(0);
        // $info_contra = informacion_contractuals::all();


        return view('contratos_informacion.index_informacion', compact('contratos_info', 'token', 'titulo', 'active_menu', 'param_valor_tipo_contrato'));
    }

    public function index_pdas()
    {
        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

        $contratos_info = contratos::where('param_valor_tipo_contrato', 2)->get();
        $titulo = 'PAD';
        $param_valor_tipo_contrato = 2;
        $active_menu = 20;
        $token = Crypt::encryptString(0);
        // $info_contra = informacion_contractuals::all();


        return view('contratos_informacion.index_informacion', compact('contratos_info', 'token', 'titulo', 'active_menu', 'param_valor_tipo_contrato'));
    }

    public function index_informacion()
    {
        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');

        $contratos_info = contratos::where('param_valor_tipo_contrato', 3)->get();
        $titulo = 'Contrato';
        $param_valor_tipo_contrato = 3;
        $active_menu = 13;
        $token = Crypt::encryptString(0);
        // $info_contra = informacion_contractuals::all();


        return view('contratos_informacion.index_informacion', compact('contratos_info', 'token', 'titulo', 'active_menu', 'param_valor_tipo_contrato'));
    }

    public function crear_informacion($id, $id_tipo_contrato)
    {
        $id_contrato = Crypt::decryptString($id);

        $dependencias = parametricas::getFromCategory('contratos.dependencia');

        $tipo_contrato =  $id_tipo_contrato;

        $regimen = parametricas::getFromCategory('contratos.regimen');

        $modalidad = parametricas::Where('categoria', 'contratos.modalidades')
            ->orderBy('orden')
            ->select('valor', 'texto', 'valor_padre')
            ->get();

        $tipo_terminacion = parametricas::getFromCategory('contratos.tipo_terminacion');
        $tipo_liquidacion = parametricas::getFromCategory('contratos.tipo_liquidacion');

        $clase_contrato = parametricas::getFromCategory('contratos.clase_contrato');

        $convenios = contratos::Where('param_valor_tipo_contrato', '1')->Select('id', 'numero_contrato')->get();

        //acá inicial los parametros de las demas pestañas
        $cdrs = cdrs::with('Cdr_cuentas_operaciones')->get();

        $contratos = null;
        $terceros = null;
        $contratos_terceros = null;
        $contratos_polizas = null;
        $contratos_fechas = null;
        $contratos_interventoria = null;
        $contratos_supervisores = null;
        $contratos_derivados = null;
        $contratos_comites = null;
        $comitesroles = null;
        $aseguradoras = null;

        if ($id_contrato > 0) {

            $contratos = contratos::findOrFail($id_contrato);
            //dd($contratos);

            //traer la informacion del Contratista
            $terceros = terceros::all();

            //$contratos_terceros = contratos_tercero::with('Terceros')->where('id_contrato',$id_contrato)
            $contratos_terceros = contratos_tercero::with('tercero')->where('id_contrato', $id_contrato)
                ->get();



            $contratos_polizas = contrato_poliza::where('id_contrato', $id_contrato)
                ->get();

            //dd($contratos_terceros[0]->tercero->identificacion);
            $contratos_fechas = contratos_fechas::where('id_contrato', $id_contrato)
                ->first();



            $contratos_interventoria = contratos::with('contratos_terceros')->get();

            $contratos_supervisores = contratos_supervisores::where('id_contrato', $id_contrato)->get();
            // dd($id_contrato,$contratos_supervisores);

            $contratos_derivados = contratos::with('contratos_fechas')->where('numero_convenio', $id_contrato)->get();
            //dd($contratos_derivados);

            $comitesroles = parametricas::getFromCategory('contratos.comites.rol');

            $aseguradoras = parametricas::getFromCategory('contratos.polizas.aseguradoras');

            $contratos_comites = contratos_comites::where('id_contrato', $id_contrato)->get();
        }

       
        switch ($tipo_contrato) {
            case 1:
                return view(
                    'contratos_informacion.crear_convenio',
                    compact(
                        'dependencias',
                        'tipo_contrato',
                        'regimen',
                        'modalidad',
                        'clase_contrato',
                        'convenios',
                        'contratos',
                        'cdrs',
                        'terceros',
                        'contratos_interventoria',
                        'contratos_terceros',
                        'contratos_polizas',
                        'contratos_fechas',
                        'contratos_supervisores',
                        'contratos_derivados',
                        'comitesroles',
                        'contratos_comites',
                        'tipo_terminacion',
                        'tipo_liquidacion',
                        'id_contrato'
                    )
                );
                break;
            case 2:
                $convenio_array = (array) null;

                if (isset($contratos->contratos_pads_convenios)) {
                    foreach ($contratos->contratos_pads_convenios as $convenio_pad) {
                        $convenio_array[] = $convenio_pad->id_contrato_convenio;
                    }
                }

                $contratos_comites = contratos_comites::wherein('id_contrato',  $convenio_array)->get();



                return view(
                    'contratos_informacion.crear_pad',
                    compact(
                        'dependencias',
                        'tipo_contrato',
                        'regimen',
                        'modalidad',
                        'clase_contrato',
                        'convenios',
                        'contratos',
                        'cdrs',
                        'terceros',
                        'contratos_interventoria',
                        'contratos_terceros',
                        'contratos_polizas',
                        'contratos_fechas',
                        'contratos_supervisores',
                        'contratos_derivados',
                        'comitesroles',
                        'contratos_comites',
                        'tipo_terminacion',
                        'tipo_liquidacion',
                        'id_contrato'

                    )
                );
                break;
            case 3:


                $contratos_derivados = contratos_supervisores::with('contrato')
                    ->where('id_contrato_dependiente', $id_contrato)
                    ->get();

                // $contratos_derivados= contratos::with('contrato')
                //                         ->join('contratos_supervisores','contratos.id','=','contratos_supervisores.id_contrato')
                //                         ->where('id_contrato_dependiente',$id_contrato)
                //                         ->get();

                return view(
                    'contratos_informacion.crear_informacion',
                    compact(
                        'dependencias',
                        'tipo_contrato',
                        'regimen',
                        'modalidad',
                        'clase_contrato',
                        'convenios',
                        'contratos',
                        'cdrs',
                        'terceros',
                        'contratos_interventoria',
                        'contratos_terceros',
                        'contratos_polizas',
                        'contratos_fechas',
                        'contratos_supervisores',
                        'contratos_derivados',
                        'comitesroles',
                        'contratos_comites',
                        'aseguradoras',
                        'tipo_terminacion',
                        'tipo_liquidacion',
                        'id_contrato'

                    )
                );
                break;
        }
    }
    public function editar_informacion()
    {
        return view('contratos_informacion.editar_informacion');
    }

    public function store_informacion(Request $request)
    {
       //dd($request);

        switch ($request->tipo_contrato) {
            case 1:
                //dd($request->id_contrato);
                $request->validate([
                    'dependencia' => 'required',
                    'vigencia' => 'required',
                    'tipo_contrato' => 'required',
                    'regimen' => 'required',
                    'modalidad' => 'required',
                    //'numero_contrato' => ['required','unique:contratos,numero_contrato,'.$request->numero_contrato.',id,vigencia,'.$request->vigencia],
                    'numero_contrato' => 'required',
                    'valor_contrato' => 'required',
                    'objeto_contrato' => 'required',
                ]);

                $contrato = contratos::where('numero_contrato', '=', $request->numero_contrato)
                    ->where('vigencia', '=', $request->vigencia)
                    ->where('param_valor_tipo_contrato', '=', $request->tipo_contrato)
                    ->where('id', '<>', $request->id_contrato)
                    ->get();
                if ($contrato->count() > 0) {
                    return Redirect::back()->withInput()->withErrors(["numero contrato" => "El número del convenio ya ha sido utilzado en esta vigencia"]);
                }

                break;
            case 2:
                $request->validate([
                    'dependencia' => 'required',
                    'vigencia' => 'required',
                    'tipo_contrato' => 'required',
                    'numero_contrato' => 'required',
                    'valor_contrato' => 'required',
                    'objeto_contrato' => 'required',
                ]);

                $contrato = contratos::where('numero_contrato', '=', $request->numero_contrato)
                    ->where('vigencia', '=', $request->vigencia)
                    ->where('param_valor_tipo_contrato', '=', $request->tipo_contrato)
                    ->where('id', '<>', $request->id_contrato)
                    ->get();
                if ($contrato->count() > 0) {
                    return Redirect::back()->withInput()->withErrors(["numero contrato" => "El número del PAD ya ha sido utilziado en esta vigencia"]);
                }


                break;
            case 3:
                $request->validate([
                    'dependencia' => 'required',
                    'vigencia' => 'required',
                    'tipo_contrato' => 'required',
                    'regimen' => 'required',
                    'modalidad' => 'required',
                    'numero_contrato' => 'required',
                    'valor_contrato' => 'required',
                    'objeto_contrato' => 'required',
                ]);


                $contrato = contratos::where('numero_contrato', '=', $request->numero_contrato)
                    ->where('vigencia', '=', $request->vigencia)
                    ->where('numero_convenio', '=', $request->numero_convenio)
                    ->where('param_valor_tipo_contrato', '=', $request->tipo_contrato)
                    ->where('id', '<>', $request->id_contrato)
                    ->get();


                if ($contrato->count() > 0) {
                    //$validator->errors()->add('event', 'Please select an event');
                    return Redirect::back()->withInput()->withErrors(["numero contrato" => "El número del contrato ya ha sido utilzado en el convenio"]);
                }


                $cdr = cdrs::find($request->id_cdr);
                $suma = $cdr->saldo_cdr();
                //dd($request);
                if ($request->valor_contrato > $suma) {
                    return Redirect::back()->withInput()->withErrors(["error_maximo" => "el valor del contrato no debe superar el valor del CDR"]);
                }

                break;
        }

        $contratos = contratos::find($request->id_contrato);
        if ($contratos == null) {
            $contratos = new contratos();
        }

        $contratos->param_valor_dependencia = $request->dependencia;
        $contratos->param_texto_dependencia = Parametricas::getTextFromValue('contratos.dependencia', $request->dependencia);
        $contratos->vigencia = $request->vigencia;
        $contratos->param_valor_tipo_contrato = $request->tipo_contrato;
        $contratos->param_texto_tipo_contrato = Parametricas::getTextFromValue('contratos.tipo_contrato', $request->tipo_contrato);
        $contratos->param_valor_regimen_contratacion = $request->regimen;
        $contratos->param_texto_regimen_contratacion = Parametricas::getTextFromValue('contratos.regimen', $request->regimen);
        $contratos->param_valor_modalidad_contratacion = $request->modalidad;
        $contratos->param_texto_modalidad_contratacion = Parametricas::getTextFromValue('contratos.modalidades', $request->modalidad);
        $contratos->param_valor_clase_contrato = $request->clase_contrato;
        $contratos->param_texto_clase_contrato = Parametricas::getTextFromValue('contratos.clase_contrato', $request->clase_contrato);
        $contratos->numero_contrato = $request->numero_contrato;
        if (($request->tipo_contrato == 1) || ($request->tipo_contrato == 3)) {
            $contratos->numero_convenio = $request->numero_convenio;
        }
        $contratos->valor_contrato = $request->valor_contrato;
        $contratos->id_cdr = $request->id_cdr;
        $contratos->objeto_contrato = $request->objeto_contrato;
        $contratos->ruta_secop = $request->ruta_secop;
        $contratos->link_ublicacion = $request->link_ubicacion;
        $contratos->ruta_gesdoc = $request->ruta_gesdoc;
        $contratos->param_valor_estado_contrato = 1; //$request->estado_contrato_valor;
        $contratos->param_texto_estado_contrato = ($request->tipo_contrato == 2) ? "Registro" : "En ejecucion"; //$request->estado_contrato;
        $contratos->created_by = Auth::user()->id;
        $contratos->save();
        $token = Crypt::encryptString($contratos->id);

        $id_contrato = $contratos->id;

        if ($request->tipo_contrato == 2) {
            $relacion = pads_convenios::where('id_contrato_pad', '=', $id_contrato)->delete();
            foreach ($request->numero_convenio as $convenio) {
                $relacion = new pads_convenios();
                $relacion->id_contrato_pad = $id_contrato;
                $relacion->id_contrato_convenio = $convenio;
                $relacion->created_by = Auth::user()->id;
                $relacion->save();
            }
        }

        $actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');
       
        return redirect()->route('contratos_informacion.crear_informacion', [$token, $request->tipo_contrato])->with('success', 'Se ha registrado la información');
    }

    public function ver_informacion($id, $id_tipo_contrato)
    {

        $id_contrato = Crypt::decryptString($id);
        $tipo_contrato = $id_tipo_contrato;

        $contratos = DB::table('contratos')
            ->leftJoin('parametricas as para', 'para.id', '=', 'contratos.param_valor_dependencia')
            ->leftJoin('parametricas as par', 'par.id', '=', 'contratos.param_valor_tipo_contrato')
            ->leftJoin('parametricas as pr', 'pr.id', '=', 'contratos.param_valor_regimen_contratacion')
            ->leftJoin('parametricas as p', 'p.id', '=', 'contratos.param_valor_modalidad_contratacion')
            ->leftJoin('contratos as con', 'contratos.numero_convenio', '=', 'con.id')
            ->select('contratos.*', 'para.texto', 'par.texto', 'pr.texto', 'p.texto', 'con.numero_contrato as convenio_padre')
            ->where('contratos.id', $id_contrato)
            ->get();
        //dd($contratos);

        $cdrs = cdrs::with('Cdr_cuentas_operaciones')->get();

        // dd($cdrs);

        $listaterceros = DB::table('contratos_terceros')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_terceros.id_terecero')
            ->leftJoin('terceros_cuentas_bancarias', 'terceros_cuentas_bancarias.id_tercero', '=', 'terceros.id')
            ->select('contratos_terceros.id', 'terceros.identificacion', 'terceros.nombre', 'terceros.param_naturaleza_juridica_texto as naturaleza_juridica', 'terceros.direccion', 'terceros.telefono', 'terceros.representante_legal', 'terceros.identificacion_representante', 'terceros.correo_electronico', 'terceros_cuentas_bancarias.param_tipo_cuenta_texto', 'terceros_cuentas_bancarias.param_banco_texto', 'terceros_cuentas_bancarias.numero_cuenta', 'contratos_terceros.valor_aporte')
            ->where('contratos_terceros.id_contrato', $id_contrato)
            ->whereNull('contratos_terceros.deleted_at')
            ->get();
        // dd($listaterceros);

        $contratos_fechas = DB::table('contratos_fechas')
            ->where('contratos_fechas.id_contrato', $id_contrato)
            ->first();
        // dd($contratos_fechas);

        $contratos_polizas = DB::table('contratos_polizas')
            ->leftJoin('contratos', 'contratos.id', '=', 'contratos_polizas.id_contrato')
            ->where('contratos_polizas.id_contrato', $id_contrato)
            ->whereNull('contratos_polizas.deleted_at')
            ->get();
        //    dd($contratos_polizas,$id);

        $contratos_supervisores = DB::table('contratos_supervisores')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
            ->select('contratos_supervisores.*', 'terceros.identificacion', 'terceros.nombre')
            ->where('contratos_supervisores.id_contrato', $id_contrato)
            ->where('contratos_supervisores.id_tipo_supervisor', 1)
            ->where('contratos_supervisores.estado', 1)
            ->whereNull('contratos_supervisores.deleted_at')
            ->get();



        $contrato_interventores = DB::table('contratos_supervisores')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
            ->leftJoin('contratos', 'contratos.id', '=', 'contratos_supervisores.id_contrato')
            ->leftJoin('contratos as con', 'contratos.numero_convenio', '=', 'con.id')
            ->select('contratos_supervisores.*', 'contratos.numero_contrato', 'terceros.nombre', 'con.numero_contrato as convenio_padre')
            ->where('contratos_supervisores.id_contrato', $id_contrato)
            ->where('contratos_supervisores.id_tipo_supervisor', 2)
            ->where('contratos_supervisores.estado', 1)
            ->whereNull('contratos_supervisores.deleted_at')
            ->get();

        // dd($contrato_interventores);

        $contratos_apoyo_supervision = DB::table('contratos_supervisores')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
            ->leftJoin('contratos', 'contratos.id', '=', 'contratos_supervisores.id_contrato')
            ->select('contratos_supervisores.*', 'terceros.identificacion', 'terceros.nombre')
            ->where('contratos_supervisores.id_contrato', $id_contrato)
            ->where('contratos_supervisores.id_tipo_supervisor', 3)
            ->where('contratos_supervisores.estado', 1)
            ->whereNull('contratos_supervisores.deleted_at')
            ->get();

        // dd($contratos_apoyo_supervision);

        $contratos_comites_operativo = DB::table('contratos_comites')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_comites.id_terecero')
            ->select('contratos_comites.*', 'terceros.identificacion', 'terceros.nombre')
            ->where('contratos_comites.id_contrato', $id_contrato)
            ->where('contratos_comites.id_tipo_comite', 1)
            ->where('contratos_comites.estado', 1)
            ->whereNull('contratos_comites.deleted_at')
            ->get();

        $contratos_comites_fiduciario = DB::table('contratos_comites')
            ->leftJoin('terceros', 'terceros.id', '=', 'contratos_comites.id_terecero')
            ->select('contratos_comites.*', 'terceros.identificacion', 'terceros.nombre')
            ->where('contratos_comites.id_contrato', $id_contrato)
            ->where('contratos_comites.id_tipo_comite', 2)
            ->where('contratos_comites.estado', 1)
            ->whereNull('contratos_comites.deleted_at')
            ->get();



        $contratos_derivados = contratos::with('contratos_fechas')
            ->where('numero_convenio', $id_contrato)
            ->get();

        //dd($contratos_derivados);

        switch ($tipo_contrato) {
            case 1:
                return view(
                    'contratos_informacion.ver_informacion',
                    compact(
                        'contratos',
                        'listaterceros',
                        'contratos_fechas',
                        'contratos_polizas',
                        'contratos_supervisores',
                        'contrato_interventores',
                        'contratos_apoyo_supervision',
                        'contratos_comites_operativo',
                        'contratos_comites_fiduciario',
                        'contratos_derivados'
                    )
                );
                break;
            case 2;


                $contratos_pads_convenios = DB::table('contratos_pads_convenios')
                    ->leftJoin('contratos', 'contratos.id', '=', 'contratos_pads_convenios.id_contrato_convenio')
                    ->select('contratos_pads_convenios.*', 'contratos.numero_contrato')
                    ->where('contratos_pads_convenios.id_contrato_pad', $contratos[0]->id)
                    ->whereNull('contratos_pads_convenios.deleted_at')
                    ->get();

                foreach ($contratos_pads_convenios as $pad) {
                    $array_id_contrato[] = $pad->id_contrato_convenio;
                }



                $contratos_comites_operativo = DB::table('contratos_comites')
                    ->leftJoin('terceros', 'terceros.id', '=', 'contratos_comites.id_terecero')
                    ->select('contratos_comites.*', 'terceros.identificacion', 'terceros.nombre')
                    ->whereIn('contratos_comites.id_contrato', $array_id_contrato)
                    ->where('contratos_comites.id_tipo_comite', 1)
                    ->where('contratos_comites.estado', 1)
                    ->whereNull('contratos_comites.deleted_at')
                    ->get();

                // dd($contratos_comites_operativo);

                $contratos_comites_fiduciario = DB::table('contratos_comites')
                    ->leftJoin('terceros', 'terceros.id', '=', 'contratos_comites.id_terecero')
                    ->select('contratos_comites.*', 'terceros.identificacion', 'terceros.nombre')
                    ->whereIn('contratos_comites.id_contrato', $array_id_contrato)
                    ->where('contratos_comites.id_tipo_comite', 2)
                    ->where('contratos_comites.estado', 1)
                    ->whereNull('contratos_comites.deleted_at')
                    ->get();


                $contratos_supervisores = DB::table('contratos_supervisores')
                    ->leftJoin('terceros', 'terceros.id', '=', 'contratos_supervisores.id_terecero')
                    ->select('contratos_supervisores.*', 'terceros.identificacion', 'terceros.nombre')
                    ->whereIn('contratos_supervisores.id_contrato', $array_id_contrato)
                    ->where('contratos_supervisores.id_tipo_supervisor', 1)
                    ->where('contratos_supervisores.estado', 1)
                    ->whereNull('contratos_supervisores.deleted_at')
                    ->get();


                return view(
                    'contratos_informacion.ver_pad',
                    compact(
                        'contratos',
                        'listaterceros',
                        'contratos_fechas',
                        'contratos_polizas',
                        'contratos_supervisores',
                        'contrato_interventores',
                        'contratos_apoyo_supervision',
                        'contratos_comites_operativo',
                        'contratos_comites_fiduciario',
                        'contratos_derivados',
                        'contratos_pads_convenios'
                    )
                );

                break;
            case 3;

                $id_cdr = $contratos[0]->id_cdr;
                $cdr = cdrs::find($id_cdr);
                return view(
                    'contratos_informacion.ver_contratacion_derivada',
                    compact(
                        'contratos',
                        'cdrs',
                        'cdr',
                        'listaterceros',
                        'contratos_fechas',
                        'contratos_polizas',
                        'contratos_supervisores',
                        'contrato_interventores',
                        'contratos_apoyo_supervision',
                        'contratos_comites_operativo',
                        'contratos_comites_fiduciario',
                        'contratos_derivados'
                    )
                );
                break;
        }
    }

    public function store_convenios()
    {
        return redirect()->route('contratos_informacion.crear_informacion')->with('success', 'Informacion guadada de forma exitosa');
    }

    public function get_info_contrato(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = Contratos::where('id', $request->id_contrato)
            ->get();

        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

    public function delete($id)
    {
        $contrato = Contratos::where('id', $id)->first();

        $contrato->deleted_by = Auth::user()->id;
        $contrato->save();
        $contrato->delete();

        return redirect()->route('contratos_informacion.index_informacion')->with('success','Contrato eliminado éxitosamente.');
    }
}
