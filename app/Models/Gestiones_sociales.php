<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestiones_sociales extends Model
{
    use SoftDeletes;

    protected $table = 'gestiones_sociales';

    
}