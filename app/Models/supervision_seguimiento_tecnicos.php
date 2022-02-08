<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supervision_seguimiento_tecnicos extends Model
{
    use SoftDeletes;

    protected $table = 'supervision_seguimiento_tecnicos';
}