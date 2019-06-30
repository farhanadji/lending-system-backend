<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login'); 
});

Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::resource("users", "UserController");
Route::post('users/store', 'UserController@store');
Route::get('users/delete/{id}', 'UserController@destroy');
Route::resource('books', 'BookController');
Route::post('books/store', 'BookController@store');
Route::get('books/delete/{id}', 'BookController@destroy');
Route::resource('transactions', 'TransactionController');
