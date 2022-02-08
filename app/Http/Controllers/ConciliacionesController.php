<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConciliacionesController extends Controller
{
    //
    public function crear(){

        return view('conciliaciones.crear');
    }
}
