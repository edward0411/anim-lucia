<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Proyectos as proyectos;
use App\Models\Fases as fases;
use App\Models\Fases_planes as fases_planes;
use App\Models\Fases_actividades as fases_actividades;
use App\Models\fases_actividades_planeacion as fases_actividades_planeacion;
use App\Models\semanas_parametrica as semanas_parametrica;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FasesActividadesController extends Controller
{

    public function crear(Request $request){

        $id_hito = $request->id_hito;
        $hito = fases_planes::find($id_hito);
        $consulta = $hito->Fases()->select('id_proyecto')->get();
        $id_proyecto = $consulta[0]->id_proyecto;
        

        $unidad_medidad = Parametricas::getFromCategory('tecnico.fases.actividades.tipo_peso');

        $caracteristicas_actividad = Parametricas::getFromCategory('tecnico.fases.actividad_caracteristicas');

        $proyecto = proyectos::find($id_proyecto );
        $fase = fases::where('id',$hito->id_fase)
        ->get();
       
        $fases_planes = Fases_planes::where('id',$id_hito)
        ->get();
        return view('fases.actividades.crear',compact('unidad_medidad','caracteristicas_actividad','proyecto','fase','fases_planes','id_hito'));
    }

   

    public function fases_actividades_store(Request $request){

        //dd($request);

        $pesos = fases_planes::leftJoin('fases','fases.id','=','fases_planes.id_fase')
        ->where('fases_planes.id',$request->id_fase_plan)
        ->select('fases.peso_porcentual_fase','fases_planes.peso_porcentual_etapa','fases.param_tipo_fase_texto','fases_planes.nombre_plan')
        ->first();

        $rules = [
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ];
        $messages = [
            'fecha_inicio.required' => 'Favor asigne una fecha de inicio',
            'fecha_fin.required' => 'Favor asigne una fecha fin',
        ];

        if($pesos->peso_porcentual_fase == null)
        {
            $rules['peso_1'] = 'required';
            $messages['peso_1.required'] ='Primero asigne valor porcentual a la etapa '.$pesos->param_tipo_fase_texto;
        }

        if($pesos->peso_porcentual_etapa == null)
        {
            $rules['peso_2'] = 'required';
            $messages['peso_2.required'] ='Primero asigne valor porcentual al hito '.$pesos->nombre_plan;
        }

        $this->validate($request, $rules, $messages);

        if(($pesos->peso_porcentual_fase != null) && ($pesos->peso_porcentual_etapa != null)){

            $valor_etapa = $pesos->peso_porcentual_fase;
            $valor_hito = $pesos->peso_porcentual_etapa;
            $valor_hito_proyecto = ($valor_etapa/100)*$valor_hito;

            if($request->unidad_medida == 1){
                $peso_actividad_hito = $request->cantidad;
                $peso_actividad_proyecto = ($valor_hito_proyecto/100)*$request->cantidad;
            }else{
                $peso_actividad_proyecto = $request->cantidad;

                if ($valor_hito_proyecto < $peso_actividad_proyecto) {
                    $rules['peso_hito'] = 'required';
                    $messages['peso_hito.required'] ='El peso porcentual asignado a la actividad sobre el proyecto supera el peso porcentual del hito sobre el proyecto';
                    $this->validate($request, $rules, $messages);
                }else{
                    $peso_actividad_hito = ($request->cantidad/$valor_hito_proyecto)*100;
                }
            }
        }

        $consulta = fases_actividades::where('id_fase_plan',$request->id_fase_plan)
        ->select(DB::raw('sum(peso_porcentual_hito) AS valor'))
        ->whereNull('deleted_at')
        ->first();

        $valor_porcentual = $consulta->valor;

        $fases_actividades = fases_actividades::find($request->id_fases_actividades);

        if ($fases_actividades == null) {
           $nuevo_valor_porcentual = $valor_porcentual + $peso_actividad_hito;
        }else {

            $fases_actividades_planes = fases_actividades_planeacion::where('id_fase_actividad','=',$request->id_fases_actividades)
            ->whereNull('fases_actividades_planeacion.deleted_at')
            ->get();  

            if (count($fases_actividades_planes) > 0 && isset($fases_actividades_planes[0])) {
                $fechaInicialReg = $fases_actividades->fecha_inicio;
                $fechaFinalReg = $fases_actividades->fecha_fin;

                if ($fechaInicialReg < $request->fecha_inicio) {
                    $rules['validation_date'] = 'required';
                    $messages['validation_date.required'] ='La actividad ya tiene registrada una programación y su fecha inicial '.$fechaInicialReg.' no puede ser adelantada ya que se ocasionaria conflictos.';        
                }

                if ($fechaFinalReg > $request->fecha_fin) {
                    $rules['validation_date'] = 'required';
                    $messages['validation_date.required'] ='La actividad ya tiene registrada una programación y su fecha final '.$fechaFinalReg.' no puede ser atrasada ya que se ocasionaria conflictos.';        
                }

                $this->validate($request, $rules, $messages);
            }

            $nuevo_valor_porcentual = ($valor_porcentual - $fases_actividades->peso_porcentual_hito) + $peso_actividad_hito;
        }
        
        if(round($nuevo_valor_porcentual,0) > 100)
        {
            $rules['nuevo_valor_porcentual'] = 'required';
            $messages['nuevo_valor_porcentual.required'] ='El valor porcentual supera el total del porcentaje permitido en el hito.';        
        }
        
        //Busca si existe un orden igual en diferente actividad
        $fases_actividades_orden = fases_actividades::where([['id_fase_plan','=',$request->id_fase_plan],
                                                        ['orden','=',$request->orden],
                                                        ['id','<>',$request->id_fases_actividades]])
        ->get();

        if ($fases_actividades_orden->count() >0)
        {
            $rules['orden_1'] = 'required';
            $messages['orden_1.required'] ='Ya existe ese orden .';
        }

        $fases_actividades_nombre = fases_actividades::where([['id_fase_plan','=',$request->id_fase_plan],
                                                        ['nombre_actividad','=',$request->nombre_actividad],
                                                        ['id','<>',$request->id_fases_actividades]])
        ->get();

      
        $fases_actividades_planes = fases_actividades_planeacion::where('id_fase_actividad','=',$request->id_fases_actividades)
        ->whereNull('fases_actividades_planeacion.deleted_at')
        ->get();    
       
        if ($fases_actividades_nombre->count() >0)
        {
            $rules['orden_1'] = 'required';
            $messages['orden_1.required'] ='Ya existe ese nombre .';
        }
        
        
        if ($request->fecha_inicio > $request->fecha_fin) {
            $rules['fecha_expedicion_2'] = 'required';
            $messages['fecha_expedicion_2.required'] ='Por favor validar que la fecha de inicio  sea inferior a la fecha fin.';
        }

        if ($request->fecha_inicio < $request->fecha_inicial_fase)
        {
            $rules['fecha_inicio_3'] = 'required';
            $messages['fecha_inicio_3.required'] ='Por favor validar que la fecha inicial no sea menor a fecha inicial de la etapa.';
        }
         if ($request->fecha_inicio >  $request->fecha_final_fase)
        {
            $rules['fecha_inicio_4'] = 'required';
            $messages['fecha_inicio_4.required'] ='Por favor validar que la fecha inicial no sea mayor a fecha final de la etapa.';
        }

        if ($request->fecha_fin < $request->fecha_inicial_fase)
        {
            $rules['fecha_inicio_5'] = 'required';
            $messages['fecha_inicio_5.required'] ='Por favor validar que la fecha final no sea menor a fecha inicial de la etapa.';
        }
        if ($request->fecha_fin >  $request->fecha_final_fase)
        {
            $rules['fecha_inicio_6'] = 'required';
            $messages['fecha_inicio_6.required'] ='Por favor validar que la fecha final no sea mayor a fecha final de la etapa.';
        }

        $this->validate($request, $rules, $messages);

        if($fases_actividades != null )
        {
            $desde = $request->fecha_inicio;
            $hasta = $request->fecha_fin;
            $id_actividad = $request->id_fases_actividades;

            $semanas_parametrica = semanas_parametrica::where('fecha_fin','>=',$desde)
            ->where('fecha_inicial','<=',$hasta)
            ->select('id')
            ->orderby('fecha_inicial')
            ->get();

            if (isset($semanas_parametrica)) {
               foreach ($semanas_parametrica as $value) {
                    $id_semana = $value->id;

                    $semana = fases_actividades_planeacion::where('id_fase_actividad',$id_actividad)
                    ->where('id_semana_parametrica', $id_semana)
                    ->whereNull('fases_actividades_planeacion.deleted_at')
                    ->first();

                    if(!isset($semana) && $semana == null){

                        $fases_actividades_planeacion  = new fases_actividades_planeacion();
                        $fases_actividades_planeacion->id_fase_actividad  = $id_actividad;
                        $fases_actividades_planeacion->id_semana_parametrica =$id_semana;
                        $fases_actividades_planeacion->programado = 0;
                        $fases_actividades_planeacion->porcentaje_programado = 0;
                        $fases_actividades_planeacion->acumulado_programado =  0;
                        $fases_actividades_planeacion->created_by = Auth::user()->id;
                        $fases_actividades_planeacion->save();     
                    }
               }
            }  
        }

       

        if($fases_actividades  == null )
        {
            if(isset($request->id_fases_actividades_crear) &&  $request->id_fases_actividades_crear == 1)
            {
             $fases_actividades  = new fases_actividades();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $fases_actividades;
                return response()->json($respuesta);
            }
        }

        $fases_actividades->id_fase_plan  = $request->id_fase_plan;
        $fases_actividades->orden = $request->orden;
        $fases_actividades->nombre_actividad = $request->nombre_actividad;
        $fases_actividades->fecha_inicio = $request->fecha_inicio;
        $fases_actividades->fecha_fin = $request->fecha_fin;
        $fases_actividades->peso_porcentual_hito = $peso_actividad_hito;
        $fases_actividades->peso_porcentual_proyecto = $peso_actividad_proyecto;
        $fases_actividades->param_tipo_unidad_medida_valor  = $request->unidad_medida;
        if($request->unidad_medida == 1){
            $fases_actividades->param_tipo_unidad_medida_texto  = 'Peso porcentual en el hito';
        }else{
            $fases_actividades->param_tipo_unidad_medida_texto  = 'Peso porcentual en el proyecto';
        }
        $fases_actividades->param_tipo_caracteristica_actividad_valor = $request->caracteristica_actividad;
        $fases_actividades->param_tipo_caracteristica_actividad_texto = Parametricas::getTextFromValue('tecnico.fases.actividad_caracteristicas', $request->caracteristica_actividad);
        $fases_actividades->vinculo_documento  = $request->vinculo_documentos;
        
         if($request->id_fases_actividades==0)
         {
             $fases_actividades->created_by = Auth::user()->id;
         }else {
             $fases_actividades->updated_by = Auth::user()->id;
         }
         $fases_actividades->save();

         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $fases_actividades;

          return response()->json($respuesta);
    }
    

    public function fases_actividades_get_info(Request $request){
        
        $fases_actividades = fases_actividades::where('id_fase_plan',$request->id_fase_plan)
        ->OrderBy('orden')
        ->get();

        return response()->json($fases_actividades);
    }

    public function delete_fases_actividades(Request $request)
        {
            $relacion = fases_actividades::find($request->id_fases_actividades);
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
