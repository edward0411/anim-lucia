<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contratos_pads_convenios extends Model
{
    use SoftDeletes;

    protected $table="contratos_pads_convenios";

    public function Convenios()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato_convenio');
    }

    public function Pads()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato_pad');
    }
}