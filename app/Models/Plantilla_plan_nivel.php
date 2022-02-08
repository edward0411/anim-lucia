<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla_plan_nivel extends Model
{
    use SoftDeletes;

    protected $table="plantilla_plan_nivel";

    public function Plantilla_plan()
    {
        return $this->belongsTo('App\Models\Plantilla_plan', 'id_plantilla_plan' );
    }

    public function Plantilla_plan_nivel_dos()
    {
        return $this->hasMany('App\Models\Plantilla_plan_nivel_dos', 'id_plantilla_plan_nivel' );
    }

}
