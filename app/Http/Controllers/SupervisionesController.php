<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contratos as contratos;
use App\Models\Contratos_fechas as contratos_fechas;
use App\Models\Contratos_otrosi as contratos_otrosi;
use App\Models\Contratos_supervisores as contratos_supervisores;
use App\User as users;
use App\Models\Parametricas as parametricas;
use App\Models\supervisiones as supervisiones;
use App\Models\Rps_cuentas as rps_cuentas;
use App\Models\Contratos_polizas as contratos_polizas;
use App\Models\supervision_seguimiento_tecnicos as supervision_seguimiento_tecnicos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SupervisionesController extends Controller
{
    //
    public function index(){

        $supervisiones = DB::select('call usp_supervisiones_consulta_index()');
       
        return view('supervisiones.index',compact('supervisiones'));
    }

    public function crear(){

        $convenios = contratos::WhereIn('param_valor_tipo_contrato', ['1','3'])
        ->Select('id','numero_contrato')->get();

        $usuarios = contratos_supervisores::Join('terceros','contratos_supervisores.id_terecero','=','terceros.id')
        ->select('contratos_supervisores.id_contrato','terceros.id','terceros.nombre','contratos_supervisores.id_tipo_supervisor')->distinct()
        ->where('contratos_supervisores.estado','=',1)
        ->get();

        $cargos = parametricas::getFromCategory('tecnico.proyectos.roles');

        return view('supervisiones.crear',compact('convenios','usuarios','cargos'));
    }

    public function store(Request $request){
       
        $supervisiones = supervisiones::find($request->id_supervicion);
        
        $fecha_Contrato = contratos_fechas::where('id_contrato',$request->id_contrato)->get();
        
        if ($fecha_Contrato->count() >0)
        {
                $fecha_acta_inicio=  $fecha_Contrato[0]->fecha_inicio;
                $fecha_terminacion_actual=  $fecha_Contrato[0]->fecha_terminacion_actual;   
        }
        else{
            return Redirect::back()->withInput()->withErrors(["Fecha informe" => "Por favor revisar las fechas del contrato"]);
            
        }


        $fechainforme = date('Y-m-d', strtotime($request->fecha_informe)) ;
        
        $fechaDelegacion = date('Y-m-d', strtotime($request->fecha_delegación_supervisión)) ;
        
        if ($fechainforme <$fecha_acta_inicio &&  $fecha_acta_inicio<>null )
        {
            return Redirect::back()->withInput()->withErrors(["Fecha informe" => "La fecha del informe no puede ser inferior a la fecha de suscripción del contrato"]);
        }

        if ($fechaDelegacion < $fecha_acta_inicio && $fecha_acta_inicio<>null)
        {
            return Redirect::back()->withInput()->withErrors(["La fecha de delegación" => "La fecha de delegación no puede ser inferior a la fecha de suscripción del contrato"]);
        }

        if ($fechaDelegacion>$fecha_terminacion_actual && $fecha_terminacion_actual <>null)
        {
            return Redirect::back()->withInput()->withErrors(["La fecha de delegación" => "La fecha de delegación no puede ser superior a la fecha de terminación del contrato"]);
        }
    
       
        if ($request->fecha_informe < $request->fecha_delegación_supervisión)
        {
            return Redirect::back()->withInput()->withErrors(["La fecha de delegación" => "La fecha de delegación no puede ser mayor a la fecha del informe"]);
        }

        if ($request->id_usuario==null)
        {
           

            return Redirect::back()->withInput()->withErrors(["Supervisor" => "Debe seleccionar el supervisor de la lista."]);
        }
        

        if($supervisiones  == null )
        {
            if(isset($request->id_supervicion_crear) &&  $request->id_supervicion_crear == 1)
            {
             $supervisiones  = new supervisiones();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $supervisiones ;
                return response()->json($respuesta);
            }
        }
 
         $supervisiones->id_contrato   = $request->id_contrato;
         $supervisiones->fecha_informe  = $request->fecha_informe;
        
         $supervisiones->id_tercero_supervisor  = $request->id_usuario;
         $supervisiones->param_rol_valor = $request->id_cargo;
         $supervisiones->param_rol_texto = Parametricas::getTextFromValue('tecnico.proyectos.roles', $request->id_cargo);
         $supervisiones->fecha_delegación_supervisión = $request->fecha_delegación_supervisión;
         $supervisiones->id_tercero_apoyoSupervision  = $request->id_usuario_apoyoSupervision;
         $supervisiones->param_rol_valor_apoyoSupervision = $request->id_cargoapoyoSupervision;
         $supervisiones->param_rol_texto_apoyoSupervision = Parametricas::getTextFromValue('tecnico.proyectos.roles', $request->id_cargoapoyoSupervision);

        
         if($request->id_proyecto_licencia==0)
         {
             $supervisiones->created_by = Auth::user()->id;
             $consecutivo = 1;
             $supervisionesMax = supervisiones::select( DB::raw('Max(numero_informe)+1 as consecutivo'))
                                        ->where('id_contrato','=',$request->id_contrato)->get();
           
              
             if ($supervisionesMax->Count()>0)
                {
                    $consecutivo=$supervisionesMax[0]->consecutivo?? 1;
                }
              
             $supervisiones->numero_informe =  $consecutivo;
         }else {
             $supervisiones->updated_by = Auth::user()->id;
         }
         $supervisiones->save();


       /*  $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= $supervisiones;

         return response()->json($respuesta);*/
        $id_supervicion = $supervisiones->id;
        return redirect()->route('supervisiones.crear_info',$id_supervicion);

    }

    public function crear_info($id){
        $informacionGeneral = DB::select('call usp_supervision_consulta_informacionGeneral(?)',array($id));
        

        $formas_pago = parametricas::getFromCategory('supervisiones.forma_pago');
      
        //Informacion Ejecución Financiera
       
            $informacionFinanciera = contratos::where('contratos.id',$informacionGeneral[0]->id_contrato)
            ->whereNull('coo.deleted_at')
            ->leftjoin('contratos_otrosi as coo','contratos.id','=','coo.id_contrato')
            ->leftjoin('contratos_fechas','contratos.id','=','contratos_fechas.id_contrato')
            ->groupby('contratos.valor_contrato','contratos_fechas.fecha_terminacion_actual')
            ->select(DB::raw("sum(case when coo.valor_adicion>0 then coo.valor_adicion else 0 end) as adicion"), 
                    DB::raw("sum(case when coo.valor_adicion<0 then coo.valor_adicion else 0 end) as disminucion"), 
                        DB::raw('contratos.valor_contrato'),
                        DB::raw('contratos_fechas.fecha_terminacion_actual'))
            ->get();
        
            
            $informacionFinancieraPagos = rps_cuentas::join('rps','rps.id','=','rps_cuentas.id_rp')
            ->join('obl_operaciones','rps_cuentas.id','=','obl_operaciones.id_rp_cuenta')
            ->where([['rps.id_contrato',$informacionGeneral[0]->id_contrato],
                        ['obl_operaciones.param_estado_obl_operacion_valor','=',1]])
            ->select('fecha_obl_operacion','valor_operacion_obl','rps.id_contrato')
            ->get();
            

                $contratos_otrosi = contratos_otrosi::where('contratos_otrosi.id_contrato','=',$informacionGeneral[0]->id_contrato)
                ->whereNull('contratos_otrosi.deleted_at')
                ->select("numero_otrosi",
                DB::raw("case when es_adicion then 'Adicion' else '' end as adicion ") ,
                DB::raw("case when es_prorroga then 'prorroga' else '' end prorroga ") ,
                DB::raw('case when es_obligacion  then "obligacion" else "" end obligacion'), 
                DB::raw('case when es_suspension then "suspension" else "" end suspension') ,
                DB::raw('case when es_cesion then "cesio" else "" end cesio') ,
                'fecha_firma','meses','dias','valor_adicion','detalle_modificacion')
                ->get();

                $contratos_polizas = contratos_polizas::where('contratos_polizas.id_contrato','=',$informacionGeneral[0]->id_contrato)
                ->leftJoin('contratos_polizas_amparos','contratos_polizas.id','=','contratos_polizas_amparos.id_contratos_polizas')
                ->select('contratos_polizas.id','numero_poliza','fecha_aprobacion','aseguradora','amparos','desde','hasta' )
                ->get();

       
        
        $tipo_modulo = 1;
      

        return view('supervisiones.crear_info',compact('id','informacionGeneral','formas_pago','informacionFinanciera',
        'informacionFinancieraPagos','contratos_otrosi','contratos_polizas','tipo_modulo'));
    }

    public function editar($id){

       
        $convenios = contratos::Where('param_valor_tipo_contrato', '1')
        ->Select('id','numero_contrato')->get();

        $usuarios = contratos_supervisores::Join('terceros','contratos_supervisores.id_terecero','=','terceros.id')
        ->select('contratos_supervisores.id_contrato','terceros.id','terceros.nombre','contratos_supervisores.id_tipo_supervisor')
        ->get();

        $cargos = parametricas::getFromCategory('tecnico.proyectos.roles');

        $supervision = supervisiones::Where('supervisiones.id',$id)
        ->join('contratos','contratos.id','=','supervisiones.id_contrato')
        ->join('terceros','terceros.id','=','supervisiones.id_tercero_supervisor')
        ->Select('supervisiones.*','contratos.numero_contrato','terceros.nombre')
        ->get();
      // dd($supervision);

        $usuariosContrato =contratos_supervisores::Join('terceros','contratos_supervisores.id_terecero','=','terceros.id')
        ->where('contratos_supervisores.id_contrato','=',$supervision[0]->id_contrato)
        ->select('contratos_supervisores.id_contrato','terceros.id','terceros.nombre','contratos_supervisores.id_tipo_supervisor')
        ->get();
       

        return view('supervisiones.editar',compact('convenios','usuarios','cargos','supervision','usuariosContrato'));


    }

  /*public function editar_pago(Request $request){
        
        $supervision = supervisiones::find($request->id_supervision);
      
        $supervision->forma_pago  = $request->forma_pago;
       // $supervision->param_forma_pago_texto  = Parametricas::getTextFromValue('supervisiones.forma_pago', $request->id_forma_pago);
        $supervision->updated_by = Auth::user()->id;
        $supervision->save();
       
        
        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la caracteristica";
        $respuesta['objeto']= $supervision;

        return response()->json($respuesta);
        
    }

    public function editar_incumplimiento(Request $request){
        
        $supervision = supervisiones::find($request->id_supervision_incumplimiento);
        if (request()->input('declarar_incumplimiento')=='1')
       
        {
            $supervision->declarar_incumplimiento  = 1;
        }
        else
        {
            $supervision->declarar_incumplimiento  = 0;
        }
        $supervision->vinculo  =  $request->vinculo;
        $supervision->observaciones_incumplimiento  =  $request->observaciones_incumplimiento;
        $supervision->updated_by = Auth::user()->id;
        $supervision->save();
       
        
        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la caracteristica";
        $respuesta['objeto']= $supervision;

        return response()->json($respuesta);
        
    }*/
}
