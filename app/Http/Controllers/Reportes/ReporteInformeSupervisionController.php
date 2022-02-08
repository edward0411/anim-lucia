<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto_principal as proyectos;
use App\Models\Proyectos as proyecto_fase;
use Carbon\Carbon;
use App\Models\semanas_parametrica as semanas_parametrica;
use App\Models\Fases_Informe_semanal as informe_semanal;
use Illuminate\Support\Facades\DB;


class ReporteInformeSupervisionController extends Controller
{
    public function index()
    {
        $search = [];

        $proyectos = proyectos::select('id','nombre_proyecto_principal')
        ->whereNull('deleted_at')
        ->get();

      
        return view('reportes.reporte_informe_supervision.index',compact('search','proyectos'));
    }

    public function busqueda(Request $request)
    {
        $hoy = Carbon::now()->format('Y-m-d');

        $id_semanas_parametrica = semanas_parametrica::where('fecha_inicial', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->select('id','fecha_inicial','fecha_fin')
            ->first();

        $id_semana = $id_semanas_parametrica->id;

        $consulta = proyectos::select(
            'proyecto_principal.id as id_proyecto',
            'proyecto_principal.nombre_proyecto_principal as nombre_proyecto'
        )
        ->where('proyecto_principal.deleted_at');
        if ($request->id_proyecto != null ) {
          $consulta = $consulta->whereIn('proyecto_principal.id',$request->id_proyecto);
        }
        $consulta = $consulta->get();
       
       
       foreach ($consulta as  $value) {
         
            $fases = proyecto_fase::where('id_proyecto_principal',$value->id_proyecto)
            ->where('proyectos.deleted_at')
            ->select(
                'proyectos.id as id_proyecto_fase',
                'proyectos.nombre_proyecto as nombre_proyecto_fase'
            )->get();

            $value->fases = $fases;
       }

        foreach ($consulta as $value) {

           // dd($value);

            foreach($value->fases as $item)
            {
               

                $fases = DB::select('call usp_proyecto_consultarAvanceFase(?)',array($item->id_proyecto_fase));

                $count = count($fases);

                $programado = 0;
                $ejecutado = 0;

                $bitacora = [];

                foreach ($fases as $fase) {

                        $datos = informe_semanal::join('fases_informe_semanal_bitacora','fases_informe_semanal_bitacora.id_fases_Informe_semanal','=','fases_informe_semanal.id')
                        ->where('fases_informe_semanal.id_fase',$fase->id)
                        ->where('fases_informe_semanal.id_semana_parametrica',$id_semana)
                        ->where('fases_informe_semanal.deleted_at')
                        ->where('fases_informe_semanal_bitacora.deleted_at')
                        ->get();

                    if (count($datos) > 0) {
                        array_push ( $bitacora , $datos );
                    }

                        $programado = $programado + $fase->porcentaje_programado;
                        $ejecutado = $ejecutado + $fase->porcentaje_ejecutado;             
                }

                $item->bitacoras = $bitacora;
                if ($programado > 0) {
                    $item->programado = $programado/$count;
                }else {
                    $item->programado = 0;
                }

                if ($ejecutado > 0) {
                    $item->ejecutado = $ejecutado/$count;
                }else {
                    $item->ejecutado = 0;
                }

            }
        }

        $search = $consulta;

        $fecha_impresion = Carbon::now()->format('Y-m-d');

        $fecha1 = $id_semanas_parametrica->fecha_inicial;
        $fecha2 = $id_semanas_parametrica->fecha_fin;

        $dia1 = Carbon::parse($fecha1)->format('d');
        $dia2 = Carbon::parse($fecha2)->format('d');
        $anio = Carbon::parse($fecha2)->format('Y');

        

        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($fecha1);
        $fecha->format("F"); // Inglés.
        $mes1 = $fecha->formatLocalized('%B');

        $fecha = Carbon::parse($fecha2);
        $fecha->format("F"); // Inglés.
        $mes2 = $fecha->formatLocalized('%B');

        return view('reportes.reporte_informe_supervision.busqueda',compact('search','fecha_impresion','dia1','dia2','mes1','mes2','anio'));

    }
}
