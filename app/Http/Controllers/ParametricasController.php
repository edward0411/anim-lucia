<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametricas as parametricas;
use Carbon\Carbon;

class ParametricasController extends Controller
{
    //
    public function index(){

        $parametrica = parametricas::all();


      return view('parametricas.index',compact('parametrica'));

    }
    //
    public function crear(){

      $datos = [];
      $parametrica = parametricas::all();

      $parametricas_padres = parametricas::whereNotNull('categoria_padre')
      ->select('categoria_padre')
      ->distinct()
      ->get();


        return view('parametricas.crear',compact('datos','parametrica','parametricas_padres'));
      }

      public function store(Request $request){

        $categoria = parametricas::find($request->categoria);
        $nombre_categoria = $categoria->categoria;

        $request->validate([
         'categoria' => 'required',
         'valor' => 'required',
         'texto' => 'required',
         'descripcion' => 'required',
         'orden' => 'numeric',
        ] );

         $parametrica = new parametricas();
         $parametrica->categoria = $nombre_categoria;
         $parametrica->valor = $request->valor;
         $parametrica->texto = $request->texto;
         $parametrica->orden  = $request->orden;
         $parametrica->descripcion = $request->descripcion;
         $parametrica->categoria_padre = $request->categoria_padre;
         if($request->categoria_padre != null){
          $parametrica->valor_padre = $request->value_paadre;
         }
         $parametrica->save();

        // dd($parametrica);

         return redirect()->route('parametricas.index')->with('success', 'Información guardada de forma exitosa');
 }

    public function editar($id)
          {
            $datos = [];
            $parametrica = parametricas::findOrFail($id);

            $parametricas_padres = parametricas::whereNotNull('categoria_padre')
            ->select('categoria_padre')
            ->distinct()
            ->get();

          return view('parametricas.editar', compact('datos','parametrica','parametricas_padres'));
          }

   public function update(Request $request) {

            $request->validate([
                'categoria' => 'required',
                'valor' => 'required',
                'texto' => 'required',
                'descripcion' => 'required',
                'orden' => 'numeric',
               ] );
               $parametricas = parametricas::where('id','=',$request->id)->firstOrFail();
               $parametricas->categoria = $request->categoria;
               $parametricas->valor = $request->valor;
               $parametricas->texto = $request->texto;
               $parametricas->orden  = $request->orden;
               $parametricas->descripcion = $request->descripcion;
               if (isset($request->value_paadre)) {
                $parametricas->categoria_padre = $request->categoria_padre;
                $parametricas->valor_padre = $request->value_paadre;
               }
               $parametricas->update();

                  return redirect()->route('parametricas.index')->with('success','Información actualizada de forma exitosa');


   }

    public function activar($id)
    {
        $parametrica = parametricas::where('id', $id)->firstOrFail();
        $parametrica->estado = 1;
        $parametrica->update();

        return redirect()->route  ('parametricas.index')->with('success','Paramétrica activada con éxito');
    }

    public function inactivar($id)
    {
        $parametrica = parametricas::where('id', $id)->firstOrFail();
        $parametrica->estado = 0;
        $parametrica->update();

        return redirect()->route  ('parametricas.index')->with('success','Paramétrica inactivada con éxito');

    }

    public function get_info_parametricas_padres(Request $request)
    {
      $value_padre = parametricas::where('categoria',$request->categoria)
      ->select('valor','texto')
      ->distinct()
      ->get();

      return response()->json($value_padre);
    }

}
