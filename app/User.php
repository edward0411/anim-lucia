<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPassword;
use App\Notifications\EnviarNotificacion;
use App\Models\Parametricas as parametricas;
use Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $dates = ['deleted_at'];

    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    public function EnviarNotificacion($subject, $mensaje,$rutaurl)
    {
        $this->notify(new EnviarNotificacion($subject, $mensaje,$rutaurl));
    }
   
    public function DiasParaCambiarClave()
    {  
        $carbon = new Carbon($this->password_updated_at);
        $dias = $carbon->diffInDays(Carbon::now());
        $diasVencimiento = parametricas::getFromCategory('configuaracion.diasCaducidadClave')[0]->valor;
        $diasparacaducar = $diasVencimiento - $dias ;

        if ($diasparacaducar < 0){
            $subject = 'Usuario bloqueado';
            $mensaje = 'La clave de su usuario ha caducado, por favor comuniquese con un administrador para activarla.';
            $ruta = 'home';
            $this->EnviarNotificacion($subject,$mensaje, $ruta );
            Auth::logout();
        }elseif ($diasparacaducar < 5){ 
            return redirect()->route('usuarios.cambiar.contrasena')->with('error',"La clave se vencerá en $diasparacaducar días, debe cambiarla");
        }else{
            return false;
        }
    }

    public function Revision()
    {
        return $this->hasMany('App\Models\Revision', 'id_usuario_revisa' );
    }

}
