<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Cdr_operaciones as Cdr_operaciones;
use App\Models\Contratos_cdrs as contratos_cdr;
use Auth;

class Contratos_cdrsController extends Controller
{
    //functionParaElApiDeObtenerControllers
    // public function get_movimiento_cdr(Request $request)
    // {

    //     //$id_cdr=Crypt::decryptString($cdr_token);

    //     $cdrs = Cdr_operaciones::where('id_cdr',$request->id_cdr)
    //             ->join('uv_patrimonio_cuentas_saldos','Cdr_operaciones.id_cuenta','=','uv_patrimonio_cuentas_saldos.id_cuenta' )
    //           ->select('uv_patrimonio_cuentas_saldos.nombre_pad',
    //              'numero_de_cuenta','descripcion_cuenta',
    //              'Cdr_operaciones.valor',
    //              'Cdr_operaciones.numero_cdr_fiduciaria',
    //              'Cdr_operaciones.id as id_cdrs_movimientos')
    //             ->get();
       
    //     // $info_contra = informacion_contractuals::all();
    //     return response()->json($cdrs);  

    // }

    public function store(Request $request )
    {
         //dd($request);
         $request->validate([
            'id_contrato' => 'required',
            'valor_contrato_cdr' => 'required'
           ] );
        
         $contratosdel = contratos_cdr::where('id_contrato',$request->id_contrato)->get();
         foreach ($contratosdel as $contrato) {
             $contrato->delete();
         }
        
        foreach ($request->valor_contrato_cdr as $key => $value) {

                $contratos_cdr = new contratos_cdr();
                $contratos_cdr->id_contrato = $request->id_contrato;
                $contratos_cdr->id_cdr_movimiento = $key;
                $contratos_cdr->created_by = Auth::user()->id;
                $contratos_cdr->valor_contrato = $value;
                $contratos_cdr->save();

                $respuesta['status']="success";
                $respuesta['message']="Se ha guardado la información";
            
            return response()->json($respuesta);
       }

    }


}
