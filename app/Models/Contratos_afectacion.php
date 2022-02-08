<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contratos_afectacion extends Model
{
    use SoftDeletes;

    protected $table="contratos_afectacion_financiera";

   
    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }

    public function Cdrs()
    {
        return $this->belongsTo('App\Models\Cdrs', 'id_cdr');
    }

    public function Contratos_afectacion_detalle()
    {
        return $this->hasMany('App\Models\Contratos_afectacion_detalle', 'id_afectacion_financiera' );
    }
}