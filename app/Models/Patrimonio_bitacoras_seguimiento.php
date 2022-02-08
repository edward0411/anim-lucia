<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Patrimonio_bitacoras_seguimiento extends Model
{
    //
    use SoftDeletes;

    protected $table="patrimonio_bitacoras_seguimiento";

    public function Patrimonio_bitacoras()
    {
        return $this->belongsTo('App\Models\Patrimonio_bitacoras', 'id_bitacora');
    }


}
