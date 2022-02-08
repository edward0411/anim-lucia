<?php

namespace App\Http\Controllers;


use App\Models\Parametricas;
use App\Models\Proyectos as proyectos;
use App\Models\Calidad_seguridad_industriales as calidad_seguridad_industriales;
use App\Models\Fases as fases;
use App\User as users;
use App\Models\Calidad_seguridad_industrial_inspeccion_ensayos as calidad_seguridad_industrial_inspeccion_ensayos;
use App\Models\Calidad_seguridad_industrial_equipos_obras as calidad_seguridad_industrial_equipos_obras;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GestionCalidadSeguridadIndustrialController extends Controller
{
    //

    public function index(){
        $calidad_seguridad_industriales = calidad_seguridad_industriales::where('proyectos_personas.id_usuario','=',Auth::user()->id)
         ->join('proyectos','proyectos.id','=','calidad_seguridad_industriales.id_proyecto')
         ->join('proyectos_personas','proyectos.id','=','proyectos_personas.id_proyecto')
         ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','calidad_seguridad_industriales.id_fases_relaciones_contratos')
         ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
         ->select('calidad_seguridad_industriales.fecha_informe','proyectos.nombre_proyecto','contratos.numero_contrato',
            'calidad_seguridad_industriales.id','consecutivo')
            ->wherenull('proyectos_personas.deleted_at')
            ->wherenull('calidad_seguridad_industriales.deleted_at')
            ->wherenull('proyectos.deleted_at')
            ->wherenull('fases_relaciones_contratos.deleted_at')
            ->wherenull('contratos.deleted_at')
        
            ->get();


       
        return view('gestion_calidad_seguridad.index',compact('calidad_seguridad_industriales'));
    }

   

    public function crear_info($id){

         //llenar titulos
         $calidad_seguridad_industriales = calidad_seguridad_industriales::where('calidad_seguridad_industriales.id','=',$id)
         ->join('proyectos','proyectos.id','=','calidad_seguridad_industriales.id_proyecto')
         ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','calidad_seguridad_industriales.id_fases_relaciones_contratos')
         ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
         ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
       
         ->select('calidad_seguridad_industriales.fecha_informe','calidad_seguridad_industriales.id_proyecto','proyectos.nombre_proyecto','contratos.numero_contrato',
          'contratos_fechas.fecha_inicio','calidad_seguridad_industriales.id_fases_relaciones_contratos','consecutivo')
        ->get();
 
        $proyectos = proyectos::Where('proyectos_personas.id_usuario','=',Auth::user()->id)
        ->join('proyectos_personas','proyectos.id','=','proyectos_personas.id_proyecto')
        ->wherenull('proyectos_personas.deleted_at')
        ->wherenull('proyectos.deleted_at')
        ->Select('proyectos.*')
        ->get();
 
         $Contratos = fases::WhereNull('fases_relaciones_contratos.deleted_at')
         ->join('fases_relaciones_contratos','fases.id','=','fases_relaciones_contratos.id_fase')
         ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
         ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
         ->Select('fases.id_proyecto','fases_relaciones_contratos.id as id_fases_relaciones_contratos', 
         'contratos.numero_contrato','contratos_fechas.fecha_inicio')
         ->get();
             
          
        $usuario = new users();
        $usuario->id = Auth::user()->id;
        $usuario->name = Auth::user()->name;
 
  
        
        $tipo_pruebas = parametricas::getFromCategory('GestionCalidad.tipo_prueba');
        $tipo_accidente = parametricas::getFromCategory('GestionCalidad.tipo_accidente');

        $tipo_modulo = 4;
        
        
         return view('gestion_calidad_seguridad.crear_info',compact('id','proyectos','Contratos','calidad_seguridad_industriales','usuario',
                 'tipo_pruebas','tipo_accidente','tipo_modulo'));

        
    }

    public function store(Request $request)
    {
        $calidad_seguridad_industriales = calidad_seguridad_industriales::find($request->id_gestion_calidad);
  
        $fecha_acta_inicio=  date('Y-m-d', strtotime($request->fecha_inicio));

        $fechainforme = date('Y-m-d', strtotime($request->fecha_informe)) ;
       
        if ($fecha_acta_inicio > $fechainforme )
        {
           
            $rules['Fecha_informe_2'] = 'required';
            $messages['Fecha_informe_2.required'] ='La fecha del informe no puede se  inferior a la fecha de inicio del contrato.';
            $this->validate($request, $rules, $messages);
        }
    

        if($calidad_seguridad_industriales  == null )
        {
            if(isset($request->id_gestion_calidad_crear) &&  $request->id_gestion_calidad_crear == 1)
            {
                $calidad_seguridad_industriales  = new calidad_seguridad_industriales();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $calidad_seguridad_industriales;
                return response()->json($respuesta);
            }
        }

        $calidad_seguridad_industriales->id_proyecto = $request->id_proyecto;
        $calidad_seguridad_industriales->id_fases_relaciones_contratos = $request->id_contrato;
        $calidad_seguridad_industriales->id_usuario = $request->id_usuario;
        $calidad_seguridad_industriales->fecha_informe = $request->fecha_informe;
        
         if($request->id_gestion_calidad==0)
         {
             $calidad_seguridad_industriales->created_by = Auth::user()->id;
             $consecutivo = 1;
             $calidad_seguridad_industrialesmax = calidad_seguridad_industriales::select( DB::raw('Max(consecutivo)+1 as consecutivo'))
                                                            ->where('calidad_seguridad_industriales.id_proyecto','=',$request->id_proyecto)
                                                            ->get();
             if ($calidad_seguridad_industrialesmax->Count()>0)
                {
                    $consecutivo=$calidad_seguridad_industrialesmax[0]->consecutivo?? 1;
                }
             $calidad_seguridad_industriales->consecutivo =  $consecutivo;
         }else {
             $calidad_seguridad_industriales->updated_by = Auth::user()->id;
         }
         $calidad_seguridad_industriales->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $calidad_seguridad_industriales;
         $respuesta['id']= $calidad_seguridad_industriales->id;
         $respuesta['consecutivo']= $calidad_seguridad_industriales->consecutivo;

         return response()->json($respuesta);
    }


    public function editar(){

        $proyectos = proyectos::all();

        return view('gestion_calidad_seguridad.editar',compact('proyectos'));
    }
}
