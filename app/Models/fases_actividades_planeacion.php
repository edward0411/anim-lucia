<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fases_actividades_planeacion extends Model
{
    use SoftDeletes;

    protected $table = 'fases_actividades_planeacion';
}