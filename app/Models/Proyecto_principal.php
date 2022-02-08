<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto_principal extends Model
{
    use SoftDeletes;

    protected $table = 'proyecto_principal';

    public function Proyectos()
    {
        return $this->hasMany('App\Models\Proyectos', 'id_proyecto_principal' );
    }
}
