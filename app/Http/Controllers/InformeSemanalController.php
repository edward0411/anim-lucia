<?php

namespace App\Http\Controllers;
use App\Models\Proyectos as proyectos;
use App\Models\Fases as fases;
use App\Models\Fases_actuales as fases_act;
use App\Models\semanas_parametrica as semanas_parametrica;
use App\Models\fases_actividades_planeacion as fases_actividades_planeacion;
use App\Models\Fases_actividades as fases_actividades;
use App\Models\Fases_planes as fases_planes;
use App\Models\Fases_Informe_semanal as fases_Informe_semanal;
use App\Models\Fases_Informe_semanal_bitacora as fases_Informe_semanal_bitacora;
use App\User as users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use Carbon\Carbon;
use Illuminate\Http\Request;

class InformeSemanalController extends Controller
{
    //

    public function index(){

        $user = Auth::user()->id;
        $userb = users::with('roles')->where('id', $user)->first();
        $role= $userb->roles->first()->name;

        $datos = fases::whereNotNull('id_padre')
        ->select('id_padre')
        ->get()
        ->toArray();

        $padres = [];
        
        foreach($datos as $padre){
            array_push($padres,$padre['id_padre']);
        }


        if($role=='Administrador'){

            $proyectos = proyectos::where('proyectos.estado',1)
            ->wherenull('fases.deleted_at')
            ->wherenull('fases_planes.deleted_at')
            ->wherenotnull('porcentaje_programado')
            ->join('fases','proyectos.id','=','fases.id_proyecto')
            ->join('fases_planes','fases.id','=','fases_planes.id_fase')
            ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
            ->join('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
            ->whereNotIn('fases.id',$padres)
            ->select('proyectos.nombre_proyecto','fases.id_proyecto','fases.id as IdFase','fases.param_tipo_fase_texto','fases.id_padre')
            ->orderby('proyectos.nombre_proyecto')
            ->distinct()
            ->get();

            return view('informe_semanal.index',compact('proyectos'));

        }else{

            $proyectos = proyectos::where('proyectos.estado',1)
            ->wherenull('fases.deleted_at')
            ->wherenotnull('porcentaje_programado')
            ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
            ->where('proyectos_personas.id_usuario',$user)
            ->join('fases','proyectos.id','=','fases.id_proyecto')
            ->join('fases_planes','fases.id','=','fases_planes.id_fase')
            ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
            ->join('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
            ->whereNotIn('fases.id',$padres)
            ->select('proyectos.nombre_proyecto','fases.id_proyecto','fases.id as IdFase','fases.param_tipo_fase_texto','fases.id_padre')->Distinct()
            ->orderby('proyectos.nombre_proyecto')
            ->get();

            return view('informe_semanal.index',compact('proyectos'));

        }

        /*$proyectos = proyectos::where('proyectos.estado',1)
        ->wherenull('fases.deleted_at')
        ->wherenotnull('porcentaje_programado')
        ->join('fases','proyectos.id','=','fases.id_proyecto')
        ->join('fases_planes','fases.id','=','fases_planes.id_fase')
        ->join('fases_actividades','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->join('fases_actividades_planeacion','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->select('proyectos.nombre_proyecto','fases.id_proyecto','fases.id as IdFase','fases.param_tipo_fase_texto','fases.id_padre')->Distinct()
        ->orderby('proyectos.nombre_proyecto')
        ->get();

        return view('informe_semanal.index',compact('proyectos'));*/



    }

    public function crear_informe_semanal(Request $request){

        $id_fase = $request->id_fase_P;

        $fase = fases_act::where('id',$id_fase)
        ->get();

        $desde = $fase[0]->fecha_inicio;
        $hasta = $fase[0]->fecha_fin;

        $proyecto = proyectos::where('id',$fase[0]->id_proyecto)
        ->get();

        $semanas_parametrica = semanas_parametrica::
        join('fases_actividades_planeacion','fases_actividades_planeacion.id_semana_parametrica','=','semanas_parametrica.id')
        ->join('fases_actividades','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->join('fases_planes','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->where('fases_planes.id_fase','=',$id_fase)
        ->where('fases_actividades.param_tipo_caracteristica_actividad_valor',1)
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades.deleted_at')
       // ->where('.fecha_inicial','<=',$hasta)
       //where('semanas_parametrica.fecha_inicial','>=',$desde)
        ->orderBy('semanas_parametrica.fecha_inicial')
        ->select('semanas_parametrica.*')->distinct()
        ->get();


        foreach($semanas_parametrica as $semana)
        {
            $id_semana = $semana->id;

            $consulta = fases_act::leftJoin('fases_planes','fases_planes.id_fase','=','uv_fases_no_clonadas.id')
            ->leftJoin('fases_actividades','fases_actividades.id_fase_plan','=','fases_planes.id')
            ->leftJoin('fases_actividades_planeacion','fases_actividades_planeacion.id_fase_actividad','=','fases_actividades.id')
            ->whereNull('fases_planes.deleted_at')
            ->whereNull('fases_actividades.deleted_at')
            ->where('fases_actividades.param_tipo_caracteristica_actividad_valor',1)
            ->whereNull('fases_actividades_planeacion.deleted_at')
            ->where('uv_fases_no_clonadas.id',$id_fase)
            ->where('fases_actividades_planeacion.id_semana_parametrica',$id_semana)
            ->select('fases_actividades_planeacion.id_fase_actividad','fases_actividades_planeacion.porcentaje_ejecutado')
            ->get();

            $check = 0;
            $uncheck = 0;

            foreach ($consulta as  $value) {

              if($value->porcentaje_ejecutado == null)
              {
                if ($value->porcentaje_ejecutado === 0.0) {
                $check = $check + 1;
                }else{
                $uncheck = $uncheck + 1;
                }
              }else{
                $check = $check + 1;
              }
            }
            $semana->check = $check;
            $semana->uncheck = $uncheck;
        }

        $actividades_pendientes =  DB::select('call usp_actividades_pendiente_ejecucion(?)',array($id_fase));


        $hoy = Carbon::now()->format('Y-m-d');
        $fechaInicial = fases::where('id',$id_fase)->select('fecha_inicio')->first();

        $semanas_ejecucion_extra = semanas_parametrica::where('fecha_fin','>=',$fechaInicial->fecha_inicio)
        ->where('fecha_inicial','<=',$hoy)->get();

        return view('informe_semanal.crear_informe_semanal',compact('semanas_parametrica','proyecto','id_fase','hoy','actividades_pendientes','semanas_ejecucion_extra'));
    }

    public function crear_ejecucion_semanal($id_semana,$id_fase){


        $fase = fases::where('id',$id_fase)
        ->get();

        $proyecto = proyectos::where('id',$fase[0]->id_proyecto)
        ->get();

        $semanas_parametrica = semanas_parametrica::where('id',$id_semana)
        ->get();

        $usuarios = users::where('id_proyecto',$fase[0]->id_proyecto)
        ->join('proyectos_personas as pope','users.id','=','pope.id_usuario')
        ->select('users.id','users.name')->distinct()
        ->get();


        //Lista de las actividades y las semanas
        /*$fases_actividades_planeacion = fases_actividades_planeacion::where('fases_actividades_planeacion.id_semana_parametrica',$id_semana)
        ->join('fases_actividades','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->join('fases_planes','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->Leftjoin('fases_actividades_planeacion as fapa',function($join)  use ($id_semana){
            $join->on('fases_actividades_planeacion.id_fase_actividad','=','fapa.id_fase_actividad')
            ->where('fapa.id_semana_parametrica','<',$id_semana);})
        ->Where('fases_planes.id_fase',$id_fase)
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades.deleted_at')
        ->where('fases_actividades.param_tipo_caracteristica_actividad_valor',1)
        ->select('fases_actividades_planeacion.id','fases_actividades_planeacion.id_fase_actividad','fases_actividades_planeacion.id_semana_parametrica',
        'fases_actividades_planeacion.programado','fases_actividades_planeacion.porcentaje_programado','fases_actividades_planeacion.acumulado_programado',
        'fases_actividades_planeacion.porcentaje_ejecutado','fases_actividades_planeacion.acumulado_ejecutado',
        'fases_actividades.id as id_actividad','fases_actividades.nombre_actividad','fases_planes.nombre_plan',
        DB::raw('ifnull(sum(fapa.porcentaje_ejecutado),0) as acumulado' ))
        ->groupby('fases_actividades_planeacion.id','fases_actividades_planeacion.id_fase_actividad','fases_actividades_planeacion.id_semana_parametrica',
        'fases_actividades_planeacion.programado','fases_actividades_planeacion.porcentaje_programado','fases_actividades_planeacion.acumulado_programado',
        'fases_actividades_planeacion.porcentaje_ejecutado','fases_actividades_planeacion.acumulado_ejecutado','fases_actividades.id' ,
        'id_actividad','fases_actividades.nombre_actividad','fases_planes.nombre_plan')
        ->get();*/


        $consulta = fases_actividades_planeacion::where('fases_actividades_planeacion.id_semana_parametrica',$id_semana)
        ->join('fases_actividades','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
        ->join('fases_planes','fases_planes.id','=','fases_actividades.id_fase_plan')
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades.deleted_at')
        ->where('fases_actividades.param_tipo_caracteristica_actividad_valor',1)
        ->Where('fases_planes.id_fase',$id_fase)
        ->whereNull('fases_actividades.deleted_at')
        ->whereNull('fases_planes.deleted_at')
        ->whereNull('fases_actividades_planeacion.deleted_at')
        ->select(
            'fases_planes.nombre_plan',
            'fases_actividades.nombre_actividad',
            'fases_actividades_planeacion.id as id_fase_actividad',
            'fases_actividades_planeacion.porcentaje_programado',
            'fases_actividades_planeacion.porcentaje_ejecutado',
            'fases_actividades_planeacion.id_fase_actividad as id_actividad'
            )
        ->get();

        $fases_actividades_planeacion = $consulta->toArray();

        for ($i=0; $i < count($fases_actividades_planeacion); $i++) {

            $acumulados = fases_actividades_planeacion::where('fases_actividades_planeacion.id_fase_actividad',$fases_actividades_planeacion[$i]['id_actividad'])
            ->where('fases_actividades_planeacion.id_semana_parametrica','<',$id_semana)
            ->whereNull('deleted_at')
            ->select(DB::raw('ifnull(sum(fases_actividades_planeacion.porcentaje_ejecutado),0) as acumulado_ejecutado'),DB::raw('ifnull(sum(fases_actividades_planeacion.porcentaje_programado),0) as acumulado_programado'))
            ->get();

            $fases_actividades_planeacion[$i]['acumulado_programado'] = $acumulados[0]->acumulado_programado;
            $fases_actividades_planeacion[$i]['acumulado_ejecutado'] = $acumulados[0]->acumulado_ejecutado;

        }

        $tipo_modulo = 5;
        $id = $id_fase;
            $fases_Informe_semanal = fases_Informe_semanal::where([['id_fase',$id_fase],
                                                                    ['id_semana_parametrica',$id_semana]] )
            ->join('users','fases_Informe_semanal.id_usuario','=','users.id')
            ->select('users.name','fases_Informe_semanal.*')
            ->get();


            return view('informe_semanal.crear_ejecucion_semanal',compact('proyecto','usuarios','fases_actividades_planeacion','fase','semanas_parametrica','fases_Informe_semanal',
            'tipo_modulo','id'));


    }

    public function store(Request $request){

       //dd($request);

        $fases_Informe_semanal = fases_Informe_semanal::find($request->id_fases_Informe_semanal);

        $totalPorcentaje=0;
        foreach($request->ejecutado as $key2 => $val2){
            $valor_acumulado_programado = $request->pro_ejecutado[$key2] + $request->ejecutado[$key2];

            if (round($valor_acumulado_programado)   > 100)
            {
               
                $rules['porcentaje_2'] = 'required';
                $messages['porcentaje_2.required'] ='La sumatoria de la programación no puede ser mayor a 100%.';
                $this->validate($request, $rules, $messages);
            }
        }

        if($request->id_usuario == null)
        {
            $rules['Usuario_1'] = 'required';
            $messages['Usuario_1.required'] ='Por favor seleccione el responsable de la lista.';
            $this->validate($request, $rules, $messages);
        }

        if($fases_Informe_semanal  == null )
        {
            if(isset($request->id_fases_Informe_semanal_crear) &&  $request->id_fases_Informe_semanal_crear == 1)
            {
                $fases_Informe_semanal  = new fases_Informe_semanal();
            } else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $fases_Informe_semanal ;
                return response()->json($respuesta);
            }
        }

        $fases_Informe_semanal->id_fase  = $request->id_fase;
        $fases_Informe_semanal->id_semana_parametrica  = $request->id_semana_parametrica;
        $fases_Informe_semanal->id_usuario  = $request->id_usuario;
        $fases_Informe_semanal->fecha_elaboracion =  $request->fecha_elaboracion;

         if($request->id_fases_Informe_semanal==0)
         {
             $fases_Informe_semanal->created_by = Auth::user()->id;
         }else {
             $fases_Informe_semanal->updated_by = Auth::user()->id;
         }
         $fases_Informe_semanal->save();


        foreach($request->id as $key=>$val){

            $fases_actividades_planeacion  = fases_actividades_planeacion::where('id',$request->id[$key])->firstOrFail();
            $fases_actividades_planeacion->porcentaje_ejecutado =  $request->ejecutado[$key];
            $fases_actividades_planeacion->acumulado_ejecutado  =  $request->pro_acumulado[$key] + $request->ejecutado[$key];
            $fases_actividades_planeacion->updated_by = Auth::user()->id;

            $fases_actividades_planeacion->save();
        }


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la caracteristica";
         $respuesta['objeto']= null;// $fases_actividades_planeacion;
         $respuesta['id'] = $fases_Informe_semanal->id;
         $respuesta['fecha'] = $fases_Informe_semanal->fecha_elaboracion;

          return response()->json($respuesta);

    }

    public function store_ejecucion_extra(Request $request)
    {
       
       $consulta = fases_actividades_planeacion::leftJoin('fases_actividades','fases_actividades.id','=','fases_actividades_planeacion.id_fase_actividad')
       ->select( DB::raw('sum(fases_actividades_planeacion.porcentaje_ejecutado) as suma'))
       ->where('fases_actividades.id',$request->id_actividad)
       ->get();

       $suma_ejecutado = $consulta[0]->suma;

       $tot_ejec = $suma_ejecutado + $request->porcentaje_ejecutado;

       if (round($tot_ejec) > 100)
       {
        $rules['ejecutado1'] = 'required';
        $messages['ejecutado1.required'] ='Al adicionar al ajecutado planeado el ejecutado extra superó el 100%.';

        $this->validate($request, $rules, $messages);
       }

      $consulta2 = fases_actividades_planeacion::where('id_fase_actividad',$request->id_actividad)
      ->where('id_semana_parametrica',$request->id_semana)
      ->whereNull('deleted_at')
      ->first();

      if($consulta2 != null)
      {
        $rules['ejecutado2'] = 'required';
        $messages['ejecutado2.required'] ='Esa Actividad ya tiene una programación en la semana seleccionada';

        $this->validate($request, $rules, $messages);
      }

      $registro = new fases_actividades_planeacion();
      $registro->id_fase_actividad = $request->id_actividad;
      $registro->id_semana_parametrica = $request->id_semana;
      $registro->programado = 0;
      $registro->porcentaje_programado = 0;
      $registro->acumulado_programado = 0;
      $registro->porcentaje_ejecutado = $request->porcentaje_ejecutado;
      $registro->acumulado_ejecutado = $consulta[0]->suma;
      $registro->created_by = Auth::user()->id;
      $registro->save();

      $respuesta['status']="success";
      $respuesta['message']="Se ha guardado la información de la caracteristica";
      $respuesta['objeto']= $registro;

      return response()->json($respuesta);


    }

    public function store_bitacora(Request $request)
    {

        $fases_Informe_semanal_bitacora = fases_Informe_semanal_bitacora::find($request->id_fases_Informe_semanal_bitacora);

        if ($request->fecha_ejecucion < $request->fecha_bitacora)
        {
                $rules['fecha_2'] = 'required';
                $messages['fecha_2.required'] ='La fecha de la bitácora no puede ser mayor a la fecha de elaboración.';

            $this->validate($request, $rules, $messages);
        }

        if ($request->file('photo')) {

            $rules['photo'] = 'image|mimes:jpg,jpeg,bmp,png|dimensions:min_width=100 px,min_height=200 px|max:5000 px';
            $messages['photo.image'] ='El tipo de archivo que esta subiendo no es compatible como imagen o foto.';
            $messages['photo.mimes'] ='El formato de imagen no es compatible con las soportadas por el sistema.';
            $messages['photo.dimensions'] ='las dimensiones de la imagen no son compatibles con las requeridas para el sistema.';
            $messages['photo.max'] ='El tamaño de la imagen no es compatible con la requerida para el sistema.';

            $this->validate($request, $rules, $messages);

        }

        if ($fases_Informe_semanal_bitacora == null) {
            if (isset($request->id_fases_Informe_semanal_bitacora_crear) && ($request->id_fases_Informe_semanal_bitacora_crear == 1)) {
                $fases_Informe_semanal_bitacora = new fases_Informe_semanal_bitacora();
            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permisos para crear registros nuevos";
                $respuesta['objecto']= $fases_Informe_semanal_bitacora;
                return response()->json($respuesta);
           }
        }
        $fases_Informe_semanal_bitacora->id_fases_Informe_semanal  = $request->id_fases_Informe_semanal_B;
        $fases_Informe_semanal_bitacora->fecha = $request->fecha_bitacora;
        $fases_Informe_semanal_bitacora->Descripcion_gestion =  $request->descripcion_gestion;
        $fases_Informe_semanal_bitacora->vinculo =$request->vinculo;


        if ($request->id_fases_Informe_semanal_bitacora == 0) {
          $fases_Informe_semanal_bitacora->created_by = Auth::user()->id;
        }else {
           $fases_Informe_semanal_bitacora->updated_by = Auth::user()->id;
        }
        $fases_Informe_semanal_bitacora->save();

        if($fases_Informe_semanal_bitacora->updated_by != null){
            if (!$request->file('photo')) {
                if ($fases_Informe_semanal_bitacora->image == '' || $fases_Informe_semanal_bitacora->image == null) {
                    $fases_Informe_semanal_bitacora->image = '';
                    $fases_Informe_semanal_bitacora->save();
                }
            } else {
                $path = public_path().'/images/informes_semanales/';
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filename = $fases_Informe_semanal_bitacora->id . '.' . $extension;
                $request->file('photo')->move($path, $filename);
                $fases_Informe_semanal_bitacora->image = $filename;
                $fases_Informe_semanal_bitacora->save();
            }
        }else{
            if (!$request->file('photo')) {
                $fases_Informe_semanal_bitacora->image = '';
                $fases_Informe_semanal_bitacora->save();
            } else {
                $path = public_path().'/images/informes_semanales/';
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filename = $fases_Informe_semanal_bitacora->id . '.' . $extension;
                $request->file('photo')->move($path, $filename);
                $fases_Informe_semanal_bitacora->image = $filename;
                $fases_Informe_semanal_bitacora->save();
            }
        }

        


        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la caracteristica";
        $respuesta['objeto']= $fases_Informe_semanal_bitacora;

        return response()->json($respuesta);
    }

    public function fases_Informe_semanal_bitacora_get_info(Request $request)
    {

        $fases_Informe_semanal_bitacora = fases_Informe_semanal_bitacora::where('id_fases_Informe_semanal',$request->id_fases_Informe_semanal_B)
        ->get();

        return response()->json($fases_Informe_semanal_bitacora);

    }

    public function delete_fases_Informe_semanal_bitacora(Request $request)
    {

        $relacion = fases_Informe_semanal_bitacora::find($request->id_fases_Informe_semanal_bitacora);
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

    public function get_archivo(Request $request)
    {

        //dd(base_path());

            $path = public_path().'/dist/img/anim_logo_anim.png';
       
           // $url = $path.$request->imagen;
            $headers = array('Content-Type' => File::mimeType($path));
           
            //return Response::download($path, 'pdf', $headers);
           
            $response = Response::make($path, 200)->withHeaders($headers);
         
    }
}
