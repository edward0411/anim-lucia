<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ReporteGestionnesSocialesController extends Controller
{
public function index(){

    $proyectos = DB::table('gestiones_sociales')
    ->join('gestiones_sociales_sociales','gestiones_sociales_sociales.id_gestiones_sociales','=','gestiones_sociales.id')
    ->Join('proyectos','gestiones_sociales.id_proyecto','=','proyectos.id')
    ->whereNull('gestiones_sociales.deleted_at')
    ->select('gestiones_sociales.id','proyectos.nombre_proyecto')
    ->get();
    // dd($proyectos);
      $search = [];


    return view('reportes.reporte_gestiones_sociales.index',compact('proyectos','search'));
   }

   public function busqueda_gestiones_sociales(Request $request){

    $active = true;
        $search = [];
        $olddata =$request->all();

        if (($request->fecha_hasta != null) && ($request->fecha_desde != null)) {
   
            if ($request->fecha_hasta < $request->fecha_desde) {

                return redirect()->route('reportes.reporte_gestion_ambiental_fuentes.index')->with('error','Por favor validar que la fecha hasta no sea inferior a la fecha desde')->withInput($request->input());
             }
          }
          $proyectos = DB::table('gestiones_sociales')
          ->join('gestiones_sociales_sociales','gestiones_sociales_sociales.id_gestiones_sociales','=','gestiones_sociales.id')
          ->Join('proyectos','gestiones_sociales.id_proyecto','=','proyectos.id')
          ->whereNull('gestiones_sociales.deleted_at')
          ->select('gestiones_sociales.id','proyectos.nombre_proyecto')
          ->get();

          $id_proyecto = $request->id_proyecto;

          $consulta = DB::table('gestiones_sociales')
        ->join('gestiones_sociales_sociales','gestiones_sociales_sociales.id_gestiones_sociales','=','gestiones_sociales.id')
        ->Join('proyectos','gestiones_sociales.id_proyecto','=','proyectos.id')
        ->leftJoin('proyectos_personas','proyectos_personas.id_proyecto','=','proyectos.id')
        ->where('proyectos_personas.param_tipo_rol_valor',1)
        ->leftJoin('proyecto_principal','proyecto_principal.id','=','proyectos.id_proyecto_principal')
        ->leftJoin('proyectos_caracteristicas','proyectos_caracteristicas.id_proyecto','=','proyectos.id')
        ->where('proyectos_caracteristicas.param_tipo_proyecto_caracteristica_valor',17)
        ->Join('fases_relaciones_contratos','gestiones_sociales.id_fases_relaciones_contratos','=','fases_relaciones_contratos.id')
        ->Join('users','gestiones_sociales.id_usuario','=','users.id')
        ->Join('contratos','fases_relaciones_contratos.id_contrato','contratos.id')
        ->whereNull('gestiones_sociales.deleted_at')
        ->select('gestiones_sociales.id','proyectos.nombre_proyecto','users.name','gestiones_sociales.fecha_informe',
        'gestiones_sociales_sociales.param_caracteristicas_texto',
        'gestiones_sociales_sociales.valor','gestiones_sociales_sociales.observaciones','contratos.numero_contrato','proyecto_principal.nombre_proyecto_principal','proyectos_caracteristicas.decripcion_proyecto','proyectos_personas.para_tipo_subdireccion_texto');

        if ($request->id_proyecto != null){
 
            $consulta = $consulta->where('gestiones_sociales.id',$id_proyecto);

        }
        if ($request->fecha_hasta != null){
   
            $consulta = $consulta->where('fecha_informe','<=',$request->fecha_hasta);

        }
        if ($request->fecha_desde != null){

            $consulta = $consulta->where('fecha_informe','>=',$request->fecha_desde);
        }
        $consulta = $consulta->get();
        $search = $consulta->toArray();
        //dd($search);


    return view('reportes.reporte_gestiones_sociales.index',compact('search','olddata','proyectos','active'));
   }
}
