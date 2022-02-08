<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supervision_acta_suspensiones as supervision_acta_suspensiones;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class supervision_acta_suspensionesController extends Controller
{
    //
    public function supervicion_acta_suspencion_store(Request $request)
    {
        $supervision_acta_suspensiones = supervision_acta_suspensiones::find($request->id_supervision_acta_suspensiones);

      
      /*  if ($request->fecha_suscripcion_c > $request->fecha_suscripcion) {
            $rules['fecha_expedicion_2'] = 'required';
            $messages['fecha_expedicion_2.required'] ='La fecha de suscripciónno no puede ser inferior a la fecha de suscripción del contrato.';
            $this->validate($request, $rules, $messages);
        }

        if ($request->fecha_terminacion < $request->fecha_suscripcion) {
            $rules['fecha_expedicion_2'] = 'required';
            $messages['fecha_expedicion_2.required'] ='La fecha de suscripciónno no puede ser mayor a la fecha de fecha_suscripcion del contrato.';
            $this->validate($request, $rules, $messages);
        }*/


        if($supervision_acta_suspensiones  == null )
        {
            if(isset($request->id_supervision_acta_suspensiones_crear) &&  $request->id_supervision_acta_suspensiones_crear == 1)
            {
                $supervision_acta_suspensiones  = new supervision_acta_suspensiones();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $supervision_acta_suspensiones ;
                return response()->json($respuesta);
            }
        }

         $supervision_acta_suspensiones->id_supervision  = $request->supervision_acta_suspensiones_id_supervision;
        
         $supervision_acta_suspensiones->observaciones = $request->observaciones;
         
         if($request->id_supervision_acta_suspensiones==0)
         {
             $supervision_acta_suspensiones->created_by = Auth::user()->id;
         }else 
         {
             $supervision_acta_suspensiones->updated_by = Auth::user()->id;
         }
         $supervision_acta_suspensiones->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $supervision_acta_suspensiones;

          return response()->json($respuesta);


    }

    public function supervicion_acta_suspencion_get_info(Request $request){
       // dd($request);
        $supervision_acta_suspensiones = supervision_acta_suspensiones::where('id_supervision',$request->supervision_acta_suspensiones_id_supervision)
       
        ->get();

        return response()->json($supervision_acta_suspensiones);
    }

   

    public function delete_supervicion_acta_suspencion(Request $request)
        {
            //dd($request);
            $relacion = supervision_acta_suspensiones::find($request->id_supervision_acta_suspensiones);
           
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
