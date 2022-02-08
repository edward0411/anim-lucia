<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supervision_seguimiento_tecnicos as supervision_seguimiento_tecnicos;
use App\Models\supervisiones as supervisiones;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class supervision_seguimiento_tecnicosController extends Controller
{
    //
    public function supervision_seguimiento_tecnicos_store(Request $request)
    {
        $supervision_seguimiento_tecnicos = supervision_seguimiento_tecnicos::find($request->id_supervision_seguimiento_tecnicos);

        if($supervision_seguimiento_tecnicos  == null )
        {
            if(isset($request->id_supervision_seguimiento_tecnicos_crear) &&  $request->id_supervision_seguimiento_tecnicos_crear == 1)
            {
                $supervision_seguimiento_tecnicos  = new supervision_seguimiento_tecnicos();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $supervision_seguimiento_tecnicos ;
                return response()->json($respuesta);
            }
        }

         $supervision_seguimiento_tecnicos->id_supervision  = $request->supervision_seguimiento_tecnicos_id_supervision;
         $supervision_seguimiento_tecnicos->obligacion  = $request->obligacion;
         $supervision_seguimiento_tecnicos->estado_avance_cumplimiento  = $request->estado_avance;
         $supervision_seguimiento_tecnicos->actividades_soportes_verificacion_cumplimiento = $request->actividad_soporte;
    
         
         if($request->id_supervision_seguimiento_tecnicos==0)
         {
             $supervision_seguimiento_tecnicos->created_by = Auth::user()->id;
         }else 
         {
             $supervision_seguimiento_tecnicos->updated_by = Auth::user()->id;
         }
         $supervision_seguimiento_tecnicos->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $supervision_seguimiento_tecnicos;

          return response()->json($respuesta);


    }

    public function supervision_seguimiento_tecnicos_get_info(Request $request){
   
        $supervision_seguimiento_tecnicos= supervision_seguimiento_tecnicos::where('id_supervision',$request->supervision_seguimiento_tecnicos_id_supervision)
       
        ->get();
        

        if ( $supervision_seguimiento_tecnicos->count() ==0)
        {
            $supervision_seguimiento_tecnicosMin = supervision_seguimiento_tecnicos::where('id_contrato',$request->id_contrato)
            ->join('supervisiones','supervision_seguimiento_tecnicos.id_supervision','=','supervisiones.id')
            ->select( DB::raw(" min(supervisiones.id) id") )
            ->get();

            $idmin=0;
            if ($supervision_seguimiento_tecnicosMin[0]->id != null)
            {
                $idmin=$supervision_seguimiento_tecnicosMin[0]->id;
            }

            $supervision_seguimiento_tecnicos = supervision_seguimiento_tecnicos::Where('id_supervision',$idmin)
            ->select( DB::raw('id,obligacion," " as estado_avance_cumplimiento," " as actividades_soportes_verificacion_cumplimiento' ))
            ->get();

            if( $supervision_seguimiento_tecnicos->count()>0)
            {
                 foreach ($supervision_seguimiento_tecnicos as $supervision_seguimiento_tecnico)
                {
                    $supervision_seguimiento_tecnicos  = new supervision_seguimiento_tecnicos();
                    $supervision_seguimiento_tecnicos->id_supervision  = $request->supervision_seguimiento_tecnicos_id_supervision;
                    $supervision_seguimiento_tecnicos->obligacion  = $supervision_seguimiento_tecnico->obligacion;
                    $supervision_seguimiento_tecnicos->created_by = Auth::user()->id;
                    $supervision_seguimiento_tecnicos->save();
                }
               $supervision_seguimiento_tecnicos= supervision_seguimiento_tecnicos::where('id_supervision',$request->supervision_seguimiento_tecnicos_id_supervision)
                
                ->get();
            }

            

        }


        return response()->json($supervision_seguimiento_tecnicos);
    }

    public function supervision_seguimiento_tecnicos_get_info_anterior(Request $request)
    {
        $supervision_seguimiento_tecnicosMin = supervision_seguimiento_tecnicos::where('id_contrato',$request->id_contrato)
        ->join('supervisiones','supervision_seguimiento_tecnicos.id_supervision','=','supervisiones.id')
        ->select( DB::raw(" min(supervisiones.id) id") )
        ->get();

        $Obligaciones = new supervision_seguimiento_tecnicos();
        if ($supervision_seguimiento_tecnicosMin[0]->id != null)
        {
           
            $Obligaciones = DB::select('call usp_Supervision_obligaciones(?,?)',array($supervision_seguimiento_tecnicosMin[0]->id,$request->supervision_seguimiento_tecnicos_id_supervision));

        }
        
        return response()->json($Obligaciones);
    }

   

    public function delete_supervision_seguimiento_tecnicos(Request $request)
        {
           
            $relacion = supervision_seguimiento_tecnicos::find($request->id_supervision_seguimiento_tecnicos);
           
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
