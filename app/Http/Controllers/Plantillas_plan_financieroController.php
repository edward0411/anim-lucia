<?php

namespace App\Http\Controllers;

use App\Models\Plan_financieros;
use Illuminate\Http\Request;
use App\Models\Plantilla_plan as plantilla_plan;
use App\Models\Plantilla_plan_nivel as plantilla_plan_nivel;
use App\Models\Plantilla_plan_nivel_dos as Plantilla_plan_nivel_dos;
use App\Models\Plantilla_plan_subnivel as plantilla_plan_subnivel;

use Illuminate\Support\Facades\Auth;



class Plantillas_plan_financieroController extends Controller
{
    //

    public function index(){

        $consulta = plantilla_plan::get();

        return view('plantillas_plan_financieros.index',compact('consulta'));
    }

    public function crear(){

        return view('plantillas_plan_financieros.crear');
    }

    public function store(Request $request){ 

       /* $rules = [ 'plan_nivel_uno' => 'required', ];
        $messages = [ 'plan_nivel_uno.required' => 'Por favor ingrese un valor o nombre a la plantilla.',];

        if(!isset($request->plan_nivel_dos)){
            $rules = [ 'plan_nivel_dos' => 'required', ];
            $messages = [ 'plan_nivel_dos.required' => 'Por favor ingrese un valor o nombre al nivel 2 del plan.',];

            $this->validate($request, $rules, $messages);
        }elseif(!isset($request->plan_nivel_tres)){
            $rules = [ 'plan_nivel_tres' => 'required', ];
            $messages = [ 'plan_nivel_tres.required' => 'Por favor ingrese un valor o nombre al nivel 3 del plan.',];

            $this->validate($request, $rules, $messages);
        }*/


        $plan_financiero = new plantilla_plan();
        $plan_financiero->nombre_plantilla = $request->nombre_plan;
        $plan_financiero->created_by = Auth::user()->id;
        $plan_financiero->save();

       //dd($request->nombre_nivel);

        $id_plantilla_plan = $plan_financiero->id;

        foreach ($request->nombre_nivel[1][0] as $key => $val) {

            $plan_financiero_nivel = new plantilla_plan_nivel();
            $plan_financiero_nivel->id_plantilla_plan = $id_plantilla_plan;
            $plan_financiero_nivel->nombre_nivel_plantilla = $request->nombre_nivel[1][0][$key];
            $plan_financiero_nivel->created_by = Auth::user()->id;
            $plan_financiero_nivel->save();

            //dd($plan_financiero_nivel);
            $id_nivel_dos = $plan_financiero_nivel->id;
            if(isset($request->nombre_nivel[2][$key])){
                foreach($request->nombre_nivel[2][$key] as $key2 => $value2){
                    $plan_financiero_nivel_dos = new plantilla_plan_nivel_dos();
                    $plan_financiero_nivel_dos->id_plantilla_plan_nivel = $id_nivel_dos;
                    $plan_financiero_nivel_dos->nombre_nivel_plantilla_dos	= $request->nombre_nivel[2][$key][$key2];
                    $plan_financiero_nivel_dos->created_by = Auth::user()->id;
                    $plan_financiero_nivel_dos->save();
                    // dd($plan_financiero_nivel);
                
                    $id_nivel_sub = $plan_financiero_nivel_dos->id;
                    if(isset($request->nombre_nivel[3][$key2])){
                        foreach($request->nombre_nivel[3][$key2] as $key3 => $value3){
                            $plan_financiero_nivel_sub = new plantilla_plan_subnivel();
                            $plan_financiero_nivel_sub->id_plantilla_plan_nivel_dos	 =   $id_nivel_sub;
                            $plan_financiero_nivel_sub->nombre_subnivel_plantilla = $request->nombre_nivel[3][$key2][$key3];;
                            $plan_financiero_nivel_sub->created_by = Auth::user()->id;
                            $plan_financiero_nivel_sub->save();

                        }
                    }
                }
            }
        }
    // dd($plan_financiero);


        return redirect()->route('plantillas_plan_financieros.index')->with('success','Creación con éxito.');

    }

    public function editar($id){

        $plantilla_plan = plantilla_plan::where('id',$id)
        ->select('id','nombre_plantilla')
        ->first();

            $plantilla_plan_nivel = plantilla_plan_nivel::where('id_plantilla_plan',$id)
            ->select('id','nombre_nivel_plantilla')
            ->get();
            
            $plantilla_plan->hijos = $plantilla_plan_nivel;

            foreach($plantilla_plan_nivel as $nivel1){

                $plantilla_plan_nivel_dos = plantilla_plan_nivel_dos::where('id_plantilla_plan_nivel',$nivel1->id)
                ->select('id','nombre_nivel_plantilla_dos')
                ->get();

                $nivel1->nivel2 = $plantilla_plan_nivel_dos;

                foreach($plantilla_plan_nivel_dos as $nivel2){

                    $plantilla_plan_subnivel = plantilla_plan_subnivel::where('id_plantilla_plan_nivel_dos',$nivel2->id)
                    ->select('id','nombre_subnivel_plantilla')
                    ->get();
    
                    $nivel2->nivel3 = $plantilla_plan_subnivel;
                }

    
            }

            

        return view('plantillas_plan_financieros.editar',compact('plantilla_plan'));
    }

