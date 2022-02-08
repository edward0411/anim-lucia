<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contratos_cdrs extends Model
{
    //
    use SoftDeletes;

    public function Cdr()
    {
        return $this->belongsTo('App\Models\Cdrs', 'id_cdr');
    }
    public function Patrimonio_cuenta()
    {
        return $this->belongsTo('App\Models\Patrimonio_cuentas', 'id_cuenta');
    }


}
