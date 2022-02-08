<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan_subnivel_cdr extends Model
{
    use SoftDeletes;

    protected $table="plan_subnivel_patrimonio_cdr";
}