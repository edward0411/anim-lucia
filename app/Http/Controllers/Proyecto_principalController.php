<?php

namespace App\Http\Controllers;

use App\Models\Contratos;
use Illuminate\Http\Request;
use App\Models\Proyecto_principal as proyectos_pal;
use App\Models\Proyectos as proyectos;
use App\User as users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class Proyecto_principalController extends Controller
{
    //
    public function index(){

            return view('proyectos.principales.index');

    }

    public function get_info_proyectos(Request $request){

        $proyecto_pal = proyectos_pal::all();

        return response()->json($proyecto_pal);
    }

    public function store(Request $request){

        $proyecto = proyectos_pal::find($request->id_proyecto_pal);

        $proyectoExiste = proyectos_pal::where([['nombre_proyecto_principal',$request->nombre_proyecto_principal],
                                            ['id','<>',$request->id_proyecto_pal]])->get();
        if ($proyectoExiste->count()>0)
        {
            $rules['Nombre_1'] = 'required';
            $messages['Nombre_1.required'] ='El nombre del Proyecto Principal ya existe.';

            $this->validate($request, $rules, $messages);
        }

        if ($proyecto == null) {
            if (isset($request->id_proyecto_pal_crear) && ($request->id_proyecto_pal_crear == 1)) {
                $proyecto = new proyectos_pal();

            }else{
                $respuesta['status']="error";
                $respuesta['message']="No tiene permisos para crear registros nuevos";
                $respuesta['objeto']= $proyecto;
                return response()->json($respuesta);
           }
        }

        $rules['nombre_proyecto'] = 'required';
        $messages['nombre_proyecto.required'] ='El nombre del Proyecto Principal es obligatorio.';

        $this->validate($request, $rules, $messages);


        $proyecto->nombre_proyecto_principal = $request->nombre_proyecto;
        $proyecto->descripcion = $request->descripcion_proyecto;


        if ($request->id_proyecto == 0) {
          $proyecto->created_by = Auth::user()->id;
        }else {
           $proyecto->updated_by = Auth::user()->id;
        }
        $proyecto->save();

        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información del Proyecto Principal";
        $respuesta['objeto']= $proyecto;

         return response()->json($respuesta);

    }


    public function delete(Request $request)
    {
        $validacion =  proyectos::where('id_proyecto_principal',$request->id_proyecto)->whereNull('deleted_at')->get();

        if ($validacion->count()>0)
        {

        $rules['validacion'] = 'required';
        $messages['validacion.required'] ='Este Proyecto Principal tiene proyectos/Fases asociados.';


        $this->validate($request, $rules, $messages);


        }

        $relacion = proyectos_pal::find($request->id_proyecto);
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
