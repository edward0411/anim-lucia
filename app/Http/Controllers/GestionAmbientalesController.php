<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamentos as departamentos;
use App\Models\Municipios as municipios;
use App\Models\Parametricas;
use App\Models\Proyectos as proyectos;
use App\Models\Fases as fases;
use App\Models\gestiones_ambientales as gestiones_ambientales;
use App\User as users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class GestionAmbientalesController extends Controller
{
    //
     public function index(){
         $gestiones_ambientales = gestiones_ambientales::where('proyectos_personas.id_usuario','=',Auth::user()->id)
         ->join('proyectos','proyectos.id','=','gestiones_ambientales.id_proyecto')
         ->join('proyectos_personas','proyectos.id','=','proyectos_personas.id_proyecto')
         ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_ambientales.id_fases_relaciones_contratos')
         ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
         ->select('gestiones_ambientales.fecha_informe','proyectos.nombre_proyecto','contratos.numero_contrato',
            'gestiones_ambientales.id','consecutivo')
            ->wherenull('proyectos_personas.deleted_at')
            ->wherenull('gestiones_ambientales.deleted_at')
            ->wherenull('proyectos.deleted_at')
            ->wherenull('fases_relaciones_contratos.deleted_at')
            ->wherenull('contratos.deleted_at')
        ->get();
        return view('gestion_ambientales.index',compact('gestiones_ambientales'));

      

    }

    public function crear(){
           
        $proyectos = proyectos::Where('proyectos_personas.id_usuario','=',Auth::user()->id)
        ->join('proyectos_personas','proyectos.id','=','proyectos_personas.id_proyecto')
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
         

        return view('gestion_ambientales.crear',compact('proyectos','Contratos','usuario'));
    }

    public function crear_info($id){

        
        $gestiones_ambientales = gestiones_ambientales::where('gestiones_ambientales.id','=',$id)
        ->join('proyectos','proyectos.id','=','gestiones_ambientales.id_proyecto')
        ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_ambientales.id_fases_relaciones_contratos')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
  
        ->select('gestiones_ambientales.fecha_informe','gestiones_ambientales.id_proyecto','proyectos.nombre_proyecto','contratos.numero_contrato',
         'contratos_fechas.fecha_inicio','gestiones_ambientales.id_fases_relaciones_contratos','consecutivo')
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

       
        $departamentos = departamentos::all()->sortBy('nombre_departamento');
        $municipios= municipios::all()->sortBy('nombre_municipio');
       
        $permisos_ambientales = parametricas::getFromCategory('gestionesAambientales.permisos_ambientales')->sortBy('texto');('texto');
       
        $tipo_modulo = 3;

       

        return view('gestion_ambientales.crear_info',compact('id','proyectos','Contratos','gestiones_ambientales','usuario',
                'departamentos','municipios','permisos_ambientales','tipo_modulo'));

    }

    public function store(Request $request)
    {
        $gestiones_ambientales = gestiones_ambientales::find($request->id_gestion_ambiental);
  
        $fecha_acta_inicio=  date('Y-m-d', strtotime($request->fecha_inicio));

        $fechainforme = date('Y-m-d', strtotime($request->fecha_informe)) ;
        
        if ($fecha_acta_inicio > $fechainforme)
        {
           
            $rules['Fecha_informe_2'] = 'required';
            $messages['Fecha_informe_2.required'] ='La fecha del informe no puede se  inferior a la fecha de inicio del contrato.';
            $this->validate($request, $rules, $messages);
        }
    

        if($gestiones_ambientales  == null )
        {
            if(isset($request->id_gestion_ambiental_crear) &&  $request->id_gestion_ambiental_crear == 1)
            {
                $gestiones_ambientales  = new gestiones_ambientales();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $gestiones_ambientales;
                return response()->json($respuesta);
            }
        }

        $gestiones_ambientales->id_proyecto = $request->id_proyecto;
        $gestiones_ambientales->id_fases_relaciones_contratos = $request->id_contrato;
        $gestiones_ambientales->id_usuario = $request->id_usuario;
        $gestiones_ambientales->fecha_informe = $request->fecha_informe;
        
         if($request->id_gestion_ambiental==0)
         {
             $gestiones_ambientales->created_by = Auth::user()->id;
             $consecutivo = 1;
             $gestiones_ambientalesMax = gestiones_ambientales::select( DB::raw('Max(consecutivo)+1 as consecutivo'))
                                        ->where('gestiones_ambientales.id_proyecto','=',$request->id_proyecto)
                                        ->get();
             if ($gestiones_ambientalesMax->Count()>0)
                {
                    $consecutivo=$gestiones_ambientalesMax[0]->consecutivo ?? 1;
                }
             $gestiones_ambientales->consecutivo =  $consecutivo;
         }else {
             $gestiones_ambientales->updated_by = Auth::user()->id;
         }
         $gestiones_ambientales->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $gestiones_ambientales;
         $respuesta['id']= $gestiones_ambientales->id;
         $respuesta['consecutivo']= $gestiones_ambientales->consecutivo;

         return response()->json($respuesta);
    }

    public function editar($id){
           
        $proyectos = proyectos::all();

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

       $gestiones_ambientales = gestiones_ambientales::where('gestiones_ambientales.id','=',$id)
       ->join('proyectos','proyectos.id','=','gestiones_ambientales.id_proyecto')
       ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_ambientales.id_fases_relaciones_contratos')
       ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
       ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
     
       ->select('gestiones_ambientales.fecha_informe','gestiones_ambientales.id_proyecto','proyectos.nombre_proyecto','contratos.numero_contrato',
        'contratos_fechas.fecha_inicio','gestiones_ambientales.id_fases_relaciones_contratos')
      ->get();
        //dd($gestiones_ambientales);

        return view('gestion_ambientales.editar',compact('proyectos','Contratos','usuario','gestiones_ambientales','id'));
    }

    public function gestion_ambiental_get_info(Request $request){

        $gestiones_ambientales = gestiones_ambientales::where('gestiones_ambientales.id','=',$request->id_gestion_ambiental)
        ->join('proyectos','proyectos.id','=','gestiones_ambientales.id_proyecto')
        ->join('fases_relaciones_contratos','fases_relaciones_contratos.id','=','gestiones_ambientales.id_fases_relaciones_contratos')
        ->join('contratos','fases_relaciones_contratos.id_contrato','=','contratos.id')
        ->leftJoin('contratos_fechas','contratos_fechas.id_contrato','=','contratos.Id')
      
        ->select('gestiones_ambientales.fecha_informe','gestiones_ambientales.id_proyecto','proyectos.nombre_proyecto','contratos.numero_contrato',
         'contratos_fechas.fecha_inicio','gestiones_ambientales.id_fases_relaciones_contratos')
       ->get();

        return response()->json($gestiones_ambientales);

    }
}
