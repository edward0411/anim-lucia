<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Endoso extends Model
{
    use SoftDeletes;

    protected $table="endoso";

    public function Tercero()
    {
        return $this->belongsTo('App\Models\Terceros', 'id_tercero');
    }

    public function Obl_operaciones()
    {
        return $this->belongsTo('App\Models\Obl_operaciones', 'id_obl');
    }
}
