<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Plantilla_plan_patrimonio extends Model
{
    //
    use SoftDeletes;

    protected $table="plantilla_plan_patrimonio";
}
