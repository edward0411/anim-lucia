<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terceros_cuentas_bancarias extends Model
{
    //

    protected $table = 'terceros_cuentas_bancarias';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable=
    [
        'id_tercero',
        'param_tipo_cuenta_valor',
        'param_tipo_cuenta_texto',
        'param_banco_valor',
        'param_banco_texto',
        'numero_cuenta',
        'estado'];

        protected $guarded = [

        ];
}
