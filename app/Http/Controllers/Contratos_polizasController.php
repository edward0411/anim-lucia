<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos as contratos;
use App\Models\Contratos_fechas as contratos_fechas;
use App\Models\Contratos_polizas as contratos_polizas;
use App\Models\Contratos_polizas_amparos as contratos_polizas_amparos;
use Auth;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\Parametricas as parametricas;
use App\Traits\Contratos as t_contratos;


class Contratos_polizasController extends Controller
{
    use t_contratos;

    public function get_info_por_contrato(Request $request)
    {

        $Contratos_polizas = Contratos_polizas::where('id_contrato', $request->id_contrato)->with('Contratos_polizas_amparos')
            ->get();

        return response()->json($Contratos_polizas);
    }

    public function get_amparos_por_poliza(Request $request)
    {

        $contratos_polizas_amparos = contratos_polizas_amparos::where('id_contratos_polizas', $request->id_contratos_polizas)
            ->get();

        return response()->json($contratos_polizas_amparos);
    }


    public function delete_info_polizas(Request $request)
    {
        $contratos_polizas = contratos_polizas::find($request->id_contrato);
        $contratos_polizas->deleted_by = Auth::user()->id;
        $contratos_polizas->delete();


        $informacionlog = 'Se ha eliminado la informacion de la póliza';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $contratos_polizas,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );

        // $info_contra = informacion_contractuals::all();
        $contratos_polizas->delete();

        $this->UpdateDateInitial($request->id_contrato);
        
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $contratos_polizas;


        return response()->json($respuesta);
    }


    public function store(Request $request)
    {
        $consulta = contratos_polizas::where('id_contrato',$request->id_contrato)->first(); 

        $rules = [
            'id_contrato' => 'required',            
        ];
        
        $messages = [
            'id_contrato.required' => 'Debe seleccionar un tipo de contrato', 
                
        ];

        $id_contrato = $request->id_contrato;
        $contrato = contratos::find($id_contrato);
        $fechas = $contrato->contratos_fechas()->select('fecha_firma')->first();
        if ($fechas == null) {
            $rules['poliza_fecha_aprobacion3'] = 'required';
            $messages['poliza_fecha_aprobacion3.required'] ='Debe ingresar primero la fecha firma de inicio del contrato.';          
          }
          $this->validate($request, $rules, $messages);
        $fecha_firma = $fechas->fecha_firma;

        if ($request->poliza_fecha_aprobacion < $fecha_firma) {
            $rules['poliza_fecha_aprobacion2'] = 'required';
            $messages['poliza_fecha_aprobacion2.required'] ='La fecha aprobación no puede ser inferior a la fecha de la firma del contrato.';          
        }
          
          $this->validate($request, $rules, $messages);

        $contrato_poliza =  contratos_polizas::find($request->id_contratos_polizas);   
        if($contrato_poliza == null){
            $contrato_poliza = new contratos_polizas();
            $contrato_poliza->created_by = Auth::user()->id;                        
        }
        $contrato_poliza->id_contrato= $request->id_contrato;
        $contrato_poliza->numero_poliza= $request->numero_poliza;
        $contrato_poliza->aseguradora=   $request->aseguradora ;
        $contrato_poliza->fecha_aprobacion= $request->poliza_fecha_aprobacion;
        $contrato_poliza->observaciones= $request->poliza_observaciones;
        $contrato_poliza->updated_by = Auth::user()->id;                        
        $contrato_poliza->save();

        $this->UpdateDateInitial($request->id_contrato);


        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la póliza";
        $respuesta['objeto'] = $contrato_poliza;




        return response()->json($respuesta);
    }

    ///////////// Informacion Amparos//////
    
    public function amparosstore(Request $request)
    {

        $contrato_polizas =  contratos_polizas::where('id',$request->id_contratos_poliza)->first(); 


        $rules = [
            'id_contratos_poliza' => 'required',
            'amparo' => 'required',
            'amparo_desde' => 'required',
            'amparo_hasta' => 'required',
        ];
        
        $messages = [
            'id_contratos_poliza.required' => 'Debe seleccionar un tipo de contrato de poliza',
            'amparo.require' => 'El campo amparo es obligatorio',
            'amparo_desde.required' => 'El campo desde es obligatorio',
            'amparo_hasta.required' => 'El campo hasta es obligatorio',
           
                
        ];

        $id_contrato = $contrato_polizas->id_contrato;
        $contrato = contratos::find($id_contrato);
        $fechas = $contrato->contratos_fechas()->select('fecha_firma')->first();

        $fecha_firma = $fechas->fecha_firma;

        if ($request->amparo_desde < $fecha_firma) {
            $rules['amparo_desde2'] = 'required';
            $messages['amparo_desde2.required'] ='La fecha desde no puede ser inferior a la fecha de la firma del contrato.';          
          }
          if ($request->amparo_desde > $request->amparo_hasta) {
            $rules['amparo_desde3'] = 'required';
            $messages['amparo_desde3.required'] ='La fecha hasta no puede ser inferior a la fecha desde.'; 
          }
          $this->validate($request, $rules, $messages);
    
        $amparo =  contratos_polizas_amparos::find($request->amparos_id);   
        if($amparo == null){
            $amparo = new contratos_polizas_amparos();
            $amparo->created_by = Auth::user()->id;                        
        }
        $amparo->id_contratos_polizas= $request->id_contratos_poliza;
        $amparo->Amparos= $request->amparo;
        $amparo->desde=   $request->amparo_desde ;
        $amparo->hasta= $request->amparo_hasta;
        $amparo->observaciones= $request->observaciones;
        $amparo->updated_by = Auth::user()->id;                        
        $amparo->save();


        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha guardado la información de la póliza";
        $respuesta['objeto'] = $amparo;


        return response()->json($respuesta);
    }

    public function delete_info_polizas_amparos(Request $request)
    {
        $contratos_amparos = contratos_polizas_amparos::find($request->id_contratos_polizas_amparo);
        $contratos_amparos->deleted_by = Auth::user()->id;
        $contratos_amparos->save();


        $informacionlog = 'Se ha eliminado la informacion de la póliza de amparos';
        $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $contratos_amparos,
        ];

        Log::channel('database')->info(
            $informacionlog,
            $objetolog
        );

        // $info_contra = informacion_contractuals::all();
        $contratos_amparos->delete();
        $respuesta['status'] = "success";
        $respuesta['message'] = "Se ha eliminado registro";
        $respuesta['objeto'] = $contratos_amparos;


        return response()->json($respuesta);
    }
}
