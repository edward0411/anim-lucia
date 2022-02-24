<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terceros as terceros;
use App\Models\Contratos_terceros as contratos_tercero;

use App\Models\Departamentos as departamentos;
use App\Models\Municipios as municipios;

use App\Models\reportes\uv_reporte_convenios  as uv_reporte_convenios;
use App\Models\reportes\uv_reporte_convenios_partes_participanmtes  as uv_reporte_convenios_partes_participanmtes;

use App\Models\reportes\uv_reporte_pads as uv_reporte_pads;

use App\Models\reportes\uv_reporte_contratos as uv_reporte_contratos;
use App\Models\reportes\uv_reporte_contratos_polizas as uv_reporte_contratos_polizas;
use App\Models\reportes\uv_reporte_contratos_supervision as uv_reporte_contratos_supervision;
use App\Models\Contratos_fechas as contratos_fechas;

use App\Models\reportes\uv_reporte_proyectos as uv_reporte_proyectos;
use App\Models\reportes\uv_reporte_proyectos_fases as uv_reporte_proyectos_fases;
use App\Models\reportes\uv_reporte_proyectos_convenios as uv_reporte_proyectos_convenios;
use App\Models\reportes\uv_reporte_proyectos_caracteristicas as uv_reporte_proyectos_caracteristicas;
use App\Models\reportes\uv_reporte_proyectos_actividades as uv_reporte_proyectos_actividades;
use App\Models\reportes\uv_reporte_proyectos_actividades_planeacion as uv_reporte_proyectos_actividades_planeacion;

use App\Models\reportes\uv_reporte_patrimonios_movimientos as uv_reporte_patrimonios_movimientos;
use App\Models\reportes\uv_reporte_cdr_movimientos as uv_reporte_cdr_movimientos;
use App\Models\reportes\uv_reporte_rps_movimientos as uv_reporte_rps_movimientos;
use App\Models\reportes\uv_reporte_obligaciones_movimientos as uv_reporte_obligaciones_movimientos;
use App\Models\reportes\uv_reporte_endosos_movimientos as uv_reporte_endosos_movimientos;
use  App\Models\reportes\uv_reporte_proyectos_fases_ejecucion_a_hoy as uv_reporte_proyectos_fases_ejecucion_a_hoy;
use App\User as users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ProyectosApiController extends Controller
{
    //
    public function get_convenios(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_convenios::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

    public function get_convenios_partes_participantes(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_convenios_partes_participanmtes::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

    public function get_pads(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_pads::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }
    
    public function get_contratos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_contratos::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

    public function get_contratos_polizas(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_contratos_polizas::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

    public function get_contratos_supervision(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $Contratos = uv_reporte_contratos_supervision::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($Contratos);
    }

            
    public function get_terceros(){
        //$id_cdr=Crypt::decryptString($cdr_token);
    
        $integrantes = terceros::all();
        return response()->json($integrantes);
    }

    public function get_contratos_terceros()
    {
        $contratos_tercero = contratos_tercero::all();        
        return response()->json($contratos_tercero);
    }

    public function get_contratos_fechas()
    {
        $contratos_fechas = contratos_fechas::all();        
        return response()->json($contratos_fechas);
    }
        
    public function get_proyectos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_proyectos_caracteristicas(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_caracteristicas::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_proyectos_convenios(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_convenios::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_fases(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_fases::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }


    public function get_actividades(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_actividades::all();


        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }


    public function get_actividades_planeacion(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_actividades_planeacion::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }


    public function get_ejecucion_a_hoy(Request $request)
    {
        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_proyectos_fases_ejecucion_a_hoy::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }




    

    public function get_reporte_patrimonios_movimientos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_patrimonios_movimientos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_reporte_cdr_movimientos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_cdr_movimientos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_reporte_rps_movimientos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_rps_movimientos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_reporte_obligaciones_movimientos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_obligaciones_movimientos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    public function get_reporte_endosos_movimientos(Request $request)
    {

        //$id_cdr=Crypt::decryptString($cdr_token);

        $proyectos = uv_reporte_endosos_movimientos::all();

        // $info_contra = informacion_contractuals::all();
        return response()->json($proyectos);
    }

    
    public function get_reporte_tabla(string $table)
    {
        //ini_set("memory_limit","256M");
        //ini_set("memory_limit","512M");      
        ini_set('memory_limit', '-1');
        //$actualizacion_estado = DB::select('call usp_contratos_fecha_actualizar_estado_contrato()');
        $results = DB::select("SELECT count(*) as cuenta FROM information_schema.tables where table_type in ('BASE TABLE','VIEW') and table_name = ?",array($table));

        if($results[0]->cuenta<1){
            return response()->json($results);
        }
        
        //$id_cdr=Crypt::decryptString($cdr_token);
        //$results = DB::select( DB::raw("SELECT * FROM ".$table." WHERE deleted_at is null"));

        $results = DB::select("SELECT * ,now() as fecha_generacion_reporte  FROM ".$table." WHERE deleted_at is null");
      
        // $info_contra = informacion_contractuals::all();
        return response()->json($results);
    }

    

}
