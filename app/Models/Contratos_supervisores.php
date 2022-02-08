<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contratos_supervisores extends Model
{
    //
    //  
    use SoftDeletes;

    public function Tercero()
    {
        return $this->belongsTo('App\Models\Terceros', 'id_terecero');
    }
    public function Contrato()
    {
        return $this->belongsTo('App\Models\Contratos', 'id_contrato');
    }



}
