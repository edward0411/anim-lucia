<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestiones_ambientales_permisos_ambientales extends Model
{
    use SoftDeletes;

    protected $table = 'gestiones_ambientales_permisos_ambientales';

    
}