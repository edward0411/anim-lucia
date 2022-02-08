<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terceros as terceros;
use Illuminate\Support\Facades\DB;



class ReporteTercerosCuentasBancariasController extends Controller
{
    //
    public function index(){

        $terceros_cuentas = DB::table('terceros')
        ->leftJoin('terceros_cuentas_bancarias as t_c','t_c.id_tercero','=','terceros.id')
        ->select('terceros.id','identificacion','terceros.nombre','t_c.param_banco_texto','t_c.estado')
        ->get();
        //dd($terceros_cuentas);

        $search = [];
        
        return view('reportes.reporte_terceros_cuentas_bancarias.index',compact('terceros_cuentas','search'));
    }
    public function busqueda_terceros_cuentas(Request $request){
      
        $active = true;
        $search = [];
        $olddata =$request->all();

        $terceros_cuentas = DB::table('terceros')
        ->leftJoin('terceros_cuentas_bancarias as t_c','t_c.id_tercero','=','terceros.id')
        ->whereNull('terceros.deleted_at')
        ->select('terceros.id','identificacion','terceros.nombre','t_c.param_banco_texto','t_c.estado')
        ->get();
        $id_tercero = $request->identificacion;

        $consulta = DB::table('terceros')
        ->leftJoin('terceros_cuentas_bancarias as t_c','t_c.id_tercero','=','terceros.id')
        ->whereNull('terceros.deleted_at')
        ->select('terceros.*','t_c.param_tipo_cuenta_texto','t_c.param_banco_texto',
        't_c.numero_cuenta','t_c.estado');

        if ($request->identificacion != null){
 
            $consulta = $consulta->where('terceros.id',$id_tercero);

        }
        if ($request->nombre != null){
 
            $consulta = $consulta->where('terceros.id',$request->nombre);

        }
        $consulta = $consulta->get();
        $search = $consulta->toArray();

                 return view('reportes.reporte_terceros_cuentas_bancarias.index',compact('search','olddata','terceros_cuentas','active'));



    }
}
