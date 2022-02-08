<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Fases_planes as fases_planes;
use App\Models\semanas_parametrica as semanas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FasesPlanesController extends Controller
{
    public function fases_planes_store(Request $request){

        $consulta = fases_planes::where('id_fase',$request->fases_planes_id_fase)
        ->select(DB::raw('sum(peso_porcentual_etapa) AS valor'))
        ->whereNull('deleted_at')
        ->first();

        $valor_porcentual = $consulta->valor;

        $fases_planes = fases_planes::find($request->id_fases_planes);

        if ($fases_planes == null) {
           $nuevo_valor_porcentual = $valor_porcentual + $request->valor_porcentual_hito;
        }else {
            $nuevo_valor_porcentual = ($valor_porcentual - $fases_planes->peso_porcentual_etapa) + $request->valor_porcentual_hito;
        }

        $fases_planesExiste = fases_planes::Where([['nombre_plan',$request->nombre_plan],
                                    ['id_fase',$request->fases_planes_id_fase],
                                    ['id','<>',$request->id_fases_planes]])
                                    ->wherenull('deleted_at')->get();

        if ($fases_planesExiste->count()>0)
        {
            $rules['ExistePlan'] = 'required';
            $messages['ExistePlan.required'] ='Ya existe el hito en la etapa.';
            $this->validate($request, $rules, $messages);
        }

        if($nuevo_valor_porcentual > 100)
        {
            $rules['nuevo_valor_porcentual'] = 'required';
            $messages['nuevo_valor_porcentual.required'] ='El valor porcentual supera el total del porcentaje permitido en la etapa.';
            $this->validate($request, $rules, $messages);
        }




        if($fases_planes  == null )
        {
            if(isset($request->id_fases_planes_crear) &&  $request->id_fases_planes_crear == 1)
            {
             $fases_planes  = new fases_planes();
            }
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $fases_planes;
                return response()->json($respuesta);
            }
        }

         $fases_planes->id_fase = $request->fases_planes_id_fase;
         $fases_planes->nombre_plan = $request->nombre_plan;
         $fases_planes->peso_porcentual_etapa = $request->valor_porcentual_hito;
         $fases_planes->peso_porcentual_etapa = $request->valor_porcentual_hito;
         $fases_planes->estado = $request->estado_fase;
        

         if($request->id_fases_planes==0)
         {
             $fases_planes->created_by = Auth::user()->id;
         }else {
             $fases_planes->updated_by = Auth::user()->id;
         }
         $fases_planes->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $fases_planes;

          return response()->json($respuesta);



    }

    public function fases_planes_get_info(Request $request){      

        $fecha_hoy = Carbon::now()->parse()->format('Y-m-d');

        $semana = semanas::where('fecha_inicial','<=',$fecha_hoy)
        ->where('fecha_fin','>=',$fecha_hoy)
        ->select('id')
        ->first();

        //dd($request->fases_planes_id_fase,$semana->id);

        $fases_planes =DB::select('call usp_Consulta_Avance_hitos(?,?)',array($request->fases_planes_id_fase,$semana->id));

        return response()->json($fases_planes);

    }

    public function delete_fases_planes(Request $request)
        {
            $relacion = fases_planes::find($request->id_fases_planes);
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
