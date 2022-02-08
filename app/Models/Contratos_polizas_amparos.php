<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contratos_polizas_amparos extends Model
{
    //
    //  
    use SoftDeletes;

    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos_polizas', 'id_contratos_polizas');
    }

}
