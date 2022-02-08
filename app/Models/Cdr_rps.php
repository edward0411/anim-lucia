<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cdr_rps extends Model
{
    use SoftDeletes;

    protected $table="rps";

    public function Rps_cuentas()
    {
        return $this->hasMany('App\Models\Rps_cuentas', 'id_rp' );
    }

    public function Rps_movimientos()
    { 
        return $this->hasManyThrough(
        'App\Models\rps_movimientos',
        'App\Models\Rps_cuentas', 
        'id_rp', 
        'id_rp_cuenta', 
        'id', 
        'id'
       );  
    }

    public function cdrs()
    {
        return $this->belongsTo('App\Models\Cdrs','id_cdr');
    }

    
    public function saldo_rp()
    {
        return $this->Rps_movimientos()->sum('valor_operacion_rp');
    }

    public function terceros()
    {
        return $this->belongsTo('App\Models\Terceros', 'id_tercero');
    }

}
