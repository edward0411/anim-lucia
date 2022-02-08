<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class semanas_parametrica extends Model
{
    use SoftDeletes;

    protected $table = 'semanas_parametrica';
}
