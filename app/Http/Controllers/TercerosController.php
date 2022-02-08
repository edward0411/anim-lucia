<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Facades\DB;
use App\Models\Terceros as terceros;
use App\Models\Terceros_cuentas_bancarias as terceros_cuentas_bancarias;
use App\Models\Terceros_integrantes_consorcios as terceros_integrantes_consorcios;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;




class TercerosController extends Controller
{
    //

    public function index(){

      $tercero = terceros::orderBy('id')->get();

     /* $tercero = DB::table('terceros')
      ->leftJoin('parametricas as para','para.id','=','terceros.param_naturaleza_juridica_valor')
      ->leftJoin('parametricas as par','par.id','=','terceros.param_tipodocumento_valor')
      ->orderBy('id')
      ->select('terceros.*','para.texto','par.texto')
      ->get();*/


        return view('terceros.index',compact('tercero'));
    }

    public function index_cuentas(){

        $cuenta = terceros_cuentas_bancarias::where('param_tipo_cuenta_valor',1)->get();

        return view('terceros.crear',compact('cuenta'));
    }

    public function crear(){


        $cuenta = terceros_cuentas_bancarias::where('param_tipo_cuenta_valor',1)->get();
        $titulo = "Terceros";
        $active_menu = 17;
        $param_tipo_cuenta_valor = 1;
        $token=Crypt::encryptString(0);




        $naturaleza = parametricas::getFromCategory('terceros.naturaleza_juridica');
        $tipo = parametricas::getFromCategory('personas.tipo_documento');


        $tipo_repre = parametricas::getFromCategory('terceros.tipodocumento_representante');



        return view('terceros.crear',compact('naturaleza','tipo','tipo_repre','cuenta','titulo','active_menu','param_tipo_cuenta_valor','token'));
    }

    public function store(Request $request){

       // dd($request);

       if(empty($request->razon_social)){

        $nombre_completo = $request->primer_nombre.' '.$request->segundo_nombbre.' '.$request->primer_apellido.' '.$request->segundo_apellido;
        $request->razon_social = $nombre_completo ;
      }


        $request->validate([
          'naturaleza_juridica' => 'required',
          'tipo_documento' => 'required',
          'identificacion' =>  ['required', 'numeric','unique:terceros'],
          'correo_electronico' => ['required', 'string', 'email', 'max:255', 'unique:terceros'],
          'razon_social' => 'required',
        ]);



        $terceros = new terceros();
        $terceros->nombre = $request->razon_social;
        $terceros->param_naturaleza_juridica_valor = $request->naturaleza_juridica;
        $terceros->param_naturaleza_juridica_texto = Parametricas::getTextFromValue('terceros.naturaleza_juridica', $request->naturaleza_juridica);
        $terceros->param_tipodocumento_valor = $request->tipo_documento;
        $terceros->param_tipodocumento_texto = Parametricas::getTextFromValue('personas.tipo_documento', $request->tipo_documento);
        $terceros->identificacion = $request->identificacion;
        $terceros->primer_nombre = $request->primer_nombre;
        $terceros->segundo_nombre = $request->segundo_nombbre;
        $terceros->primer_apellido = $request->primer_apellido;
        $terceros->segundo_apellido = $request->segundo_apellido;
        $terceros->direccion = $request->direccion;
        $terceros->telefono = $request->telefono;
        $terceros->correo_electronico = $request->correo_electronico;
        $terceros->param_tipodocumento_rep_valor = $request->tipo_documento_representante;
        $terceros->param_tipodocumento_rep_texto = Parametricas::getTextFromValue('personas.tipo_documento',$request->tipo_documento_representante);
        $terceros->identificacion_representante = $request->identificacion_representante;
        $terceros->representante_legal = $request->representante_legal;
        $terceros->created_by = Auth::user()->id;
        $terceros->save();




        return redirect()->route('terceros.editar',$terceros->id)->with('success','Informacion guardada de forma exitosa');
    }

