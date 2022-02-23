<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patrimonios extends Model
{
    use SoftDeletes;

    public function Contratos_pads()
    {
        return $this->belongsTo('App\Models\Contratos','id_contrato_pad');
    }

    public function patrimonio_bitacoras()
    {
        return $this->hasMany('App\Models\Patrimonio_bitacoreas', 'id_patrimonio' );
    }

    public function patrimonio_cuentas()
    {
        return $this->hasMany('App\Models\Patrimonio_cuentas', 'id_patrimonio' );
    }

    public function patrimonio_valor_cdr()
    {
        return $this->hasMany(Uv_valor_cdr::class, 'id_patrimonio' );
    }

    public function patrimonio_valor_rp()
    {
        return $this->hasMany(Uv_valor_rp::class, 'id_patrimonio' );
    }

    public function patrimonio_valor_pagado_rp()
    {
        return $this->hasMany(Uv_valor_pagado_rp::class, 'id_patrimonio' );
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

    public function valor_convenio_cuentas()
    {
        return $this->patrimonio_cuentas()->sum('valor_asignado');
    }

    public function patrimonio_aportes()
    {
        return $this->patrimonios_cuentas_movimientos()->whereIn('id_param_tipo_movimiento',array(1,2))->sum('valor');
    }

    public function patrimonio_rendimientos()
    {
        return $this->patrimonios_cuentas_movimientos()->where('id_param_tipo_movimiento',3)->sum('valor');
    }

    public function suma_valor_cdr()
    {
        return $this->patrimonio_valor_cdr()->sum('valor_cdr');
    }

    public function suma_valor_rp()
    {
        return $this->patrimonio_valor_rp()->sum('valor_rp');
    }

    public function suma_valor_pagado_rp()
    {
        return $this->patrimonio_valor_pagado_rp()->sum('valor_pagado');
    }

    
}
