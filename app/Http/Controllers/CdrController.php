<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrimonios as patrimonio;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs as cdr; 
use App\Models\Cdr_saldo as cdr_saldo; 
use App\Models\Cdrs_cuentas as cdr_cuentas;
use Auth;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Contratos_pads_convenios as pads_convenios;

class CdrController extends Controller
{
    //
    public function index(Request $request){
        $anio = $request->vigencia ?? now()->year;

        $cdrs = cdr_saldo::orderBy('id','desc')
                ->where('year',$anio)
                ->get();
        $cdrs_vigencias = [];
        for ($i=now()->year; $i > 2012  ; $i--) { 
            $cdrs_vigencias[] = $i;
        }


        return view('cdr.index',compact('cdrs','cdrs_vigencias', 'anio'));
    }

    public function crear(){

        $action = 1;

        $fecha = Carbon::now()->parse()->format('Y-m-d');

        return view('cdr.crear',compact('fecha','action'));
    }
    public function editar($id){

        $cdr = cdr::where('id',$id)->select('id','objeto_cdr')->first();

        $action = 2;

        $fecha = Carbon::now()->parse()->format('Y-m-d');

        return view('cdr.crear',compact('fecha','action','cdr'));
       
    }

    public function store(Request $request){
        

        $registro = new cdr();

        $registro->fecha_registro_cdr = $request->fecha;
        $registro->objeto_cdr = $request->objecto_cdr;
        $registro->created_by = Auth::user()->id;
        $registro->save();


        return redirect()->route('cdr.index')->with('success','Información guardada de forma exitosa');
    }

    public function update(Request $request){
        

        $registro =  cdr::where('id',$request->id_cdr)->firstOrFail();

      
        $registro->objeto_cdr = $request->objecto_cdr;
        $registro->updated_by = Auth::user()->id;
        $registro->save();


        return redirect()->route('cdr.index')->with('success','Información actualizada de forma exitosa');
    }

    public function delete(Request $request){
        

        $registro =  cdr::where('id',$request->id_cdr)->firstOrFail();
        $registro->deleted_by = Auth::user()->id;
        $registro->save();

       
        
        $informacionlog = 'Se ha eliminado la informacion del movimiento';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $registro,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        $registro->delete();

        return redirect()->route('cdr.index')->with('success','Información ha sido eliminada de forma exitosa');
    }

    public function reporte($id)
    {

        $fecha_sistema = Carbon::now()->format('d/m/Y H:m:s a');
        $date = Carbon::now()->locale('es');
        $day = Carbon::now()->format('d');
        $year = Carbon::now()->format('Y');
        $nombre_dia = $date->isoFormat('dddd');
        $fecha_impresion =  $nombre_dia.', '.$day.' de '.$date->monthName.' de '.$year;

        $datos = cdr::where('id',$id)
        ->select('id','objeto_cdr')->first();

        $consulta = cdr::leftJoin('cdrs_cuentas','cdrs_cuentas.id_cdr','=','cdrs.id')
        ->leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
        ->leftJoin('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->select('patrimonios.id AS id_patrimonio','patrimonios.codigo_fid','contratos.id AS id_pad','contratos.numero_contrato')
        ->where('cdrs.id',$id)
        ->distinct()
        ->get();

        $pads = $consulta->toArray();

       
        for ($i=0; $i < count($pads); $i++) { 
            
            $id_patrimonio = $pads[$i]['id_patrimonio'];
            $id_pad = $pads[$i]['id_pad'];

            $fecha = pads_convenios::leftJoin('contratos','contratos.id','=','contratos_pads_convenios.id_contrato_convenio')
            ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.id')
            ->where('contratos_pads_convenios.id_contrato_pad',$id_pad)
            ->select( DB::raw('MAX(contratos_fechas.fecha_terminacion_actual) AS fecha'))
            ->first();

            $consulta = cdr_cuentas::leftJoin('cdrs','cdrs.id','=','cdrs_cuentas.id_cdr')
            ->leftJoin('patrimonio_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
            ->leftJoin('patrimonios','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
            ->leftJoin('cdr_operaciones','cdr_operaciones.id_cdr_cuenta','=','cdrs_cuentas.id')
            ->where('patrimonios.id',$id_patrimonio)
            ->where('cdrs.id',$id)
            ->whereNull('cdrs.deleted_at')
            ->whereNull('cdrs_cuentas.deleted_at')
            ->whereNull('patrimonios.deleted_at')
            ->select('patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta', DB::raw('sum(cdr_operaciones.valor_operacion) AS valor'),'patrimonio_cuentas.Observaciones')
            ->groupby('patrimonio_cuentas.numero_de_cuenta','patrimonio_cuentas.descripcion_cuenta','patrimonio_cuentas.Observaciones')
            ->get();

            $consulta = $consulta->toArray();

            $pads[$i]['fecha_vto_convenio'] = $fecha->fecha;
          
            $pads[$i]['cuentas'] = $consulta;
           
        }

        $datos->pads = $pads;

        $usuario = strtoupper(auth()->user()->name);

        return view('cdr.reporte',compact('fecha_sistema','fecha_impresion','id','datos','usuario'));
    }
}
