<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Patrimonio_cuenta_movimientos extends Model
{
    //
    use SoftDeletes;

    public function Patrimonio_cuenta()
    {
        return $this->belongsTo('App\Models\Patrimonio_cuenta', 'id_cuenta' );
    }

}
