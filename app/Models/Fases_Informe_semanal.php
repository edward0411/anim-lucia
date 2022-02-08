<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fases_Informe_semanal extends Model
{
    use SoftDeletes;

    protected $table = 'fases_Informe_semanal';
}