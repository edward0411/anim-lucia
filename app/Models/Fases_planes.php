<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fases_planes extends Model
{
    use SoftDeletes;

    protected $table = 'fases_planes';

    public function Fases()
    {
        return $this->belongsTo('App\Models\Fases', 'id_fase');
    }
}
