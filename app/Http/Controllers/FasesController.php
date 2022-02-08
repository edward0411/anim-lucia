<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Proyectos as proyectos;
use App\Models\Fases as fases;
use App\Models\Contratos as contratos;
use App\Models\Contratos_terceros as contratos_tercero;
use App\Models\Proyecto_convenios as proyectos_convenios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FasesController extends Controller
{
    //

    public function index(){

        return view('fases.index');
    }

    public function crear($id ){
      
        $proyecto = proyectos::find($id);
       
  
        $fases_etapas = parametricas::Where('categoria', 'tecnico.proyectos.etapa')
        ->where('categoria_padre','tecnico.proyectos.tipo_proyectos')
        ->where('valor_padre',$proyecto->param_tipo_proyecto_valor)
        ->orderBy('orden')
        ->select('valor', 'texto' )
        ->get();

        $frecuencias =  Parametricas::getFromCategory('tecnico.proyectos.tipo_proyectos.frecuenciaRegistro');
      
       
        $contratos = proyectos_convenios::where('proyectos_convenios.id_proyecto',$id)
        ->join('contratos_pads_convenios','contratos_pads_convenios.id_contrato_convenio','=','proyectos_convenios.id_contrato')
        ->join('patrimonios','contratos_pads_convenios.id_contrato_pad','=','patrimonios.id_contrato_pad')
        ->join('patrimonio_cuentas','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->join('cdrs_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
        ->join('cdrs','cdrs_cuentas.id_cdr','=','cdrs.id')
        ->join('contratos as cc','cdrs.id','=','cc.id_cdr')
        ->select('cc.id','cc.numero_contrato')
        ->distinct()
        ->get();

        foreach ( $contratos as  $value) {
            $id_contrato = $value->id;
 
            $relacion = contratos_tercero::where('id_contrato', $id_contrato)->first();

            if($relacion == null){
                $value->tercero = null;
            }else{
                $tercero = $relacion->Tercero()->select('nombre')->first();
                $value->tercero = $tercero->nombre;
            }
         }


        /*SSELECT distinct cc.numero_contrato,cc.id,cdrs.* FROM 
        contratos 
        Inner join contratos_pads_convenios on contratos.id = contratos_pads_convenios.id_contrato_convenio
        Inner join patrimonios on contratos_pads_convenios.id_contrato_pad= patrimonios.id_contrato_pad
        Inner join patrimonio_cuentas on patrimonios.id = patrimonio_cuentas.id_patrimonio
        Inner join cdrs_cuentas on patrimonio_cuentas.id = cdrs_cuentas.id_cuenta
        Inner join cdrs on cdrs_cuentas.id_cdr = cdrs.id
        Inner join contratos cc on cdrs.id = cc.id_cdr
        
        Where contratos.id =199*/
       
   
        $fechasConvenio = proyectos_convenios::Where('id_proyecto',$id)
        ->whereNull('proyectos_convenios.deleted_at')
        ->join('contratos_fechas as feco','proyectos_convenios.id_contrato','=','feco.id_contrato')
        ->select(DB::raw("Min(feco.fecha_firma) as fecha_inicial"), 
                    DB::raw("Max(feco.fecha_terminacion_actual) as fecha_final"))
        ->get();
        
        $id_fase = 0;

        return view('fases.crear',compact('fases_etapas','proyecto','contratos','id_fase','fechasConvenio','frecuencias'));
    }

    public function editar(Request $request){
       
        $id_fase = $request->id_fase_P;
      
        $frecuencias =  Parametricas::getFromCategory('tecnico.proyectos.tipo_proyectos.frecuenciaRegistro');
       
        $fase = fases::where('id',$id_fase)
        ->get();

        $proyecto = proyectos::find($fase[0]->id_proyecto);

        $fases_etapas = parametricas::Where('categoria', 'tecnico.proyectos.etapa')
        ->where('categoria_padre','tecnico.proyectos.tipo_proyectos')
        ->where('valor_padre',$proyecto->param_tipo_proyecto_valor)
        ->orderBy('orden')
        ->select('valor', 'texto' )
        ->get();


        $contratos = proyectos_convenios::where('proyectos_convenios.id_proyecto',$fase[0]->id_proyecto)
        ->join('contratos_pads_convenios','contratos_pads_convenios.id_contrato_convenio','=','proyectos_convenios.id_contrato')
        ->join('patrimonios','contratos_pads_convenios.id_contrato_pad','=','patrimonios.id_contrato_pad')
        ->join('patrimonio_cuentas','patrimonios.id','=','patrimonio_cuentas.id_patrimonio')
        ->join('cdrs_cuentas','patrimonio_cuentas.id','=','cdrs_cuentas.id_cuenta')
        ->join('cdrs','cdrs_cuentas.id_cdr','=','cdrs.id')
        ->join('contratos as cc','cdrs.id','=','cc.id_cdr')
        ->select('cc.id','cc.numero_contrato')
        ->distinct()
        ->get();

        foreach ( $contratos as  $value) {
            $id_contrato = $value->id;
 
            $relacion = contratos_tercero::where('id_contrato', $id_contrato)->first();

            if($relacion == null){
                $value->tercero = null;
            }else{
                $tercero = $relacion->Tercero()->select('nombre')->first();
                $value->tercero = $tercero->nombre;
            }
         }
       
        $proyecto = proyectos::find($fase[0]->id_proyecto);
       
        $fechasConvenio = proyectos_convenios::Where('id_proyecto',$fase[0]->id_proyecto)
        ->whereNull('proyectos_convenios.deleted_at')
        ->join('contratos_fechas as feco','proyectos_convenios.id_contrato','=','feco.id_contrato')
        ->select(DB::raw("Min(feco.fecha_firma) as fecha_inicial"), 
                    DB::raw("Max(feco.fecha_terminacion_actual) as fecha_final"))
        ->get();


        return view('fases.crear',compact('fases_etapas','proyecto','contratos','id_fase','fechasConvenio','frecuencias'));
    }

    public function store(Request $request){


       $consulta = fases::where('id_proyecto',$request->fase_id_proyecto)
       ->select(DB::raw('sum(peso_porcentual_fase) AS valor'))
       ->whereNull('deleted_at')
       ->first();

       $valor_porcentual = $consulta->valor;

       $faseExiste = [];

        $fase = fases::find($request->id_fase);

        if ($fase == null) {

            $faseExiste = fases::Where([['param_tipo_fase_valor',$request->nombre_fase],
            ['id_proyecto',$request->fase_id_proyecto],
            ['id','<>',$request->id_fase]])
            ->get();

           $nuevo_valor_porcentual = $valor_porcentual + $request->valor_porcentual;
        }else {
            $nuevo_valor_porcentual = ($valor_porcentual - $fase->peso_porcentual_fase) + $request->valor_porcentual;
        }

        $rules = [
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ];
        $messages = [
            'fecha_inicio.required' => 'Favor asigne una fecha de inicio',
            'fecha_fin.required' => 'Favor asigne una fecha fin',

        ];

        if ($request->fecha_fin < $request->fecha_inicio) {
            $rules['fecha_inicio_2'] = 'required';
            $messages['fecha_inicio_2.required'] ='Por favor validar que la fecha fin no sea inferior a la fecha inicial.';
        }

        if (count($faseExiste) > 0)
         {
             $rules['ExisteFase'] = 'required';
             $messages['ExisteFase.required'] ='Ya existe la etapa en el proyecto.';
         }

       if ($request->fecha_inicio < $request->fecha_inicial_convenio)
        {
            $rules['fecha_inicio_3'] = 'required';
            $messages['fecha_inicio_3.required'] ='Por favor validar que la fecha inicial no sea menor a la fecha inicial de los convenios.';
        }
         if ($request->fecha_inicio >  $request->fecha_final_convenio && $request->fecha_final_convenio !=null )
        {
            $rules['fecha_inicio_4'] = 'required';
            $messages['fecha_inicio_4.required'] ='Por favor validar que la fecha inicial no sea mayor a la fecha final de los convenios.';
        }

        if ($request->fecha_fin < $request->fecha_inicial_convenio)
        {
            $rules['fecha_inicio_5'] = 'required';
            $messages['fecha_inicio_5.required'] ='Por favor validar que la fecha final no sea menor a la fecha inicial de los convenios.';
        }
        if ($request->fecha_fin >  $request->fecha_final_convenio && $request->fecha_final_convenio !=null)
        {
            $rules['fecha_inicio_6'] = 'required';
            $messages['fecha_inicio_6.required'] ='Por favor validar que la fecha final no sea mayor a la fecha final de los convenios.';
        }

        if($nuevo_valor_porcentual > 100)
        {
            $rules['fecha_inicio_7'] = 'required';
            $messages['fecha_inicio_7.required'] ='El valor porcentual supera el total del porcentaje permitido en la fase.';
        }

        $this->validate($request, $rules, $messages);

        if ($fase == null) {
            if (isset($request->id_fase_crear) && ($request->id_fase_crear == 1)) {
                $fase = new fases();
            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permisos para crear registros nuevos";
                $respuesta['objecto']= $fase;
                return response()->json($respuesta);
           }
        }
        $fase->id_proyecto  = $request->fase_id_proyecto;
        $fase->param_tipo_fase_valor = $request->nombre_fase;
        $fase->param_tipo_fase_texto = Parametricas::getTextFromValue('tecnico.proyectos.etapa', $request->nombre_fase);
        $fase->param_frecuencia_registro_valor =$request->id_frecuencia_registro;
        $fase->param_frecuencia_registro_texto = Parametricas::getTextFromValue('tecnico.proyectos.tipo_proyectos.frecuenciaRegistro', $request->id_frecuencia_registro);;
        $fase->peso_porcentual_fase = $request->valor_porcentual;
        $fase->fecha_inicio= $request->fecha_inicio;
        $fase->fecha_fin= $request->fecha_fin;

        if ($request->id_fase == 0) {
          $fase->created_by = Auth::user()->id;
        }else {
           $fase->updated_by = Auth::user()->id;
        }
        $fase->save();

        $id_fase = $fase->id;


        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la informaci車n de la caracteristica";
        $respuesta['objeto']= $fase;

        return response()->json($respuesta);



    }

    public function fase_get_info(Request $request){
      
        $fase = fases::where('id',$request->id_fase)
        ->get();

        return response()->json($fase);

    }

    public function delete_fase(Request $request)
    {
            $relacion = fases::find($request->id_fase);
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

    public function traer(Request $request){
    
        $fase = fases::where('id_proyecto',$request->id_proyecto)
        ->get();

        return response()->json($fase);

    }

    public function consultar(Request $request){
    
        $fases = DB::select('call usp_proyecto_consultarAvanceFase(?)',array($request->fase_id_proyecto));

        return response()->json($fases);
    }

    public function clonar(Request $request)
    {
        
        //dd($request);
        
        $fase=DB::Select('call usp_clonar_fase(?,?)',array($request->id_fase,Auth::user()->id));
        
        //dd($fase);

        $respuesta['status']="success";
        $respuesta['message']="Se clono con exito";
        $respuesta['objeto']= $fase;

        $id_proyecto = fases::find($request->id_fase)->id_proyecto;
        
        //return "Hola mundo";
        return redirect()->route('proyectos.crear_info',$id_proyecto);

        // return response()->json($respuesta);
        
    }

}
