<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyectos_licencias as proyecto_licencia;
use App\Models\Proyectos_licencias_modalidades as proyecto_licencia_modalidades;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class ProyectosLicenciasController extends Controller
{
    //
    public function licencias_store(Request $request){  
        
        //dd($request);

        $licencia_proyecto = proyecto_licencia::find($request->id_proyecto_licencia);

        if ($request->id_tercero==null)
        {
            $rules['responsable_1'] = 'required';
            $messages['responsable_1.required'] ='Debe seleccionar el responsable de la lista.';
                      
            $this->validate($request, $rules, $messages);
        }


        if ($request->chk_licencia == 1) {

            $rules = [
                'fecha_radicacion' => 'required',

            ];
            $messages = [
                'fecha_radicacion.required' => 'Favor asigne una fecha de radicación',

            ];

           
            if ($request->fecha_radicacion > $request->fecha_expedicion && !empty($request->fecha_expedicion)) {
                $rules['fecha_expedicion_2'] = 'required';
                $messages['fecha_expedicion_2.required'] ='Por favor validar que la fecha de radicación sea inferior a la fecha de expedición.';
            }
            
            $this->validate($request, $rules, $messages);
        }else if($request->chk_licencia == 2){
            $rules = [
                'fecha_radicacion' => 'required',
                'fecha_terminacion' => 'required',
                'fecha_expedicion' => 'required',
                'fecha_vencimiento' => 'required',
            ];
            $messages = [
                'fecha_radicacion.required' => 'Favor asigne una fecha de radicación',
                'fecha_terminacion.required' => 'Favor asigne una fecha de terminación',
                'fecha_expedicion.required' => 'Favor asigne una fecha de expedión',
                'fecha_vencimiento.required' => 'Favor asigne una fecha de vencimiento',

            ];

            if ($request->fecha_radicacion > $request->fecha_expedicion) {
                $rules['fecha_expedicion_2'] = 'required';
                $messages['fecha_expedicion_2.required'] ='Por favor validar que la fecha de radicación sea inferior a la fecha de expedición.';
            }
            if ($request->fecha_terminacion < $request->fecha_expedicion) {
                $rules['fecha_expedicion_3'] = 'required';
                $messages['fecha_expedicion_3.required'] ='Por favor validar que la fecha de terminación no sea inferior a la fecha de expedición.';
            }
            if ($request->fecha_vencimiento < $request->fecha_expedicion) {
                $rules['fecha_expedicion_4'] = 'required';
                $messages['fecha_expedicion_4.required'] ='Por favor validar que la fecha de vencimiento no sea inferior a la fecha de expedición.';
            }
            if ($request->fecha_ejecutoria < $request->fecha_expedicion) {
                $rules['fecha_expedicion_4'] = 'required';
                $messages['fecha_expedicion_4.required'] ='Por favor validar que la fecha de ejecutoría no sea inferior a la fecha de expedición.';
            }
            if ($request->fecha_ejecutoria > $request->fecha_vencimiento) {
                $rules['fecha_expedicion_4'] = 'required';
                $messages['fecha_expedicion_4.required'] ='Por favor validar que la fecha de ejecutoría no sea mayor a la fecha de vecimiento.';
            }
           
            $this->validate($request, $rules, $messages);
        }

       


        

        if($licencia_proyecto  == null )
        {
            if(isset($request->id_proyecto_licencia_crear) &&  $request->id_proyecto_licencia_crear == 1)
            {
             $licencia_proyecto  = new proyecto_licencia();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $licencia_proyecto ;
                return response()->json($respuesta);
            }
        }

         $licencia_proyecto->id_proyecto  = $request->licencias_id_proyecto;
         $licencia_proyecto->id_tercero  = $request->id_tercero;
         $licencia_proyecto->param_tipo_licencia_valor  = $request->licencia;
         $licencia_proyecto->param_tipo_licencia_texto = Parametricas::getTextFromValue('tecnicos.proyectos.licencias_proyecto', $request->licencia);
         /*$licencia_proyecto->param_tipo_modalidad_valor = $request->modalidad;
         $licencia_proyecto->param_tipo_modalidad_texto = Parametricas::getTextFromValue('tecnico.proyectos.modalidad', $request->modalidad);*/
         $licencia_proyecto->fecha_expedicion = $request->fecha_expedicion;
         if($request->chk_licencia == 2){
            $licencia_proyecto->fecha_terminacion = $request->fecha_terminacion;
            $licencia_proyecto->fecha_vencimiento = $request->fecha_vencimiento;
         }
         $licencia_proyecto->fecha_radicacion = $request->fecha_radicacion;
         $licencia_proyecto->param_tipo_tramite_valor = $request->tipo_tramite;
         $licencia_proyecto->param_tipo_tramite_texto = Parametricas::getTextFromValue('tecnico.proyectos.tipo_tramite', $request->tipo_tramite);
         $licencia_proyecto->otro_responsable = $request->otro_responsable;
         $licencia_proyecto->correo_electronico = $request->correo_electronico;
         $licencia_proyecto->vinculo = $request->vinculo;
         $licencia_proyecto->observaciones = $request->observaciones;
         $licencia_proyecto->fecha_ejecutoria = $request->fecha_ejecutoria;
         $licencia_proyecto->acto_administrativo = $request->acto_administrativo;
         if($request->chk_licencia == 1){
            $licencia_proyecto->estado = 1;
         }else{
            $licencia_proyecto->estado = 2;
         }
         if($request->id_proyecto_licencia==0)
         {
             $licencia_proyecto->created_by = Auth::user()->id;
         }else {
             $licencia_proyecto->updated_by = Auth::user()->id;
         }
         $licencia_proyecto->save();
         
         $consulta_modalidades = proyecto_licencia_modalidades::where('id_proyecto_licencia',$licencia_proyecto->id)->get();
         
         $count = count($consulta_modalidades);
         
         if($count > 0)
         {
             foreach($consulta_modalidades as $item)
             {
                 $item->delete();
             }
             
         }
         
         foreach($request->modalidad as $value)
         {
             
             $registro = new proyecto_licencia_modalidades();
             $registro->id_proyecto_licencia = $licencia_proyecto->id;
             $registro->param_tipo_modalidad_valor = $value;
             $registro->param_tipo_modalidad_texto = Parametricas::getTextFromValue('tecnico.proyectos.modalidad', $value);
             $registro->created_by = Auth::user()->id;
             $registro->save();
             
         }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $licencia_proyecto;

          return response()->json($respuesta);

    }

    public function licencias_get_info(Request $request){

        $licencias = proyecto_licencia::where('id_proyecto',$request->id_proyecto)
                                ->where('parametricas.categoria','tecnico.proyectos.licencia_estado')
        ->join('terceros','proyectos_licencias.id_tercero','=','terceros.id')
        ->join('parametricas','parametricas.valor','=','proyectos_licencias.estado')
        ->Select('proyectos_licencias.*','terceros.nombre','parametricas.texto')
        ->get();
        
        $modalidades = [];
        
        foreach($licencias as $licencia)
        {
            $id_licencia = $licencia->id;
            $consulta = proyecto_licencia_modalidades::where('id_proyecto_licencia',$licencia->id)->select('param_tipo_modalidad_texto','param_tipo_modalidad_valor')->get();
            $datos = $consulta->toArray();
            $licencia->modalidades = $datos;      
        }

        return response()->json($licencias);

    }

    public function delete_licencias(Request $request)
        {
            $relacion = proyecto_licencia::find($request->id_proyecto_licencia);
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
