<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patrimonio_bitacoras as patrimonio_bitacoras;
use App\Models\Parametricas;
use App\Models\Patrimonio_bitacoras_seguimiento as patrimonio_bitacoras_seguimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class PatrimoniosBitacorasSeguimientosController extends Controller
{
    //

    public function index_seguimiento(Request $request)
    {
        $fecha_registro = Carbon::now()->parse()->format('Y-m-d');

        $patrimonio_bitacoras = patrimonio_bitacoras::find($request->id);

        $estado_bitacora = Parametricas::where('categoria','patrimonios.bitacora.estado')
         ->whereNotIn('valor',[1])
         ->get();

        return view('patrimonios.bitacoras.index_seguimiento',compact('patrimonio_bitacoras','estado_bitacora','fecha_registro'));
    }

    public function seguimiento_store(Request $request){

      
       $fecha_registro = Carbon::now()->parse()->format('Y-m-d');

       $patrimonio_bitacoras_segumiento = patrimonio_bitacoras_seguimiento::find($request->id_bitacora_seguimiento);

       if($patrimonio_bitacoras_segumiento == null )
       {
           if(isset($request->id_bitacora_seguimiento_crear) &&  $request->id_bitacora_seguimiento_crear==1)
           {
            $patrimonio_bitacoras_segumiento = new patrimonio_bitacoras_seguimiento();
           } else
           {
               $respuesta['status']="error";
               $respuesta['message']="No tiene permiso para crear registros nuevos";
               $respuesta['objeto']= $patrimonio_bitacoras_segumiento;
               return response()->json($respuesta);
           }
       }
        $patrimonio_bitacoras = patrimonio_bitacoras::find($request->id_bitacora);
        foreach($patrimonio_bitacoras->patrimonio_bitacoras_seguimiento as $seguimiento){
              $seguimiento->estado = 0;
              $seguimiento->save();
        }
        $patrimonio_bitacoras_segumiento->id_bitacora = $request->id_bitacora;
        $patrimonio_bitacoras_segumiento->observaciones = $request->observaciones_bitacoras;
        $patrimonio_bitacoras_segumiento->param_estado_bitacora_valor = $request->estado_bitacora;
        $patrimonio_bitacoras_segumiento->param_estado_bitacora_texto = Parametricas::getTextFromValue('patrimonios.bitacora.estado', $request->estado_bitacora);
        $patrimonio_bitacoras_segumiento->fecha_registro = $fecha_registro;
        $patrimonio_bitacoras_segumiento->estado = 1;
        if($request->patrimonio_bitacoras_segumiento==0)
        {
            $patrimonio_bitacoras_segumiento->created_by = Auth::user()->id;
        }else {
            $patrimonio_bitacoras_segumiento->updated_by = Auth::user()->id;
        }
        $patrimonio_bitacoras_segumiento->save();


        $respuesta['status']="success";
        $respuesta['message']="Se ha guardado la información de la cuenta";
        $respuesta['objeto']= $patrimonio_bitacoras_segumiento;

         return response()->json($respuesta);
       }

       public function get_infoseguimiento_por_bitacora(Request $request){
        //$id_cdr=Crypt::decryptString($cdr_token);

        $seguimiento =  patrimonio_bitacoras_seguimiento::where('id_bitacora',$request->id_bitacora)
        ->get();

        return response()->json($seguimiento);
   }

   public function delete_info_seguimiento(Request $request)
   {


       $bitacora_seguimiento = patrimonio_bitacoras_seguimiento::find($request->id_bitacora_seguimiento);

       $bitacora_seguimiento ->deleted_by = Auth::user()->id;
       $bitacora_seguimiento ->save();




       $informacionlog = 'Se ha eliminado la informacion de la bitacora';
       $objetolog = [
               'user_id' => Auth::user()->id,
               'user_email' => Auth::user()->mail,
               'Objeto Eliminado' => $bitacora_seguimiento,
               ];

       Log::channel('database')->info(
           $informacionlog ,
           $objetolog
       );

       $bitacora_seguimiento ->delete();

       // $info_contra = informacion_contractuals::all();
       $respuesta['status']="success";
       $respuesta['message']="Se ha eliminado registro";
       $respuesta['objeto']=$bitacora_seguimiento;


       return response()->json($respuesta);

   }

}
