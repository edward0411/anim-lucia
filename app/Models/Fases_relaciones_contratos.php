<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fases_relaciones_contratos extends Model
{
    use SoftDeletes;

    protected $table = 'fases_relaciones_contratos';
}
