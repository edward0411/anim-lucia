<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Terceros extends Model
{

    //

    use SoftDeletes;


    protected $table = 'terceros';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable=
    [
        'nombre',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'param_tipodocumento_valor',
        'param_tipodocumento_texto',
        'identificacion',
        'param_naturaleza_juridica_valor',
        'param_naturaleza_juridica_texto',
        'direccion',
        'telefono',
        'representante_legal',
        'param_tipodocumento_rep_valor',
        'param_tipodocumento_rep_texto',
        'identificacion_representante',
        'correo_electronico',
        'estado'];

        protected $guarded = [

        ];


    public function contratos_terceros()
    {
        return $this->hasMany('App\Models\Contratos_terceros', 'id_terecero' );
    }
    public function contratos_supervisores()
    {
        return $this->hasMany('App\Models\Contratos_supervisores', 'id_terecero' );
    }
    public function contratos_comites()
    {
        return $this->hasMany('App\Models\Contratos_comites', 'id_terecero' );
    }

    public function rps()
    {
        return $this->hasMany('App\Models\Cdr_rps', 'id_tercero' );
    }

    public function Endoso()
    {
        return $this->hasMany('App\Models\Endoso', 'id_tercero' );
    }
    
}
