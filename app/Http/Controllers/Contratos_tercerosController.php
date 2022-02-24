<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terceros as terceros;
use App\Models\Contratos_terceros as contratos_tercero;
use Auth;
use Log;
class Contratos_tercerosController extends Controller
{
   

    public function get_info_terceros(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $tercero = terceros::where('id',$request->id_tercero)
                    ->get();
       
        // $info_contra = informacion_contractuals::all();
        return response()->json($tercero);  

    }


    public function delete_info_terceros(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $contratos_tercero = contratos_tercero::find($request->id_contratos_tercero);
        
        $contratos_tercero->deleted_by = Auth::user()->id;
        $contratos_tercero->save();

        
        $informacionlog = 'Se ha eliminado la relacion contrato_tercero';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'Objeto Eliminado' => $contratos_tercero,
                ];                

        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        $contratos_tercero->delete();

        // $info_contra = informacion_contractuals::all();
        $respuesta['status']="success";
        $respuesta['message']="Se ha eliminado registro";
        $respuesta['objeto']=$contratos_tercero;
        

        return response()->json($respuesta);

    }

    
    public function store(Request $request )
    {
         //dd($request);
         $request->validate([
            'contratista' => 'required',
            'id_contrato' => 'required',
            'correo_electronico' => ['required','email'],
           ] );
        
                $contratos_tercero = contratos_tercero::where('id_contrato',$request->id_contrato)->first();
                
                if($contratos_tercero==null){

                    $contratos_tercero = new contratos_tercero();
                    $contratos_tercero->created_by = Auth::user()->id;
                }

                $contratos_tercero->id_contrato = $request->id_contrato;
                $contratos_tercero->id_terecero = $request->id_contratista;
                $contratos_tercero->correo_electronico = $request->correo_electronico;
                $contratos_tercero->param_tipo_cuenta_valor = $request->tipo_cuenta;
                $contratos_tercero->param_tipo_cuenta_texto = $request->tipo_cuenta;
                $contratos_tercero->param_banco_valor = $request->banco;
                $contratos_tercero->param_banco_texto = $request->id_contratista;
                $contratos_tercero->numero_cuenta = $request->numero_cuenta;
                $contratos_tercero->estado = 1;
                
                $contratos_tercero->updated_by = Auth::user()->id;
                
                $contratos_tercero->save();

                $respuesta['status']="success";
                $respuesta['message']="Se ha guardado la información del contratista";
            
            return response()->json($respuesta);
    }

   

    
    public function storePartesConvenio(Request $request )
    {
   // dd($request);
        $valor_aporte=$request->valor_entidad;
        $valor_aporte=str_replace(',','',$valor_aporte);
        
        $array_id_entidad = $request->id_entidad;
        $array_unique = array_unique($array_id_entidad);


        $rules['id_contrato'] = 'required';   
        $messages['id_contrato.required'] ='Favor seleccione un tipo de contrato.'; 

        if(count($array_id_entidad) > count( $array_unique)){

            $rules['id_contrato2'] = 'required';
            $messages['id_contrato2.required'] ='Favor no seleccionar más de una vez a la misma entidad.';      

           $this->validate($request, $rules, $messages);
        }

         $request->validate([
            'entidad' => 'required',
            'id_contrato' => 'required',
            'valor_entidad' => 'required',
           ] );
        
           //dd($request->id_entidad);
           foreach ($request->id_entidad as $key => $value ) {
                        
                        $contratos_tercero = contratos_tercero::find($request->id_contratos_entidad[$key]);   
                        if($contratos_tercero == null){
                            $contratos_tercero = new contratos_tercero();   
                        }
                        $contratos_tercero->id_contrato = $request->id_contrato;

                        $contratos_tercero->id_terecero = $request->id_entidad[$key];
                        $contratos_tercero->valor_aporte= $valor_aporte[$key];
                        
                        $tercero = terceros::find($request->id_entidad[$key]);

                        $contratos_tercero->correo_electronico =$tercero->correo_electronico;
                        $contratos_tercero->param_tipo_cuenta_valor = $tercero->param_tipo_cuenta_valor;
                        $contratos_tercero->param_tipo_cuenta_texto = $tercero->param_tipo_cuenta_texto;
                        $contratos_tercero->param_banco_valor = $tercero->param_tipo_cuenta_valor;
                        $contratos_tercero->param_banco_texto = $tercero->param_tipo_cuenta_texto;
                        $contratos_tercero->numero_cuenta = $tercero->numero_cuenta;
                        $contratos_tercero->estado = 1;
                        $contratos_tercero->created_by = Auth::user()->id;
                    
                        $contratos_tercero->save();
                } 

                $respuesta['status']="success";
                $respuesta['message']="Se ha guardado la información de las partes";
                
                //return back()->with('success', 'Se ha guardado la información del contratista');

                //return redirect()->route('contratos_informacion.crear_informacion')->with('success','Se ha guardado el tercero');

            return response()->json($respuesta);
    }
   
}