<?php

use App\Item;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('item', function(){

    $arts = App\Item::all();
    //$arts = DB::select("select * from ITEM");
    return $arts;

});

Route::get('pruebita/{nombre}', function($nombre){

    return view('login', ['nombre' => $nombre]);

});

Route::get('ajax', function(){

    return view('pruebaAjax');

});

Route::get('ajaxPrueba', 'pruebaAjax@store');

Route::get('sesiones', function(){

    return view('sesiones');

});

Route::get('sesionAceptada', function(){

    return view('sesionAceptada');

});

Route::post('comprobarLogin', function(){

    return view('comprobarLogin');

});

Route::post('cerrarSesion', function(){

    return view('cerrarSesion');

});

Route::get('index', 'OriginController@index');

Route::get('item', 'ItemController@index');

Route::get('price', 'PriceController@index');

Route::get('customer', 'CustomerController@index');

Route::get('sales', 'SalesController@index');
Route::get('salesNew', 'SalesController@create');

Route::get('list', 'ListController@index');