    public function update(Request $request){

        

        $plan = plantilla_plan::findOrFail($request->id);
        $plan->nombre_plantilla = $request->nombre_plan;
        $plan->updated_by = Auth::user()->id;
        $plan->save();

        $id_plantilla_plan = $plan->id;

        //eliminar las que esten en delete 
        if(isset($request->id_delete[1])){
            foreach($request->id_delete[1] as $key =>$val){
                $plantilla_plan_nivel = plantilla_plan_nivel::findOrFail($val);
                foreach($plantilla_plan_nivel->plantilla_plan_nivel_dos as $plantilla_plan_nivel_dos ){
                    foreach($plantilla_plan_nivel_dos->plantilla_plan_subnivel as $plantilla_plan_subnivel ){
                        $plantilla_plan_subnivel->delete();
                    }
                    $plantilla_plan_nivel_dos->delete();
                }
                $plantilla_plan_nivel->delte();
            }
        }

        if(isset($request->id_delete[2])){
            foreach($request->id_delete[2] as $key => $val){
                $plantilla_plan_nivel_dos = plantilla_plan_nivel_dos::findOrFail($val);
                foreach($plantilla_plan_nivel_dos->plantilla_plan_subnivel as $plantilla_plan_subnivel ){
                    $plantilla_plan_subnivel->delete();
                }
                $plantilla_plan_nivel_dos->delete();
            }
        }

        if(isset($request->id_delete[3])){
            foreach($request->id_delete[3] as $key => $val){
                    $plantilla_plan_subnivel = plantilla_plan_subnivel::find($val);
                    $plantilla_plan_subnivel->delete();
                }
        }


        // editar los registros antiguos

        foreach ($request->nombre_nivel[1][1][0] as $key => $val) {
            
            $plan_financiero_nivel = plantilla_plan_nivel::find($key);
            $plan_financiero_nivel->nombre_nivel_plantilla = $request->nombre_nivel[1][1][0][$key];
            $plan_financiero_nivel->updated_by = Auth::user()->id;
            $plan_financiero_nivel->save();

            //dd($plan_financiero_nivel);
            $id_nivel_dos = $plan_financiero_nivel->id;
            if(isset($request->nombre_nivel[1][2][$key])){
                foreach($request->nombre_nivel[1][2][$key] as $key2 => $value2){
                    $plan_financiero_nivel_dos = plantilla_plan_nivel_dos::find($key2);
                    $plan_financiero_nivel_dos->nombre_nivel_plantilla_dos	= $request->nombre_nivel[1][2][$key][$key2];
                    $plan_financiero_nivel_dos->updated_by = Auth::user()->id;
                    $plan_financiero_nivel_dos->save();
                    // dd($plan_financiero_nivel);
                
                    $id_nivel_sub = $plan_financiero_nivel_dos->id;
                    if(isset($request->nombre_nivel[1][3][$key2])){
                        foreach($request->nombre_nivel[1][3][$key2] as $key3 => $value3){
                            $plan_financiero_nivel_sub = plantilla_plan_subnivel::find($key3);
                            $plan_financiero_nivel_sub->nombre_subnivel_plantilla = $request->nombre_nivel[1][3][$key2][$key3];;
                            $plan_financiero_nivel_sub->updated_by = Auth::user()->id;
                            $plan_financiero_nivel_sub->save();
                        }
                    }
                }
            }
        }

        //crear los registros nuevos
        if(isset($request->nombre_nivel[0][1][0])){        
            foreach ($request->nombre_nivel[0][1][0] as $key => $val) {
                $plan_financiero_nivel = new plantilla_plan_nivel();
                $plan_financiero_nivel->id_plantilla_plan = $id_plantilla_plan;
                $plan_financiero_nivel->nombre_nivel_plantilla = $request->nombre_nivel[0][1][0][$key];
                $plan_financiero_nivel->created_by = Auth::user()->id;
                $plan_financiero_nivel->save();

                //dd($plan_financiero_nivel);
                $id_nivel_dos = $plan_financiero_nivel->id;
                if(isset($request->nombre_nivel[0][2][$key])){
                    foreach($request->nombre_nivel[0][2][$key] as $key2 => $value2){
                        $plan_financiero_nivel_dos = new plantilla_plan_nivel_dos();
                        $plan_financiero_nivel_dos->id_plantilla_plan_nivel = $id_nivel_dos;
                        $plan_financiero_nivel_dos->nombre_nivel_plantilla_dos	= $request->nombre_nivel[0][2][$key][$key2];
                        $plan_financiero_nivel_dos->created_by = Auth::user()->id;
                        $plan_financiero_nivel_dos->save();
                        // dd($plan_financiero_nivel);
                    
                        $id_nivel_sub = $plan_financiero_nivel_dos->id;
                        if(isset($request->nombre_nivel[0][3][$key2])){
                            foreach($request->nombre_nivel[0][3][$key2] as $key3 => $value3){
                                $plan_financiero_nivel_sub = new plantilla_plan_subnivel();
                                $plan_financiero_nivel_sub->id_plantilla_plan_nivel_dos	 =   $id_nivel_sub;
                                $plan_financiero_nivel_sub->nombre_subnivel_plantilla = $request->nombre_nivel[0][3][$key2][$key3];;
                                $plan_financiero_nivel_sub->created_by = Auth::user()->id;
                                $plan_financiero_nivel_sub->save();

                            }
                        }
                    }
                }
            }
        }

      
        return redirect()->route('plantillas_plan_financieros.index')->with('success','Actualizado con éxito.');

    }

    public function destroy(Request $request){

        $plan = plantilla_plan::findOrFail($request->id_plantilla);
        $plan->delete();

        return redirect()->route('plantillas_plan_financieros.index')->with('success','Eliminado con éxito.');

    }
}
