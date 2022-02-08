<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyectos_personas as proyecto_personas;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProyectosPersonasController extends Controller
{
    //
    public function personas_store(Request $request){
       
        $personas_proyecto = proyecto_personas::find($request->id_proyecto_persona);
        
        $personas_proyectoExiste = proyecto_personas::where([['id_usuario','=',$request->id_usuario],
                                                            ['id_proyecto','=',$request->personas_id_proyecto],
                                                            ['id','<>',$request->id_proyecto_persona]])
        ->get();

       /* $rules = [
            'Persona_1' => 'required',

        ];
        $messages = [
            'Persona_1.required' => '',

        ];*/

        if ($personas_proyectoExiste->count()>0 )
        {
            $rules['PesronaNull'] = 'required';
            $messages['PesronaNull.required'] ='La persona ya esta asociada.';
            $this->validate($request, $rules, $messages);
        }
        if ($request->id_usuario ==null ) {
           
            $rules['PesronaNull'] = 'required';
            $messages['PesronaNull.required'] ='Debe seleccionar la persona de la lista.';
            $this->validate($request, $rules, $messages);
        }
        

        if($personas_proyecto  == null )
        {
            if(isset($request->id_proyecto_persona_crear) &&  $request->id_proyecto_persona_crear == 1)
            {
             $personas_proyecto  = new proyecto_personas();
            } 
            else
            {
                $respuesta['status']="error";
                $respuesta['message']="No tiene permiso para crear registros nuevos";
                $respuesta['objeto']= $personas_proyecto;
                return response()->json($respuesta);
            }
        }
       
         $personas_proyecto->id_proyecto  = $request->personas_id_proyecto;
         $personas_proyecto->id_usuario  = $request->id_usuario;
         $personas_proyecto->param_tipo_rol_valor  = $request->rol_persona;
         $personas_proyecto->param_tipo_rol_texto = Parametricas::getTextFromValue('tecnico.proyectos.roles', $request->rol_persona);
         $personas_proyecto->para_tipo_subdireccion_valor = $request->subdireccion;
         $personas_proyecto->para_tipo_subdireccion_texto	 = Parametricas::getTextFromValue('tecnico.proyectos.subdirecciones', $request->subdireccion);
         if($request->id_proyecto_presonas==0)
         {
             $personas_proyecto->created_by = Auth::user()->id;
         }else {
             $personas_proyecto->updated_by = Auth::user()->id;
         }
         $personas_proyecto->save();


         $respuesta['status']="success";
         $respuesta['message']="Se ha guardado la información de la relación";
         $respuesta['objeto']= $personas_proyecto;

          return response()->json($respuesta);



    }

    public function personas_get_info(Request $request){

        $personas = proyecto_personas::where('id_proyecto',$request->id_proyecto)
        ->join('users','proyectos_personas.id_usuario','=','users.id')
        ->Select('proyectos_personas.*','users.name')
        ->get();
      
        return response()->json($personas);

    }

    public function delete_personas(Request $request)
        {
            $relacion = proyecto_personas::find($request->id_proyecto_persona);
            $relacion->deleted_by = Auth::user()->id;
            $relacion->save();
    
            $informacionlog = 'Se ha eliminado la informacion de la relación';
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
