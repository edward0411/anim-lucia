<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla_plan extends Model
{
    use SoftDeletes;

    protected $table="plantilla_plan";

    public function Plantilla_plan_nivels()
    {
        return $this->hasMany('App\Models\Plantilla_plan_nivel', 'id_plantilla_plan' );
    }

}
