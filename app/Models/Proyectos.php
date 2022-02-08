<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyectos extends Model
{
    use SoftDeletes;

    public function Fases()
    {
        return $this->hasMany('App\Models\Fases', 'id_proyecto' );
    }

    public function Proyecto_principal()
    {
        return $this->belongsTo('App\Models\Proyecto_principal', 'id' );
    }
}
