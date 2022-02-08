<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gestiones_ambientales extends Model
{
    use SoftDeletes;

    protected $table = 'gestiones_ambientales';

    
}