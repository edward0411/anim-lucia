<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supervision_acciones_correctivas as supervision_acciones_correctivas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class supervision_acciones_correctivasController extends Controller
{
    //
    public function supervision_acciones_correctivas_store(Request $request)
    {
        $supervision_acciones_correctivas = supervision_acciones_correctivas::find($request->id_supervision_acciones_correctivas);

        


        if($supervision_acciones_correctivas  == null )
        {
            if(isset($request->id_supervision_acciones_correctivas_crear) &&  $request->id_supervision_acciones_correctivas_crear == 1)
            {
                $supervision_acciones_correctivas  = new supervision_acciones_correctivas();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $supervision_acciones_correctivas ;
                return response()->json($respuesta);
            }
        }

         $supervision_acciones_correctivas->id_supervision  = $request->supervision_acciones_correctivas_id_supervision;
         $supervision_acciones_correctivas->problema_identificado_afecta_ejecución  = $request->problema_identificado;
         $supervision_acciones_correctivas->acciones_implementadas_soluciona_problemas_identificados  = $request->acciones_implementadas;
        
         
         if($request->id_supervision_acciones_correctivas==0)
         {
             $supervision_acciones_correctivas->created_by = Auth::user()->id;
         }else 
         {
             $supervision_acciones_correctivas->updated_by = Auth::user()->id;
         }
         $supervision_acciones_correctivas->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $supervision_acciones_correctivas;

          return response()->json($respuesta);


    }

    public function supervision_acciones_correctivas_get_info(Request $request){
       // dd($request);
        $supervision_acciones_correctivas = supervision_acciones_correctivas::where('id_supervision',$request->supervision_acciones_correctivas_id_supervision)
       
        ->get();

        return response()->json($supervision_acciones_correctivas);
    }

   

    public function delete_supervision_acciones_correctivas(Request $request)
        {
            //dd($request);
            $relacion = supervision_acciones_correctivas::find($request->id_supervision_acciones_correctivas);
           
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
