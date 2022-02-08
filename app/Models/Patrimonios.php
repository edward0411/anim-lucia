<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patrimonios extends Model
{
    use SoftDeletes;

    public function patrimonio_bitacoras()
    {
        return $this->hasMany('App\Models\Patrimonio_bitacoreas', 'id_patrimonio' );
    }

    public function patrimonio_cuentas()
    {
        return $this->hasMany('App\Models\Patrimonio_cuentas', 'id_patrimonio' );
    }

    public function Contratos_pads()
    {
        return $this->belongsTo('App\Models\Contratos','id_contrato_pad');
    }


    public function patrimonios_cuentas_movimientos()
    {
        return $this->hasManyThrough(
            'App\Models\Patrimonio_cuenta_movimientos',
            'App\Models\Patrimonio_cuentas',
            'id_patrimonio',
            'id_cuenta',
            'id',
            'id'
        );
    }

    public function saldo_patrimonio()
    {
        return $this->patrimonios_cuentas_movimientos()->sum('valor');
    }
    public function saldo_movimientos_patrimonio()
    {
        return $this->patrimonios_cuentas_movimientos()->whereIn('id_param_tipo_movimiento',array(1,2))->sum('valor');
    }
}
