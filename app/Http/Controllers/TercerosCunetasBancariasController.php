<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Parametricas as parametricas;
use App\Models\Terceros as terceros;
use App\Models\Terceros_cuentas_bancarias as terceros_cuentas_bancarias;

use Illuminate\Support\Facades\Crypt;
use Auth;

class TercerosCunetasBancariasController extends Controller
{
    //
     public function index(){

        $terceros_cuentas_bancarias = DB::table('terceros_cuentas_bancarias')
        ->leftJoin('parametricas as par','par.id','=','terceros_cuentas_bancarias.param_tipo_cuenta_valor')
        ->leftJoin('parametricas','parametricas.id','=','terceros_cuentas_bancarias.param_banco_valor')
        ->leftJoin('terceros','terceros.id','=','terceros_cuentas_bancarias.id_tercero')
        ->select('terceros_cuentas_bancarias.*','par.texto','parametricas.texto','terceros.nombre','terceros.identificacion')
        ->get();


        return view('terceros_cuentas_bancarias.index',compact('terceros_cuentas_bancarias'));
     }


    public function crear(Request $request){

        $listaterceros = terceros::where('estado',1)->get();

        $tipo_cuenta = parametricas::getFromCategory('terceros.tipo_cuenta');
        $banco = parametricas::getFromCategory('terceros.banco');


        return view('terceros_cuentas_bancarias.crear',compact('tipo_cuenta','banco','listaterceros'));
    }

    public function store_cuenta(Request $request){

        //dd($request);

       $request->validate([

            'tercero' => 'required',
            'tipo_cuenta' => 'required',
            'banco' => 'required',
            'numero_cuenta' => ['required','unique:terceros_cuentas_bancarias'],

        ]);

        if($request->id_tercero == null){

            return redirect()->back()->with('error','Debe seleccionar un nombre de la lista');

        }

            $tercero_cuenta = new terceros_cuentas_bancarias();
            $tercero_cuenta->id_tercero = $request->id_tercero;
            $tercero_cuenta->param_tipo_cuenta_valor = $request->tipo_cuenta;
            $tercero_cuenta->param_tipo_cuenta_texto = Parametricas::getTextFromValue('terceros.tipo_cuenta', $request->tipo_cuenta);
            $tercero_cuenta->param_banco_valor = $request->banco;
            $tercero_cuenta->param_banco_texto = Parametricas::getTextFromValue('terceros.banco', $request->banco);
            $tercero_cuenta->numero_cuenta = $request->numero_cuenta;
            $tercero_cuenta->estado = 1;
            $tercero_cuenta->created_by = Auth::user()->id;
            $tercero_cuenta->save();

        return redirect()->route('terceros_cuentas_bancarias.index')->with('success','Informacion guardada de forma exitosa');



    }
    public function editar($id){

        $terceros_cuentas_bancarias = DB::table('terceros_cuentas_bancarias')
        ->leftJoin('parametricas as par','par.id','=','terceros_cuentas_bancarias.param_tipo_cuenta_valor')
        ->leftJoin('parametricas','parametricas.id','=','terceros_cuentas_bancarias.param_banco_valor')
        ->leftJoin('terceros','terceros.id','=','terceros_cuentas_bancarias.id_tercero')
        ->select('terceros_cuentas_bancarias.*','par.texto','parametricas.texto','terceros.nombre')
        ->where('terceros_cuentas_bancarias.id',$id)
        ->get();

        $listaterceros = terceros::where('estado',1)->get();

        $tipo_cuenta = parametricas::getFromCategory('terceros.tipo_cuenta');
        $banco = parametricas::getFromCategory('terceros.banco');

        return view('terceros_cuentas_bancarias.editar',compact('terceros_cuentas_bancarias','listaterceros','tipo_cuenta','banco'));

    }

    public function update(Request $request){

        $request->validate([

            'tercero' => 'required',
            'tipo_cuenta' => 'required',
            'banco' => 'required',
            'numero_cuenta' => 'required',

        ]);


        if($request->id_tercero == null){

            return redirect()->back()->with('error','Debe seleccionar un nombre de la lista');

        }

        $cuenta_banacaria = terceros_cuentas_bancarias::where('id','=',$request->id)->firstOrFail();
        $cuenta_banacaria->id_tercero = $request->id_tercero;
        $cuenta_banacaria->param_tipo_cuenta_valor = $request->tipo_cuenta;
        $cuenta_banacaria->param_tipo_cuenta_texto = Parametricas::getTextFromValue('terceros.tipo_cuenta', $request->tipo_cuenta);
        $cuenta_banacaria->param_banco_valor = $request->banco;
        $cuenta_banacaria->param_banco_texto = Parametricas::getTextFromValue('terceros.banco', $request->banco);
        $cuenta_banacaria->numero_cuenta = $request->numero_cuenta;
        $cuenta_banacaria->estado = 1;
        $cuenta_banacaria->created_by = Auth::user()->id;
        $cuenta_banacaria->update();

             return redirect()->route('terceros_cuentas_bancarias.index',$cuenta_banacaria->id)->with('success','Informacion actualizada de forma exitosa');

        }

        public function ver_cuentas_bancarias($id){      
        $tercero = DB::table('terceros_cuentas_bancarias')
        ->leftJoin('parametricas as par','par.id','=','terceros_cuentas_bancarias.param_tipo_cuenta_valor')
        ->leftJoin('parametricas','parametricas.id','=','terceros_cuentas_bancarias.param_banco_valor')
        ->leftJoin('terceros','terceros.id','=','terceros_cuentas_bancarias.id_tercero')
        ->select('terceros_cuentas_bancarias.*','par.texto','parametricas.texto','terceros.nombre','terceros.identificacion')
        ->where('terceros_cuentas_bancarias.id',$id)
        ->get();


            return view('terceros_cuentas_bancarias.ver_cuentas_bancarias',compact('tercero'));
        }

        public function activar($id)
        {
            $tercero_cuenta = terceros_cuentas_bancarias::where('id', $id)->firstOrFail();
            $tercero_cuenta->estado = 1;
            $tercero_cuenta->update();

        return redirect()->route  ('terceros_cuentas_bancarias.index')->with('success','Cuenta bancaria activada con éxito');
        }

        public function inactivar($id)
         {
           $tercero_cuenta = terceros_cuentas_bancarias::where('id', $id)->firstOrFail();
           $tercero_cuenta->estado = 0;
           $tercero_cuenta->update();

        return redirect()->route  ('terceros_cuentas_bancarias.index')->with('success','Cuenta bancaria inactivada con éxito');

        }

}

