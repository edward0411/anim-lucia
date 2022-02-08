<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supervision_acciones_correctivas extends Model
{
    use SoftDeletes;

    protected $table = 'supervision_acciones_correctivas';
}