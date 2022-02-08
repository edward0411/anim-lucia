<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyectos as proyectos;
use App\Models\Gestiones_sociales as gestiones_sociales;
use App\Models\Fases as fases;
use App\User as users;
use App\Models\Parametricas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GestionSocialController extends Controller
{
    //
    public function index(){
        $gestiones_sociales = gestiones_sociales::where('proyectos_personas.id_usuario','=',Auth::user()->id)
        ->join('proyectos','proyectos.id','=','gestiones_sociales.id_proyecto')
        ->join('proyectos_personas','proyectos.id','=','proyectos_personas.id_proyecto')
        ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_sociales.id_fases_relaciones_contratos')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->select('gestiones_sociales.fecha_informe','proyectos.nombre_proyecto','contratos.numero_contrato',
           'gestiones_sociales.id','consecutivo')
        ->wherenull('proyectos_personas.deleted_at')
        ->wherenull('gestiones_sociales.deleted_at')
        ->wherenull('proyectos.deleted_at')
        ->wherenull('fases_relaciones_contratos.deleted_at')
        ->wherenull('contratos.deleted_at')
       ->get();

        return view('gestion_social.index',compact('gestiones_sociales'));
    }

    public function crear(){
          
          $proyectos = proyectos::all();


        return view('gestion_social.crear',compact('proyectos'));
    }

    public function crear_info($id){

     
        $gestiones_sociales = gestiones_sociales::where('gestiones_sociales.id','=',$id)
        ->join('proyectos','proyectos.id','=','gestiones_sociales.id_proyecto')
        ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_sociales.id_fases_relaciones_contratos')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
        ->select('gestiones_sociales.fecha_informe','gestiones_sociales.id_proyecto','proyectos.nombre_proyecto','contratos.numero_contrato',
         'contratos_fechas.fecha_inicio','gestiones_sociales.id_fases_relaciones_contratos','consecutivo')
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

        $tipo_modulo = 2;

        $caracteristicas = parametricas::getFromCategory('gestionesSocial.caracteristicas')->sortBy('texto');

        return view('gestion_social.crear_info',compact('gestiones_sociales','proyectos','Contratos','usuario','id','caracteristicas','tipo_modulo'));
    }

    public function editar(){
          
          $proyectos = proyectos::all();


        return view('gestion_social.editar',compact('proyectos'));
    }

    public function store(Request $request)
    {
        $gestiones_sociales = gestiones_sociales::find($request->id_gestiones_sociales);
  
        $fecha_acta_inicio=  date('Y-m-d', strtotime($request->fecha_inicio));

        $fechainforme = date('Y-m-d', strtotime($request->fecha_informe)) ;
        
        if ($fecha_acta_inicio > $fechainforme)
        {
           
            $rules['Fecha_informe_2'] = 'required';
            $messages['Fecha_informe_2.required'] ='La fecha del informe no puede se  inferior a la fecha de inicio del contrato.';
            $this->validate($request, $rules, $messages);
        }
    

        if($gestiones_sociales  == null )
        {
            if(isset($request->id_gestiones_sociales_crear) &&  $request->id_gestiones_sociales_crear == 1)
            {
                $gestiones_sociales  = new gestiones_sociales();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $gestiones_sociales;
                return response()->json($respuesta);
            }
        }

        $gestiones_sociales->id_proyecto = $request->id_proyecto;
        $gestiones_sociales->id_fases_relaciones_contratos = $request->id_contrato;
        $gestiones_sociales->id_usuario = $request->id_usuario;
        $gestiones_sociales->fecha_informe = $request->fecha_informe;
        
         if($request->id_gestiones_sociales==0)
         {
             $gestiones_sociales->created_by = Auth::user()->id;
             $consecutivo = 1;
             $gestiones_socialesMax = gestiones_sociales::select( DB::raw('Max(consecutivo)+1 as consecutivo'))
                                                                ->where('gestiones_sociales.id_proyecto','=',$request->id_proyecto)
                                                                ->get();
             if ($gestiones_socialesMax->Count()>0)
                {
                    $consecutivo=$gestiones_socialesMax[0]->consecutivo?? 1;
                }
             $gestiones_sociales->consecutivo =  $consecutivo;
         }else {
             $gestiones_sociales->updated_by = Auth::user()->id;
         }
         $gestiones_sociales->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $gestiones_sociales;
         $respuesta['id']= $gestiones_sociales->id;
         $respuesta['consecutivo']= $gestiones_sociales->consecutivo;

         return response()->json($respuesta);
    }
}
