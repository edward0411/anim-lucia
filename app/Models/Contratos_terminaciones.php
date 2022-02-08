<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contratos_terminaciones extends Model
{
    use SoftDeletes;

    protected $table="contratos_terminaciones";

   
    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }
}
