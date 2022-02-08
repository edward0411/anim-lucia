<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cdrs_movimientos;
use App\Models\rps_movimientos as rp_movimientos;
use Illuminate\Support\Facades\DB;

class Cdrs extends Model
{
    //
    use SoftDeletes;

    public function Cdr_cuentas()
    {
        return $this->hasMany('App\Models\Cdr_cuentas', 'id_cdr' );
    }

    public function Cdr_rps()
    {
        return $this->hasMany('App\Models\Cdr_rps', 'id_cdr' );
    }

    public function Contratos_afectacion()
    {
        return $this->hasMany('App\Models\Contratos_afectacion', 'id_cdr' );
    }

    public function Cdr_cuentas_operaciones()
    {
        return $this->hasManyThrough(
            'App\Models\Cdr_operaciones',
            'App\Models\Cdrs_cuentas', 
            'id_cdr', 
            'id_cdr_cuenta', 
            'id', 
            'id'
        );
    }

    public function saldo_cdr()
    {
        return $this->Cdr_cuentas_operaciones()->sum('valor_operacion');
    }


    public function cdr_movimientos()
    {
        return $this->hasManyThrough(
            'App\Models\rps_movimientos',
            'App\Models\Cdr_rps', 
            'id_cdr', 
            'id_rp', 
            'id', 
            'id'
        );
    }

    public function rp_cuentas()
    {
        return $this->hasManyThrough(
            'App\Models\Rps_cuentas',
            'App\Models\Cdr_rps', 
            'id_cdr', 
            'id_rp', 
            'id', 
            'id'
        );
    }

    public function comprometido()
    {
        $cuentas = $this->rp_cuentas()->select('rps_cuentas.id')->get();
        $compromiso = 0;
            foreach($cuentas as $item){
                $id_relacion = $item->id;
                $valores = rp_movimientos::where('id_rp_cuenta',$id_relacion)
                ->select(DB::raw('Sum(valor_operacion_rp) as valor_operacion'))
                ->get();
                    foreach($valores as $valor){
                        $compromiso = $compromiso + $valor->valor_operacion;
                    }    
            }
        return $compromiso;
    }

    public function Por_comprometer()

    {
        return $this->saldo_cdr() - $this->comprometido();
    }

    
}
