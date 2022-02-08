<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cdrs_cuentas extends Model
{
    use SoftDeletes;

    protected $table="cdrs_cuentas";

    public function Cdr_operaciones()
    {
        return $this->hasMany('App\Models\Cdr_operaciones', 'id_cdr_cuenta' );
    }

    public function Contratos_afectacion_detalle()
    {
        return $this->hasMany('App\Models\Contratos_afectacion_detalle', 'id_cdr_cuenta' );
    }

    public function cdrs()
    {
        return $this->belongsTo('App\Models\Cdrs', 'id_cdr');
    }
    
    public function saldo_cuenta_cdr()
    {
        return $this->Cdr_operaciones()->sum('valor_operacion');
    }


}