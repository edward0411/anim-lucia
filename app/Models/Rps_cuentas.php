<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Rps_cuentas extends Model
{
    use SoftDeletes;

    protected $table="rps_cuentas";

    public function Rps()
    {
        return $this->belongsTo('App\Models\Cdr_rps', 'id_rp');
    }

    public function Cuentas()
    {
        return $this->belongsTo('App\Models\Patrimonio_cuentas', 'id_cuenta');
    }

    public function Rps_movimientos()
    {
        return $this->hasMany('App\Models\rps_movimientos', 'id_rp_cuenta');
    }

    public function Rps_obls()
    {
        return $this->hasMany('App\Models\Obl_operaciones', 'id_rp_cuenta');
    }

    public function saldo_rp_cuenta()
    {
        return $this->Rps_movimientos()->sum('valor_operacion_rp');
    }

    public function valor_rp_pagos()
    {
        return $this->Rps_obls()->sum('valor_operacion_obl');
    }
    
    public function rp_cuenta_pendiente_pago()
    {
        $valor = $this->saldo_rp_cuenta() - $this->valor_rp_pagos();

        return $valor;
    }
    
}