<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contratos_afectacion_detalle extends Model
{
    use SoftDeletes;
    protected $table="contratos_afectacion_financiera_detalles";
   
    public function Contratos_afectacion()
    {
        return $this->belongsTo('App\Models\Contratos_afectacion', 'id_afectacion_financiera');
    }

    public function Cdrs_cuentas()
    {
        return $this->belongsTo('App\Models\Cdrs_cuentas', 'id_cdr_cuenta');
    }
}