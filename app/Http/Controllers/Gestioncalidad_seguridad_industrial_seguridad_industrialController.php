<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calidad_seguridad_industrial_seguridad_industrial as calidad_seguridad_industrial_seguridad_industrial;
use App\Models\Parametricas as parametricas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Gestioncalidad_seguridad_industrial_seguridad_industrialController extends Controller
{

//
    public function seguridadindustrial_store(Request $request){

        $calidad_seguridad_industrial_seguridad_industrial = calidad_seguridad_industrial_seguridad_industrial::find($request->id_SeguridadIndustrial);

        


        $fecha_acta_inicio=  date('Y-m-d', strtotime($request->fecha_inicio_seguridad));

        $fecha = date('Y-m-d', strtotime($request->fecha)) ;
        
        if ($fecha_acta_inicio > $fecha && $request->Selecciono ==1 )
        {
           
            $rules['Fecha_informe_2'] = 'required';
            $messages['Fecha_informe_2.required'] ='La fecha  no puede se  inferior a la fecha de inicio del contrato.';
            $this->validate($request, $rules, $messages);
        }

        if($calidad_seguridad_industrial_seguridad_industrial  == null )
        {
            if(isset($request->id_SeguridadIndustrial_crear) &&  $request->id_SeguridadIndustrial_crear == 1)
            {
             $calidad_seguridad_industrial_seguridad_industrial  = new calidad_seguridad_industrial_seguridad_industrial();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $calidad_seguridad_industrial_seguridad_industrial ;
                return response()->json($respuesta);
            }
        }

        $calidad_seguridad_industrial_seguridad_industrial->id_calidad_seguridad_industrial   = $request->SeguridadIndustrial_id_gestion_calidad;
        if (request()->input('chk_accidente')=='1')
         {
            $calidad_seguridad_industrial_seguridad_industrial->accidente_laboral_incidente =  1;
         }
         else
         {
            $calidad_seguridad_industrial_seguridad_industrial->accidente_laboral_incidente =  0;
         }
        
        $calidad_seguridad_industrial_seguridad_industrial->param_tipo_accidente_valor = $request->tipo_accidente;
        $calidad_seguridad_industrial_seguridad_industrial->param_tipo_accidente_texto = Parametricas::getTextFromValue('GestionCalidad.tipo_accidente', $request->tipo_accidente);
        $calidad_seguridad_industrial_seguridad_industrial->fecha  = $request->fecha;
        $calidad_seguridad_industrial_seguridad_industrial->plan_mejora_leccion_aprendida = $request->plan_mejora;
        $calidad_seguridad_industrial_seguridad_industrial->adoptado = $request->adoptado;
         
        
         
         if($request->id_SeguridadIndustrial==0)
         {
             $calidad_seguridad_industrial_seguridad_industrial->created_by = Auth::user()->id;
         }else {
             $calidad_seguridad_industrial_seguridad_industrial->updated_by = Auth::user()->id;
         }
         $calidad_seguridad_industrial_seguridad_industrial->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $calidad_seguridad_industrial_seguridad_industrial;
        

          return response()->json($respuesta);

    }

    public function seguridadindustrial_get_info(Request $request){

        $calidad_seguridad_industrial_seguridad_industrial = calidad_seguridad_industrial_seguridad_industrial::where('id_calidad_seguridad_industrial',$request->SeguridadIndustrial_id_gestion_calidad)
        ->get();

        return response()->json($calidad_seguridad_industrial_seguridad_industrial);

    }

    public function delete_seguridad_industrial(Request $request)
        {
            $relacion = calidad_seguridad_industrial_seguridad_industrial::find($request->id_SeguridadIndustrial);
            $relacion->deleted_by = Auth::user()->id;
            $relacion->save();

            $informacionlog = 'Se ha eliminado la informacion de la bitacora';
            $objetolog = [
                    'user_id' => Auth::user()->id,
                    'user_email' => Auth::user()->mail,
                    'Objeto Eliminado' => $relacion,
                    ];

            Log::channel('database')->info(
                $informacionlog ,
                $objetolog
            );

            $relacion->delete();
            $respuesta['status']="success";
            $respuesta['message']="Se ha eliminado registro";
            $respuesta['objeto']=$relacion;


            return response()->json($respuesta);

        }




}
