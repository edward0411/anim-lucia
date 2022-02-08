<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Parametricas as parametricas;
use Illuminate\Support\Str; 

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    // Evitar login fallados repetidas veces
    protected $maxAttempts = 3; // De manera predeterminada sería 5
    protected $decayMinutes = 5; // De manera predeterminada sería 1

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $intentosAcceso  =   parametricas::getFromCategory('configuaracion.IntentosBloquearClave')[0]->valor;
        $maxAttempts =  $intentosAcceso;
        
        $this->middleware('guest')->except('logout');

    }
}
