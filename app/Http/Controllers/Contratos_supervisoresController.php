<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratos_supervisores as contratos_supervisores;
use App\Models\Contratos as contratos;
use Auth;
use Log;
class Contratos_supervisoresController extends Controller
{
    //

    public function store(Request $request){
       
       $id_contrato = $request->id_contrato;

       $contrato = contratos::find($id_contrato);

       $fechas = $contrato->contratos_fechas()->select('fecha_inicio','fecha_terminacion_actual','fecha_firma')->first();

       $fecha_firma = $fechas->fecha_firma;
       $fecha_inicio = $fechas->fecha_inicio;
       $fecha_final = $fechas->fecha_terminacion_actual;

       $rules['id_contrato'] = 'required';   
       $messages['id_contrato.required'] ='Favor seleccione un tipo de contrato.'; 

       if(isset($request->id_supervisor)){  

            $array_supervisor = $request->id_supervisor;
            $array_unique = array_unique($array_supervisor);

            if(count($array_supervisor) > count( $array_unique)){
                $rules['id_contrato2'] = 'required';
                $messages['id_contrato2.required'] ='Favor no seleccionar más de una vez al mismo Supervisor.';          
            }

            foreach($request->supervisor_fecha as $fecha){

                if ($fecha < $fecha_firma) {
                    $rules['id_contrato5'] = 'required';
                    $messages['id_contrato5.required'] ='La fecha de asignación de los supervisores no puede ser inferior a la fecha inicial del contrato.';
                }
                if ($fecha > $fecha_final) {
                    $rules['id_contrato6'] = 'required';
                    $messages['id_contrato6.required'] ='La fecha de asignación de los supervisores no puede ser superior a la fecha final del contrato.';
                }

            }

        }

        if(isset($request->contrato_interventor)){  

            $array_interventor = $request->contrato_interventor;
            $array_unique2 = array_unique($array_interventor);

            if(count($array_interventor) > count( $array_unique2)){
                $rules['id_contrato3'] = 'required';
                $messages['id_contrato3.required'] ='Favor no seleccionar más de una vez al mismo interventor.';                
            }

            foreach($request->interventor_fecha as $fecha){

                if ($fecha < $fecha_firma) {
                    $rules['id_contrato7'] = 'required';
                    $messages['id_contrato7.required'] ='La fecha de asignación de los interventores no puede ser inferior a la fecha inicial del contrato.';
                }
                if ($fecha > $fecha_final) {
                    $rules['id_contrato8'] = 'required';
                    $messages['id_contrato8.required'] ='La fecha de asignación de los interventores no puede ser superior a la fecha final del contrato.';
                }

            }


        }

        if(isset($request->id_apoyo)){  

            $array_apoyo = $request->id_apoyo;
            $array_unique3 = array_unique($array_apoyo);

            if(count($array_apoyo) > count( $array_unique3)){
                $rules['id_contrato4'] = 'required';
                $messages['id_contrato4.required'] ='Favor no seleccionar más de una vez al mismo apoyo de Supervisor.';                    
            }

            foreach($request->apoyo_fecha as $fecha){

                if ($fecha < $fecha_firma) {
                    $rules['id_contrato9'] = 'required';
                    $messages['id_contrato9.required'] ='La fecha de asignación del apoyo a supervisores no puede ser inferior a la fecha inicial del contrato.';
                }
                if ($fecha > $fecha_final) {
                    $rules['id_contrato10'] = 'required';
                    $messages['id_contrato10.required'] ='La fecha de asignación del apoyo a supervisores no puede ser superior a la fecha final del contrato.';
                }

            }

        }

        $this->validate($request, $rules, $messages);

        if(isset($request->id_supervisor)){     
            foreach ($request->id_supervisor as $key => $value ) {
                    $contratos_supervisor = contratos_supervisores::find($request->id_contrato_supervisor[$key]);  
                    if($contratos_supervisor == null){
                        $contratos_supervisor = new contratos_supervisores();   
                    }
                    $contratos_supervisor->id_contrato = $request->id_contrato;
                    $contratos_supervisor->id_terecero = $request->id_supervisor[$key];
                    $contratos_supervisor->id_tipo_supervisor = 1;
                    $contratos_supervisor->fecha_asociacion = $request->supervisor_fecha[$key];
                    $contratos_supervisor->estado = $request->estado_supervisor[$key];
                    $contratos_supervisor->created_by = Auth::user()->id;
                    $contratos_supervisor->updated_by = Auth::user()->id;
                    $contratos_supervisor->save();
            } 
        }
        if(isset($request->contrato_interventor)){
            foreach ($request->contrato_interventor as $key2 => $value2 ) {
                $contratos_interventor = contratos_supervisores::find($request->id_contrato_interventor[$key2]);  
                if($contratos_interventor == null){
                    $contratos_interventor = new contratos_supervisores();   
                }
                $contratos_interventor->id_contrato = $request->id_contrato;
                $tercero_contrato_intervnetor = contratos::find($request->contrato_interventor[$key2]);
                // dd($tercero_contrato_intervnetor);
                $contratos_interventor->id_terecero = $tercero_contrato_intervnetor->contratos_terceros[0]->id_terecero ?? null;
                $contratos_interventor->id_tipo_supervisor = 2;
                $contratos_interventor->fecha_asociacion = $request->interventor_fecha[$key2];
                $contratos_interventor->id_contrato_dependiente = $request->contrato_interventor[$key2];
                
                $contratos_interventor->estado = $request->estado_interventor[$key2];
                $contratos_interventor->created_by = Auth::user()->id;
                $contratos_interventor->updated_by = Auth::user()->id;
                
                //dd($contratos_interventor);
                $contratos_interventor->save();
            } 
        }
       if(isset($request->id_apoyo)){
        foreach ($request->id_apoyo as $key => $value ) {
                $contrato_apoyo = contratos_supervisores::find($request->id_contrato_apoyo[$key]);  
                if($contrato_apoyo == null){
                    $contrato_apoyo = new contratos_supervisores();   
                }
                $contrato_apoyo->id_contrato = $request->id_contrato;
                $contrato_apoyo->id_terecero = $request->id_apoyo[$key];
                $contrato_apoyo->id_tipo_supervisor = 3;
                $contrato_apoyo->fecha_asociacion = $request->apoyo_fecha[$key];
                $contrato_apoyo->estado = $request->estado_apoyo[$key];
                $contrato_apoyo->created_by = Auth::user()->id;
                $contrato_apoyo->updated_by = Auth::user()->id;
                $contrato_apoyo->save();
            }
    } 
        
        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información";
    
        return response()->json($respuesta);


    }


    public function delete(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos_supervisor = contratos_supervisores::find($request->id_contrato_supervisor);
        
        $Contratos_supervisor->deleted_by = Auth::user()->id;
        $Contratos_supervisor->save();

        
        $informacionlog = 'Se ha eliminado el supervisor del contrato';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $Contratos_supervisor,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        $Contratos_supervisor->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$Contratos_supervisor;

        return response()->json($respuesta);

    }


}
