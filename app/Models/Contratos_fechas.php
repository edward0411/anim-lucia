<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contratos_otrosi as contratos_otrosi;
use Illuminate\Support\Facades\DB;


class Contratos_fechas extends Model
{
    //
    //  
    use SoftDeletes;

    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }

    public function actualizar_fecha_terminacion_actual($id_usuario)
    {
        $this->fecha_terminacion_actual = $this->fecha_terminacion;
        $this->save();

            $ejec =  DB::select('call usp_contratos_fecha_actualizar_fecha_terminacion_actual_bucle(?,?)',array($this->id_contrato,$id_usuario));
        
    }

    public function actualizar_valor_contrato_actual($id_usuario){
            $ejec =  DB::select('call usp_contratos_fecha_actualizar_valor_actual(?,?)',array($this->id_contrato,$id_usuario));
    }

}
