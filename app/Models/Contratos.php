<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contratos extends Model
{
    //
    use SoftDeletes;


    protected $casts = [
        'valor_contrato' => 'decimal:2',
    ];


    public function Contratos_cdrs()
    {
        return $this->hasMany('App\Models\Contratos_cdrs', 'id_contrato' );
    }
    public function contratos_terceros()
    {
        return $this->hasMany('App\Models\Contratos_terceros', 'id_contrato' );
    }
    public function contratos_fechas()
    {
        return $this->hasMany('App\Models\Contratos_fechas', 'id_contrato' );
    }
    public function contratos_supervisores()
    {
        return $this->hasMany('App\Models\Contratos_supervisores', 'id_contrato' );
    }
    public function contratos_comites()
    {
        return $this->hasMany('App\Models\Contratos_comites', 'id_contrato' );
    }
  
    public function contratos_otrosi()
    {
        return $this->belongsTo('App\Models\Contratos_otrosi', 'id_contrato');
    }


    public function patrimonios()
    {
        return $this->hasMany('App\Models\Patrimonios', 'id_contrato' );
    }
    public function contratos_pads_convenios()
    {
        return $this->hasMany('App\Models\Contratos_pads_convenios', 'id_contrato_pad');
    }

    public function contratos_terminaciones()
    {
        return $this->hasMany('App\Models\Contratos_terminaciones', 'id_contrato');
    }



    public function cambiar_estado($id_nuevo_estado){
        
        $this->param_valor_estado_contrato = $id_nuevo_estado;
        $this->param_texto_estado_contrato = Parametricas::getTextFromValue('contratos.estados_contrato', $id_nuevo_estado);
        $this->save();
    }

}
