<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Patrimonio_bitacoras extends Model
{
    //
    use SoftDeletes;

    public function Patrimonio()
    {
        return $this->belongsTo('App\Models\Patriminios', 'id_patrimonio');
    }

    public function patrimonio_bitacoras_seguimiento(){

        return $this->hasMany('App\Models\Patrimonio_bitacoras_seguimiento','id_bitacora');
    }

}
