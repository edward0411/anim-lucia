<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyectos_licencias_modalidades extends Model
{
    use SoftDeletes;

    protected $table = 'proyectos_licencias_modalidades';
}