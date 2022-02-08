<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestion_ambiental_bitacora extends Model
{
    use SoftDeletes;

    protected $table = 'gestiones_ambientales_bitacora';
}