  public function editar($id){

    $tercero = DB::table('terceros')
      ->leftJoin('parametricas as para','para.id','=','terceros.param_naturaleza_juridica_valor')
      ->leftJoin('parametricas as par','par.id','=','terceros.param_tipodocumento_valor')
      ->select('terceros.*','para.texto','par.texto')
      ->where('terceros.id',$id)
      ->get();

      $naturaleza = parametricas::getFromCategory('terceros.naturaleza_juridica');
      $tipo = parametricas::getFromCategory('personas.tipo_documento');
      $tipo_repre = parametricas::getFromCategory('terceros.tipodocumento_representante');

      return view('terceros.editar',compact('naturaleza','tipo','tercero','tipo_repre'));


  }

  public function update(Request $request){


    if(empty($request->razon_social)){

        $nombre_completo = $request->primer_nombre.' '.$request->segundo_nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido;
        $request->razon_social = $nombre_completo ;
      }

    $request->validate([
  
        'tipo_documento' => 'required',
        'numero_identificacion' => 'required',
        'correo_electronico' => 'required',
        'razon_social' => 'required',
      ]);

    $tercero = terceros::where('id','=',$request->id)->firstOrFail();
    $tercero->nombre = $request->razon_social;
    $tercero->param_naturaleza_juridica_valor = $request->naturaleza_juridica;
    $tercero->param_naturaleza_juridica_texto = Parametricas::getTextFromValue('terceros.naturaleza_juridica', $request->naturaleza_juridica);
    $tercero->param_tipodocumento_valor = $request->tipo_documento;
    $tercero->param_tipodocumento_texto = Parametricas::getTextFromValue('personas.tipo_documento', $request->tipo_documento);
    $tercero->identificacion = $request->numero_identificacion;
    $tercero->primer_nombre = $request->primer_nombre;
    $tercero->segundo_nombre = $request->segundo_nombre;
    $tercero->primer_apellido = $request->primer_apellido;
    $tercero->segundo_apellido = $request->segundo_apellido;
    $tercero->direccion = $request->direccion;
    $tercero->telefono = $request->telefono;
    $tercero->correo_electronico = $request->correo_electronico;
    $tercero->param_tipodocumento_rep_valor = $request->tipo_documento_representante;
    $tercero->param_tipodocumento_rep_texto = Parametricas::getTextFromValue('personas.tipo_documento',$request->tipo_documento_representante);
    $tercero->identificacion_representante = $request->identificacion_representante;
    $tercero->representante_legal = $request->representante_legal;
    $tercero->created_by = Auth::user()->id;
    $tercero->update();



    return redirect()->route('terceros.index',$tercero->id)->with('success','Información actualizada de forma exitosa');

  }

  public function ver_terceros($id){

    $terceros =  Crypt::decryptString($id);

    $tercero = DB::table('terceros')
    ->leftJoin('parametricas as para','para.id','=','terceros.param_naturaleza_juridica_valor')
    ->leftJoin('parametricas as par','par.id','=','terceros.param_tipodocumento_valor')
    ->leftJoin('terceros_integrantes_consorcios as t_i_c','t_i_c.id_tercero','=','terceros.id')
    ->select('terceros.*','para.texto','par.texto','t_i_c.nombre_razon_social','t_i_c.param_tipodocumento_texto as p_t','t_i_c.numero_identificacion','t_i_c.porcentaje')
    ->where('terceros.id',$terceros)
    ->get();



    return view('terceros.ver_terceros',compact('tercero'));
  }


