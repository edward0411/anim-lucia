<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Patrimonio_cuentas extends Model
{
    //
    use SoftDeletes;

    public function Patrimonio_cuenta_movimientos()
    {
        return $this->hasMany('App\Models\Patrimonio_cuenta_movimientos', 'id_cuenta' );
    }

    public function Cdrs_movimientos()
    {
        return $this->hasMany('App\Models\Cdrs_movimientos', 'id_cuenta' );
    }

    public function rps_cuentas()
    {
        return $this->hasMany('App\Models\Rps_cuentas', 'id_cuenta' );
    }

    public function Patrimonios()
    {
        return $this->belongsTo('App\Models\Patrimonios','id_patrimonio');
    }


    public function get_saldo_cuenta(){

        $suma_saldo = $this->Patrimonio_cuenta_movimientos->sum('valor');

        return $suma_saldo;
    }

    public function get_movimento_cuenta(){

        $suma_saldo = $this->Patrimonio_cuenta_movimientos->whereIn('id_param_tipo_movimiento',array(1,2))->sum('valor');

        return $suma_saldo;
    }
    public function get_redimiento_cuenta(){

        $suma_saldo = $this->Patrimonio_cuenta_movimientos->whereIn('id_param_tipo_movimiento',3)->sum('valor');

        return $suma_saldo;
    }
}
