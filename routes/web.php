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

/*Route::get('/', function () {
    return view('welcome');
});*/

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

Route::get('/', 'OriginController@login');

Route::post('checkUserLogin', 'LoginController@checkUserLogin');

Route::get('destroySession', 'LoginController@destroySession');

Route::get('index', 'OriginController@index');

Route::get('item', 'ItemController@index');

Route::get('price', 'PriceController@index');

Route::get('customer', 'CustomerController@index');

Route::get('sales', 'SalesController@index');
Route::get('salesNew', 'SalesController@newSale');

Route::get('list', 'ListController@index');

Route::get('salesCreate', 'SalesController@create');

Route::get('salesAddLines/{invoiceid}', 'SalesController@addLines');

Route::get('getProductNameById','ItemController@getProductNameById');

Route::get('getProductNamesByName', 'ItemController@getProductNamesByName');

Route::get('getItemPriceByListId', 'PriceController@getItemPriceByListId');

Route::get('getItemPriceByMargin', 'PriceController@getItemPriceByMargin');

Route::get('saveInvoiceLine', 'SalesController@saveInvoiceLine');

Route::get('deleteInvoiceLine', 'SalesController@deleteInvoiceLine');

Route::get('updateInvoiceLine', 'SalesController@updateInvoiceLine');

Route::get('closeInvoice', 'SalesController@closeInvoice');

Route::get('salesClose', 'SalesController@salesClose');

Route::get('salesOpen', 'SalesController@salesOpen');

//Route::get('sendInvoiceByMail/{invoiceid}', 'SalesController@sendInvoiceByMail');

Route::get('salesReportInvoice/{invoiceid}', 'ReportController@salesReportInvoice');