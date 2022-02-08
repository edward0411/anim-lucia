<?php

namespace App\Http\Controllers;

use App\Models\Parametricas;
use Illuminate\Http\Request;
use Auth;

class TablerosControlController extends Controller
{

        public function index()
        {


                $token = Auth::user()->api_token;

                $reportes = Parametricas::where('categoria', "tableros.tablerosListado")->get();
                //dd($reportes);
                return view('tableros_control.index', compact('reportes','token'));
        }
        public function view(string $id_tablero)
        {

                //$reporte = Parametricas::getTextFromValue("tableros.tablerosListado",$id_tablero);
                $reporte = Parametricas::where('categoria', "tableros.tablerosListado")
                        ->where('valor', $id_tablero)
                        ->first();
                return view('tableros_control.view', compact('reporte'));
        }
}
