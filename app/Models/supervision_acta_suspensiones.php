<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supervision_acta_suspensiones extends Model
{
    use SoftDeletes;

    protected $table = 'supervision_acta_suspensiones';
}