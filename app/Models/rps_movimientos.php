<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class rps_movimientos extends Model
{
    use SoftDeletes;

    protected $table="rp_operaciones";

    public function Rps_cuentas()
    {
        return $this->belongsTo('App\Models\Rps_cuentas', 'id_rp_cuenta');
    }
}