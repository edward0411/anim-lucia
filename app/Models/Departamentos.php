<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    //
    use SoftDeletes;
    

    protected $table="departamentos";

    public function municipios(){
      return $this->hasOne(Municipios::class,'id','id_departamento');
    } 
}
