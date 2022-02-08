<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contratos_otrosi extends Model
{
    //
    //  
    
    use SoftDeletes;

    protected $table="contratos_otrosi";

    protected $casts = [
        'valor_adicion' => 'decimal:2',
    ];

    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }

}