  public function terceros_integrantes_store(Request $request){

    //dd($request);
    $rules['id_tercero'] = 'required';
    $messages['id_tercero.required'] ='El campo es obligatorio';    

   $terceros_integrantes = terceros_integrantes_consorcios::find($request->id_terceros_integrantes); 

    if($terceros_integrantes == null )
    {
        if(isset($request->id_terceros_intergrantes_crear) &&  $request->id_terceros_intergrantes_crear==1)
        {
          $consulta = terceros_integrantes_consorcios::where('id_tercero',$request->id_tercero)
          ->select( DB::raw('sum(porcentaje) as valor'))
           ->get();

               if ($consulta[0]->valor != null) {
               $participacion =$consulta[0]->valor;
               $total_participacion = $participacion + (int)$request->porcentaje_participacion;
                    if ($total_participacion > 100) {
                    $rules['id_tercero2'] = 'required';
                    $messages['id_tercero2.required'] ='La suma de asignación del porcentaje supera el 100 % de la participación.';    
                    }
              }else {
                     if ((int)$request->porcentaje_participacion > 100) {
                    $rules['id_tercero3'] = 'required';
                    $messages['id_tercero3.required'] ='La asignación del porcentaje supera el 100 % de la participación.';  
                    }
              }
             $this->validate($request, $rules, $messages);

            $terceros_integrantes = new terceros_integrantes_consorcios();
        } else
        {
            $respuesta['status']="error";
            $respuesta['message']="No tiene permiso para crear registros nuevos";
            $respuesta['objeto']= $terceros_integrantes;
            return response()->json($respuesta);
        }
    }else{
      $porcentaje_old = (int)$terceros_integrantes->porcentaje;
      $consulta = terceros_integrantes_consorcios::where('id_tercero',$request->id_tercero)
      ->select( DB::raw('sum(porcentaje) as valor'))
       ->get();
       $participacion =$consulta[0]->valor;
       $diferencia = $participacion -  $porcentaje_old;
       $nuevo_porcentaje = $diferencia  + (int)$request->porcentaje_participacion;
       if ($nuevo_porcentaje > 100) {
        $rules['id_tercero4'] = 'required';
        $messages['id_tercero4.required'] ='La suma de asignación del porcentaje supera el 100 % de la participación.';    
        }
        $this->validate($request, $rules, $messages);
    }

    $terceros_integrantes->id_tercero = $request->id_tercero;
    $terceros_integrantes->nombre_razon_social = $request->nombre_razon_social;
    $terceros_integrantes->param_tipodocumento_valor = $request->tipo_identificacion;
    $terceros_integrantes->param_tipodocumento_texto = Parametricas::getTextFromValue('personas.tipo_documento',$request->tipo_identificacion);
    $terceros_integrantes->numero_identificacion = $request->numero_identificacion;
    $terceros_integrantes->porcentaje = $request->porcentaje_participacion;
    $terceros_integrantes->estado = 1;

    if($request->id_terceros_integrantes==0)
    {
        $terceros_integrantes->created_by = Auth::user()->id;
    }else {
        $terceros_integrantes->updated_by = Auth::user()->id;
    }

    $terceros_integrantes->save();



    $respuesta['status']="success";
    $respuesta['message']="Se ha guardado la información del integrante";
    $respuesta['objeto']= $terceros_integrantes;

    return response()->json($respuesta);
  }

  public function get_infointegrantes_por_tercero(Request $request){
    //$id_cdr=Crypt::decryptString($cdr_token);

    $integrante = terceros_integrantes_consorcios::where('id_tercero',$request->id_tercero)
    ->get();

    return response()->json($integrante);
}

public function delete_info_integrante(Request $request)
{
    $tercero_integrante = terceros_integrantes_consorcios::find($request->id_terceros_integrantes);

    $tercero_integrante->deleted_by = Auth::user()->id;
    $tercero_integrante->save();


    $informacionlog = 'Se ha eliminado la informacion del integrante';
    $objetolog = [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->mail,
            'Objeto Eliminado' => $tercero_integrante,
            ];

    Log::channel('database')->info(
        $informacionlog ,
        $objetolog
    );

    $tercero_integrante->delete();

    // $info_contra = informacion_contractuals::all();
    $respuesta['status']="success";
    $respuesta['message']="Se ha eliminado registro";
    $respuesta['objeto']=$tercero_integrante;


    return response()->json($respuesta);

}

public function activar($id)
{
    $terceros = terceros::where('id', $id)->firstOrFail();
    $terceros->estado = 1;
    $terceros->update();

    return redirect()->route  ('terceros.index')->with('success','Tercero activado con éxito');
}

public function inactivar($id)
{
    $terceros = terceros::where('id', $id)->firstOrFail();
    $terceros->estado = 0;
    $terceros->update();

    return redirect()->route  ('terceros.index')->with('success','Tercero inactivado con éxito');

}

}
