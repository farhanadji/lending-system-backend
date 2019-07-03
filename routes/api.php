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

Route::middleware('auth:api')->group(function () {
    Route::post('/apilogout', 'AuthController@logout');
    Route::post('/apiborrow','TransactionApiController@borrow');
    Route::get('/apimytransaction','TransactionApiController@mytransaction');
});

//PUBLIC
Route::get('/', 'AuthController@login');
Route::get('/apibooks','bookapi@index');
Route::get('/apibooks/{id}', 'bookapi@detail');
Route::post('/apilogin', 'AuthController@login');
Route::post('/apiregister', 'AuthController@register');
Route::get('/apialltransaction', 'TransactionApiController@alltransaction');
