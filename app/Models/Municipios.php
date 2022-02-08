<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    //

      use SoftDeletes;

      protected $table="municipios";

     public function departamento(){
      return $this->hasOne(Departamentos::class,'id','id_departamento');
  }
    
}
