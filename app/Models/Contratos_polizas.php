<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contratos_polizas extends Model
{
    //
    //  
    use SoftDeletes;

    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }

    public function Contratos_polizas_amparos()
    {
        return $this->hasMany('App\Models\Contratos_polizas_amparos', 'id_contratos_polizas' );
    }

}
