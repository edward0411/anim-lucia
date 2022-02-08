<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revision extends Model
{
    use SoftDeletes;

    protected $table="revision";

    public function Users()
    {
        return $this->belongsTo('App\User', 'id_usuario_revisa');
    }
}