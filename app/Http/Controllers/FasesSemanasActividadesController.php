<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\semanas_parametrica as semanas_parametrica;
use App\Models\Fases_actividades as fases_actividades;
use App\Models\fases_actividades_planeacion as fases_actividades_planeacion;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class FasesSemanasActividadesController extends Controller
{
    public function crear(Request $request){

        $id_actividad = $request->id_actividad;

        $pesos = Fases_actividades::leftJoin('fases_planes','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->leftJoin('fases','fases.id','=','fases_planes.id_fase')
        ->where('fases_actividades.id',$id_actividad)
        ->select('fases.peso_porcentual_fase','fases_planes.peso_porcentual_etapa','fases.param_tipo_fase_texto','fases_planes.nombre_plan','fases_actividades.peso_porcentual_hito','fases_actividades.peso_porcentual_proyecto')
        ->first();

        $rules['id_actividad'] = 'required';
        $messages['id_actividad.required'] ='Campo requerido';

        if ($pesos->peso_porcentual_fase == null)
        {
            $rules['id_actividad2'] = 'required';
            $messages['id_actividad2.required'] ='Primero asigne peso porcentual a la etapa '.$pesos->param_tipo_fase_texto;
                 
        }
        if ($pesos->peso_porcentual_etapa == null)
        {
            $rules['id_actividad3'] = 'required';
            $messages['id_actividad3.required'] ='Primero asigne peso porcentual al hito '.$pesos->nombre_plan;
                 
        }
        if ($pesos->peso_porcentual_hito == null)
        {
            $rules['id_actividad4'] = 'required';
            $messages['id_actividad4.required'] ='Debe revisar si la actividad tiene un peso porcentual sobre el hito.'; 
                 
        }
        if ($pesos->peso_porcentual_proyecto == null)
        {
            $rules['id_actividad5'] = 'required';
            $messages['id_actividad5.required'] ='Debe revisar si la actividad tiene un peso porcentual sobre el proyecto.';              
        }

        $this->validate($request, $rules, $messages); 

      
        $fases_actividades = fases_actividades::where('id',$id_actividad)->get();
        $desde = $fases_actividades[0]->fecha_inicio;       
        $hasta = $fases_actividades[0]->fecha_fin;  

        $semanas_parametrica = DB::Table('semanas_parametrica')
        ->where('fecha_fin','>=',$desde)
        ->where('fecha_inicial','<=',$hasta)
        ->leftjoin('fases_actividades_planeacion', function($join) use ($id_actividad)
        {
            $join->on('id_semana_parametrica','=','semanas_parametrica.id');
            $join->where('id_fase_actividad', '=', $id_actividad);
        })
        ->select('semanas_parametrica.*','fases_actividades_planeacion.id as id_semana_plan','fases_actividades_planeacion.programado','fases_actividades_planeacion.porcentaje_programado','fases_actividades_planeacion.acumulado_programado','porcentaje_ejecutado')
        ->whereNull('fases_actividades_planeacion.deleted_at')
        ->orderby('fecha_inicial')
        ->get();

        //dd($semanas_parametrica);
         
         if ($semanas_parametrica->isEmpty())
         {
            $semanas_parametrica = semanas_parametrica::where('fecha_fin','>=',$desde)
            ->where('fecha_inicial','<=',$hasta)
            ->orderby('fecha_inicial')
            ->get();
         }

         //dd($semanas_parametrica);
         
        return view('fases.actividades.semanas_actividades', compact('fases_actividades','semanas_parametrica','id_actividad'));  
    }

    public function fases_actividades_planeacion_store(Request $request){   
        
        $totalPorcentaje=0;
        foreach($request->id_semana as $key=>$val){
            $totalPorcentaje = $totalPorcentaje + $request->programado[$key]; 
        }

       $val = round($totalPorcentaje,0) - 100;

        if ( $val != 0)
        {
                $rules['porcentaje_2'] = 'required';
                $messages['porcentaje_2.required'] ='El valor total del porcentaje no puede ser menor a 100.';
            
                $this->validate($request, $rules, $messages);
        }


        $exist = fases_actividades_planeacion::where('id_fase_actividad',$request->id_fases_actividades)
            ->get()
            ->toArray();
       
        foreach($request->id_semana as $key=>$val){
            if(count($exist) > 0 && isset($exist[0])) {
                $fases_actividades_planeacion = fases_actividades_planeacion::where('id_fase_actividad',$request->id_fases_actividades)
                ->where('id_semana_parametrica',$request->id_semana[$key])
                ->first();
            }else{
                $fases_actividades_planeacion = new fases_actividades_planeacion();
                $fases_actividades_planeacion->id_fase_actividad  = $request->id_fases_actividades;
                $fases_actividades_planeacion->id_semana_parametrica = $request->id_semana[$key];
            }
           
            $fases_actividades_planeacion->programado = $request->programado[$key];
            $fases_actividades_planeacion->porcentaje_programado =  $request->programado[$key];
            $fases_actividades_planeacion->acumulado_programado =  $request->por_acumulado[$key];
            
            if($request->fases_actividades_planeacion==0)
            {
                $fases_actividades_planeacion->created_by = Auth::user()->id;
            }else{
                $fases_actividades_planeacion->updated_by = Auth::user()->id;
            }
            $fases_actividades_planeacion->save();
        }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= null;// $fases_actividades_planeacion;

          return response()->json($respuesta);

    }
    

    public function delete_planeacion(Request $request)
    {

        $fases_actividades_planeacion = fases_actividades_planeacion::where('id_fase_actividad',$request->id_actividad)->get();

        foreach ($fases_actividades_planeacion as $value) {
            $value->deleted_by =  Auth::user()->id;
            $value->save();
            $value->delete();
        }

        return redirect()->back();
    }

    public function delete_planeacion_semana(Request $request)
    {

        $semana = fases_actividades_planeacion::where('id',$request->id_semana_plan)->first();
       
            $semana->deleted_by =  Auth::user()->id;
            $semana->save();
            $semana->delete();

        return redirect()->back()->with('success','Semana eliminada con éxito');
    }

    public function suspend_planeacion_semana(Request $request)
    {

        $semana = fases_actividades_planeacion::where('id',$request->id_semana_plan)->first();

            $programado =  $semana->acumulado_programado - $semana->porcentaje_programado;
       
            $semana->programado =  0;
            $semana->porcentaje_programado =  0;
            $semana->acumulado_programado = $programado;
            $semana->updated_by =  Auth::user()->id;
            $semana->save();

        return redirect()->back()->with('success','Semana suspendida con éxito');
    }
}
