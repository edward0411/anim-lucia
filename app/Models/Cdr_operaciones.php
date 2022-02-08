<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cdrs;

class Cdr_operaciones extends Model
{
    use SoftDeletes;

    public function Cdrs_cuentas()
    {
        return $this->hasMany('App\Models\Cdrs_cuentas', 'id_cdr_cuenta' );
    }
    
}
