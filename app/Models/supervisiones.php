<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supervisiones extends Model
{
    use SoftDeletes;

    protected $table = 'supervisiones';
}