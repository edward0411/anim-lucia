<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla_plan_nivel_dos extends Model
{
    //
    use SoftDeletes;

    protected $table="plantilla_plan_nivel_dos";

    public function Plantilla_plan_nivel()
    {
        return $this->belongsTo('App\Models\Plantilla_plan_nivel', 'id_plantilla_plan_nivel' );
    }

    public function Plantilla_plan_subnivels()
    {
        return $this->hasMany('App\Models\Plantilla_plan_subnivel', 'id_plantilla_plan_nivel_dos' );
    }


}
