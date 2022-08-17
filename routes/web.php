<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
//login
Route::get('/', 'Auth\LoginController@index')->name('login');
Route::post('/logout', 'Auth\LogoutController@logout')->name('logout');
Route::post('/autenticacao', 'Auth\LoginController@autenticacao')->name('login.autenticacao');

Route::get('/home', ['middleware' => 'auth', 'uses' => 'HomeController@index'])->name('home');

//Endereco
Route::group(['prefix' => '/endereco', 'as' => 'endereco.', 'middleware' => 'auth'], function(){
    Route::get('', 'EnderecoController@index')->name('index');
});
