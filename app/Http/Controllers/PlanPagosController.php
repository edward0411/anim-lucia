<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terceros as terceros;

class PlanPagosController extends Controller
{
    //

    public function index(Request $request){


        $terceros = terceros::all();

        return view('cdr.rps.cuentas.obligaciones_pagos.plan_pagos.index',compact('terceros'));
    }
}
