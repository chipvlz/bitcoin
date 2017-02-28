<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',"ExchangeController@index");
Route::post('sell',"ExchangeController@sell");
Route::any('notify',"ExchangeController@notify");

Route::any('balance',"ExchangeController@getBanlance");
Route::any('bank-info',"ExchangeController@bankInfo");
Route::any('get-price',"ExchangeController@getPrice");
