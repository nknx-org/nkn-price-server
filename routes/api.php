<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




// WHAT DO WE WANT?
//
// Query current price of quote:
// /price?quote=NKN&currency=USD,ETH

// Query historical price of quote:
// /history?quote=NKN&currency=USD,ETH&aggregate=days

Route::get('price', 'QuoteController@price');
Route::get('history', 'QuoteController@history');
