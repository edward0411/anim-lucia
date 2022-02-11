<?php namespace app\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Contratos as m_contratos;
use App\Models\Contratos_fechas;
use App\Models\Contratos_polizas;


trait Contratos
{
    public function UpdateDateInitial($id)
    {
        $contrato = m_contratos::find($id);
        $fechas = $contrato->contratos_fechas()->first();
        $array_fechas = [];

        $polizas = Contratos_polizas::where('id_contrato',$id)->get();

        if ($fechas->requiere_acta_inicio == 1) {
           $contrato_fechas = Contratos_fechas::where('id_contrato',$id)->first();
           $contrato_fechas->fecha_inicio = $fechas->fecha_acta_inicio;
           $contrato_fechas->save();
        }else{
            $fecha_firma = $fechas->fecha_firma;
            if ($fechas->fecha_firma != null) {
                array_push($array_fechas,$fechas->fecha_firma);
            }
            if ($fechas->requiere_arl != null) {
                array_push($array_fechas,$fechas->fecha_arl);
            }

            if (count($polizas) > 0) {
               foreach ($polizas as $poliza) {
                    array_push($array_fechas,$poliza->fecha_aprobacion);
               }
            }
        }

        sort($array_fechas, SORT_STRING);

        $fecha_inicio = end($array_fechas);

        $contrato_fechas = Contratos_fechas::where('id_contrato',$id)->first();
        $contrato_fechas->fecha_inicio =  $fecha_inicio;
        $contrato_fechas->save();

        return true;


    }
}