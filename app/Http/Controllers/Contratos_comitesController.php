<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos_comites as contratos_comites;
use App\Models\Contratos as contratos;
use App\Models\Parametricas ;
use Auth;
use Log;
class Contratos_comitesController extends Controller
{
    //

    public function store(Request $request){

        //dd($request);

        $id_contrato = $request->id_contrato;

        $contrato = contratos::find($id_contrato);
 
        $fechas = $contrato->contratos_fechas()->select('fecha_inicio','fecha_terminacion_actual')->first();
        $fecha_inicio = $fechas->fecha_inicio;
        $fecha_final = $fechas->fecha_terminacion_actual;
 
        $rules['id_contrato'] = 'required';   
        $messages['id_contrato.required'] ='Favor seleccione un tipo de contrato.'; 

         if(isset($request->id_comiteoperativo)){  
 
            $array_comite  = $request->id_comiteoperativo;
            $array_unique = array_unique($array_comite);

            if(count($array_comite) > count( $array_unique)){

                $rules['id_contrato2'] = 'required';
                $messages['id_contrato2.required'] ='Favor no seleccionar más de una vez al mismo integrante de comité operativo.';          
            }

            foreach($request->comiteoperativo_fecha as $fecha){

                if ($fecha < $fecha_inicio) {
                    $rules['id_contrato3'] = 'required';
                    $messages['id_contrato3.required'] ='La fecha designada para el integrante de comité operativo no puede ser inferior a la fecha inicial del contrato.';
                }
                if ($fecha > $fecha_final) {
                    $rules['id_contrato4'] = 'required';
                    $messages['id_contrato4.required'] ='La fecha designada para el integrante de comité operativo no puede ser superior a la fecha final del contrato.';
                }

            }

        }

        if(isset($request->id_comitefiduciario)){  
 
            $array_comite_fid  = $request->id_comitefiduciario;
            $array_unique = array_unique($array_comite_fid);

            if(count($array_comite_fid) > count( $array_unique)){
                $rules['id_contrato5'] = 'required';
                $messages['id_contrato5.required'] ='Favor no seleccionar más de una vez al mismo integrante de comité fiduciario.';          
            }

            foreach($request->comitefiduciario_fecha as $fecha){

                if ($fecha < $fecha_inicio) {
                    $rules['id_contrato6'] = 'required';
                    $messages['id_contrato6.required'] ='La fecha designada para el integrante de comité fiduciario no puede ser inferior a la fecha inicial del contrato.';
                }
                if ($fecha > $fecha_final) {
                    $rules['id_contrato7'] = 'required';
                    $messages['id_contrato7.required'] ='La fecha designada para el integrante de comité fiduciario no puede ser superior a la fecha final del contrato.';
                }

            }

        }

        $this->validate($request, $rules, $messages);
      
        if(isset($request->comiteoperativo)){
            foreach ($request->comiteoperativo as $key => $value ) {
                $contratos_comites = contratos_comites::find($request->id_contrato_comiteoperativo[$key]);  
                if($contratos_comites == null){
                    $contratos_comites = new contratos_comites();   
                }
                $contratos_comites->id_contrato = $request->id_contrato;
                $contratos_comites->id_terecero = $request->id_comiteoperativo[$key];
                $contratos_comites->id_tipo_comite = 1;
                $contratos_comites->fecha_asociacion = $request->comiteoperativo_fecha[$key];
                $contratos_comites->estado = 1;
                $contratos_comites->param_rol_valor =  $request->role_comiteoperativo[$key];
                $contratos_comites->param_rol_texto = Parametricas::getTextFromValue('contratos.comites.rol', $request->role_comiteoperativo[$key]);
                $contratos_comites->created_by = Auth::user()->id;
                $contratos_comites->updated_by = Auth::user()->id;
                $contratos_comites->save();
            } 
        }

        if(isset($request->comitefiduciario)){
            foreach ($request->comitefiduciario as $key2 => $value2 ) {
                $contratos_comites = contratos_comites::find($request->id_contrato_comitefiduciario[$key2]);  
                if($contratos_comites == null){
                    $contratos_comites = new contratos_comites();   
                }
                $contratos_comites->id_contrato = $request->id_contrato;
                $contratos_comites->id_terecero = $request->id_comitefiduciario[$key2];
                $contratos_comites->id_tipo_comite = 2;
                $contratos_comites->fecha_asociacion = $request->comitefiduciario_fecha[$key2];
                $contratos_comites->estado = 1;
                $contratos_comites->param_rol_valor =  $request->role_comitefiduciario[$key2];
                $contratos_comites->param_rol_texto = Parametricas::getTextFromValue('contratos.comites.rol', $request->role_comitefiduciario[$key2]);
                $contratos_comites->created_by = Auth::user()->id;
                $contratos_comites->updated_by = Auth::user()->id;
                $contratos_comites->save();
            } 
        }

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información";
    
        return response()->json($respuesta);


    }

    public function delete(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos_comite = contratos_comites::find($request->id_contrato_comite);
        
        $Contratos_comite->deleted_by = Auth::user()->id;
        $Contratos_comite->save();

        
        $informacionlog = 'Se ha eliminado el integrante del comité asociado al contrato';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $Contratos_comite,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        $Contratos_comite->delete();

       
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$Contratos_comite;

        return response()->json($respuesta);

    }
}
