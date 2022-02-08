<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Parametricas as parametricas;
use App\Models\Personas as personas;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\RedirectsUsers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PersonasController extends Controller
{
    //

    public function index()
    {

      $personas = personas::where('param_tipodocumento_valor',1)->get();
      $titulo = 'Personas';
      $active_menu = 15;
      $param_tipodocumento_valor = 1;
      $token=Crypt::encryptString(0);

        return view('personas.index', compact('personas','titulo','active_menu','param_tipodocumento_valor','token'));
    }

    public function crear()
    {
     $documento = parametricas::getFromCategory('personas.tipo_documento');
        return view('personas.crear', compact('documento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
        ]);

        $personaExiste = personas::Where('numero_documento',$request->numero_documento)
         ->get();

         if ($personaExiste->count()>0)
           {
           $rules['ExistePersona'] = 'required';
           $messages['ExistePersona.required'] ='Ya existe esa persona con ese numero de documento.';
           $this->validate($request, $rules, $messages);
         }


        $persona = new personas();
        $persona->param_tipodocumento_valor = $request->tipo_documento;
        $persona->param_tipodocumento_texto = Parametricas::getTextFromValue('personas.tipo_documento', $request->tipo_documento);
        $persona->numero_documento = $request->numero_documento;
        $persona->primer_nombre = $request->primer_nombre;
        $persona->segundo_nombre = $request->segundo_nombre;
        $persona->primer_apellido = $request->primer_apellido;
        $persona->segundo_apellido = $request->segundo_apellido;
        $persona->created_by = Auth::user()->id;
        $persona->save();

        return redirect()->route('personas.index')->with('success', 'Información guardada de forma exitosa');
    }

    public function editar($id){

        $persona = DB::table('personas')
        ->leftJoin('parametricas','parametricas.id','=','personas.param_tipodocumento_valor')
        ->select('personas.*','parametricas.texto')
        ->where('personas.id',$id)
        ->get();

        $documento = parametricas::getFromCategory('personas.tipo_documento');
        return view('personas.editar',compact('persona','documento'));
    }

    public function update(Request $request){

        $request->validate([
            'numero_documento' => 'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
        ]);

        $persona = personas::where('id','=',$request->id)->firstOrFail();
        $persona->param_tipodocumento_valor = $request->tipo_documento;
        $persona->param_tipodocumento_texto = Parametricas::getTextFromValue('personas.tipo_documento', $request->tipo_documento);
        $persona->numero_documento = $request->numero_documento;
        $persona->primer_nombre = $request->primer_nombre;
        $persona->segundo_nombre = $request->segundo_nombre;
        $persona->primer_apellido = $request->primer_apellido;
        $persona->segundo_apellido = $request->segundo_apellido;
        $persona->updated_by = Auth::user()->id;
        $persona->update();

        return redirect()->route('personas.index')->with('success','Información actualizada de forma exitosa');
    }

  
      public function activar($id)
      {
          $persona = personas::where('id', $id)->firstOrFail();
          $persona->estado = 1;
          $persona->update();
      
          return redirect()->route  ('personas.index')->with('success','Persona activada con éxito');
      }
      
      public function inactivar($id)
      {
          $persona = personas::where('id', $id)->firstOrFail();
          $persona->estado = 0;
          $persona->update();
      
          return redirect()->route  ('personas.index')->with('success','Persona inactivada con éxito');
      
      }
}
