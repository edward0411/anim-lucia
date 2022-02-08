<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestion_social_bitacora extends Model
{
    use SoftDeletes;

    protected $table = 'gestion_social_bitacora';
}
