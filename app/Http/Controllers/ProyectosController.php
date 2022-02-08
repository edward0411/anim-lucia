<?php

namespace App\Http\Controllers;

use App\Models\Contratos;
use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use App\Models\Proyectos as proyectos;
use App\Models\Proyecto_principal as proyectos_pal;
use App\Models\Terceros as terceros;
use App\Models\Fases as fases;
use App\Models\Departamentos as departamentos;
use App\Models\Municipios as municipios;
use App\User as users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{
    //
    public function index(){

        $user = Auth::user()->id;
        $userb = users::with('roles')->where('id', $user)->first();
        $role= $userb->roles->first()->name;



        if($role=='Administrador'){

            /*$proyectos = proyectos::leftJoin('proyectos_convenios','proyectos_convenios.id_proyecto','=','proyectos.id')
            ->leftJoin('contratos','contratos.id','=','proyectos_convenios.id_contrato')
            ->whereNull('proyectos_convenios.deleted_at')
            ->select('proyectos.id','proyectos.nombre_proyecto','proyectos.param_tipo_proyecto_texto','contratos.numero_contrato')
            ->get();*/


           $proyectos = proyectos::get();

            //dd( $proyectos );

            return view('proyectos.index',compact('proyectos'));
        }else{

            $proyectos = proyectos::leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
            ->where('proyectos_personas.id_usuario',$user)
            ->whereNull('proyectos_personas.deleted_at')
            ->select('proyectos.id','proyectos.nombre_proyecto','proyectos.param_tipo_proyecto_texto')
            ->distinct()
            ->get();

            //dd($proyectos);
            return view('proyectos.index',compact('proyectos'));
        }



        /*$proyectos = proyectos::get();
        return view('proyectos.index',compact('proyectos'));*/

    }

    public function crear(Request $request){

        $tipo_proyecto = Parametricas::getFromCategory('tecnico.proyectos.tipo_proyectos');

        $departamentos = departamentos::all()->sortBy('nombre_departamento');
        $municipios= municipios::all()->sortBy('nombre_municipio');
        $proyecto_pal = proyectos_pal::all();

        return view('proyectos.crear',compact('tipo_proyecto','departamentos','municipios','proyecto_pal'));
    }

    public function editar($id){

        $proyecto = proyectos::where('proyectos.id',$id)
        ->leftjoin('municipios','proyectos.id_municipio','=','municipios.id')
        ->select('proyectos.*','municipios.id_departamento')
        ->get();

        $proyecto_pal = proyectos_pal::all();


        $tipo_proyecto = Parametricas::getFromCategory('tecnico.proyectos.tipo_proyectos');

        $departamentos = departamentos::all()->sortBy('nombre_departamento');
        $municipios= municipios::all()->sortBy('nombre_municipio');

        $municipioDeptos = municipios::where('id_departamento',$proyecto[0]->id_departamento)->get()->sortBy('nombre_municipio');


        return view('proyectos.editar',compact('proyecto','tipo_proyecto','departamentos','municipios','municipioDeptos','proyecto_pal'));
    }

    public function store(Request $request){

        $proyecto = proyectos::find($request->id_proyecto);

        $proyectoExiste = proyectos::where([['nombre_proyecto',$request->nombre_proyecto],
                                            ['id','<>',$request->id_proyecto]])->get();
        if ($proyectoExiste->count()>0)
            {

            $rules['Nombre_1'] = 'required';
            $messages['Nombre_1.required'] ='El nombre del proyecto ya existe.';


            $this->validate($request, $rules, $messages);
            }

        if ($proyecto == null) {
            if (isset($request->id_proyecto_crear) && ($request->id_proyecto_crear == 1)) {
                $proyecto = new proyectos();


            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permisos para crear registros nuevos";
                $respuesta['objecto']= $proyecto;
                return response()->json($respuesta);
           }
        }

        /*$rules['proyecto_principal'] = 'required';
        $messages['proyecto_principal.required'] ='El nombre del Proyecto principal es obligatorio.';


        $this->validate($request, $rules, $messages);*/

        $proyecto->id_proyecto_principal = $request->proyecto_principal;
        $proyecto->nombre_proyecto = $request->nombre_proyecto;
        $proyecto->param_tipo_proyecto_valor = $request->tipo_proyecto;
        $proyecto->param_tipo_proyecto_texto = Parametricas::getTextFromValue('tecnico.proyectos.tipo_proyectos', $request->tipo_proyecto);
        $proyecto->objeto_proyecto = $request->objeto_proyecto;
        $proyecto->estado = 1;
        $proyecto->id_municipio = $request->id_municipio;
        $proyecto->latitud = $request->latitud;
        $proyecto->longitud = $request->longitud;
        $proyecto->direccion = $request->direccion;
        $proyecto->altitud = $request->altitud;

        if ($request->id_proyecto == 0) {
          $proyecto->created_by = Auth::user()->id;
        }else {
           $proyecto->updated_by = Auth::user()->id;
        }
        $proyecto->save();

        $id_proyecto = $proyecto->id;


        return redirect()->route('proyectos.crear_info',$id_proyecto);


    }

    public function crear_info($id){

        $proyecto = proyectos::find($id);

        $proyecto = proyectos::where('proyectos.id',$id)
        ->leftjoin('municipios','proyectos.id_municipio','=','municipios.id')
        ->leftjoin('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('proyectos.*','municipios.nombre_municipio','departamentos.nombre_departamento')
        ->get();

        $caracteristicas_proyecto = Parametricas::getFromCategory('tecnico.proyectos.caracteristica_proyectos')->sortBy('texto');

        $licencias_proyecto = Parametricas::getFromCategory('tecnicos.proyectos.licencias_proyecto');

        $modalidad = parametricas::Where('categoria', 'tecnico.proyectos.modalidad')
        ->orderBy('orden')
        ->select('valor', 'texto','valor_padre')
        ->get();

        $tipo_tramite = parametricas::getFromCategory('tecnico.proyectos.tipo_tramite');

        $rol_proyecto = parametricas::getFromCategory('tecnico.proyectos.roles');

        $subdireccion_proyecto = parametricas::getFromCategory('tecnico.proyectos.subdirecciones');

        $estado_licencia = parametricas::getFromCategory('tecnico.proyectos.licencia_estado');

        $convenios = contratos::Where('param_valor_tipo_contrato', '1')
        ->Select('id','numero_contrato')
        ->get();


        $tercero = terceros::all();

        $usuarios = users::all();


        $fases = DB::select('call usp_proyecto_consultarAvanceFase(?)',array($id));

       

        return view('proyectos.crear_info',compact('proyecto','caracteristicas_proyecto','licencias_proyecto','modalidad','tipo_tramite','rol_proyecto','subdireccion_proyecto','estado_licencia','convenios','tercero','usuarios','fases'));
    }


}
