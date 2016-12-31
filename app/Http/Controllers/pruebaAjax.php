<?php

namespace App\Http\Controllers;

use App\pruebaAjaxx;
use Illuminate\Http\Request;

class pruebaAjax extends Controller
{
    public function store(Request $request){

        $prueba = new pruebaAjaxx;

        $prueba->prueba = $request->dato;

        $prueba->save();

        return response()->json([
            "mensaje" => "Dato " . $request->dato . " ingresado."
        ]);
    }
}