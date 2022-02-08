<?php

namespace App\Http\Controllers;

use App\Models\Parametricas;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $respuesta =Auth::user()->DiasParaCambiarClave();
        //dd( $respuesta);
        // dd()
        if($respuesta){
            return  $respuesta;
        }else{
            $reporte = Parametricas::getTextFromValue("tableros.tableroprincipal",'1');
           
            return view('home',compact('reporte'));
        }

    }
    public function index_reportes(){

        return view('reportes.index');
    }
}
