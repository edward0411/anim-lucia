<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terceros as terceros;
use Illuminate\Support\Facades\DB;


class ReporteTercerosController extends Controller
{
    //
    public function index(){

        $terceros = DB::table('terceros')
        ->whereNull('terceros.deleted_at')
        ->select('terceros.id','identificacion','terceros.nombre')
        ->get();

        //dd($terceros);
   
        $search = [];

        return view('reportes.reporte_terceros.index',compact('terceros','search'));
    }
    public function busqueda_terceros(Request $request){

        $active = true;
        $search = [];
        $olddata =$request->all();
        $terceros = DB::table('terceros')
        ->whereNull('terceros.deleted_at')
        ->select('terceros.id','identificacion','terceros.nombre')
        ->get();

        $id_tercero = $request->identificacion;

        $consulta = DB::table('terceros')
        ->select('terceros.*','terceros.param_naturaleza_juridica_texto','terceros.param_tipodocumento_texto','terceros.identificacion','terceros.primer_nombre',
        'terceros.segundo_nombre','terceros.primer_apellido','terceros.segundo_apellido','terceros.direccion','terceros.telefono','terceros.correo_electronico',
        'terceros.param_tipodocumento_rep_texto','terceros.identificacion_representante','terceros.nombre');

        if ($request->identificacion != null){
 
            $consulta = $consulta->where('terceros.id',$id_tercero);

        }
        if ($request->nombre != null){
 
            $consulta = $consulta->where('terceros.id',$request->nombre);

        }
        $consulta = $consulta->get();
        $search = $consulta->toArray();

        return view('reportes.reporte_terceros.index',compact('search','olddata','terceros','active'));


    }
}
