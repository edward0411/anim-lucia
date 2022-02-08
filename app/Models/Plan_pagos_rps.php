<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan_pagos_rps extends Model
{
     //
     use SoftDeletes;

     protected $table="plan_pagos_rps";
 
}
