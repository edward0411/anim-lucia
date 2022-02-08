<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto_convenios extends Model
{
    use SoftDeletes;

    protected $table = 'proyectos_convenios';
}