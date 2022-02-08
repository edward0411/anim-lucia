<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompromisosController extends Controller
{
    //

    public function index(){

        return view('compromisos.index');
    }

    public function crear(){

        return view('compromisos.crear');
    }

    public function agregar_pagos(){

        return view('compromisos.agregar_pagos');
    }

    public function store(Request $request){

        dd($request);

        return redirect()->route('compromisos.index')->with('success','Informacion guadada de forma exitosa');
    }
}
