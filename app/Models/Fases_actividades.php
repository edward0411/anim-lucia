<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fases_actividades extends Model
{
    use SoftDeletes;

    protected $table = 'fases_actividades';
}
