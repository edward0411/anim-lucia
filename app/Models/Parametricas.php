<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametricas extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function getTextFromValue($categoria, $valor){
        $texto= Parametricas::Where('categoria',$categoria)->Where('valor',$valor)->Select('texto')->first();
        return $texto->texto ?? null;
    }

    public static function getFromCategory($categoria){
        $parametricas = parametricas::Where('categoria', $categoria)
        ->orderBy('orden')
        ->select("valor", 'texto')
        ->get();
        return $parametricas;
    }

    
}
