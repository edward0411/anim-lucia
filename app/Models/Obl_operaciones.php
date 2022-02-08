<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Obl_operaciones extends Model
{
    //

    use SoftDeletes;

    protected $table="obl_operaciones";

    public function rp_cuentas()
    {
        return $this->belongsTo('App\Models\Rps_cuentas', 'id_rp_cuenta');
    }

    public function Endoso()
    {
        return $this->hasMany('App\Models\Endoso', 'id_obl' );
    }

    public function suma_obl()
    {
        return $this->Endoso()->sum('valor_endoso');
    }
}
