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

//Rota home
Route::get('/home', ['middleware' => 'auth', 'uses' => 'HomeController@index'])->name('home');

//Registrar novo usuário
Route::get('/registrar', 'UserController@index')->name('registar_usuario');
Route::post('/store', 'UserController@store')->name('registrar_store');

//Anexo
Route::group(['prefix' => '/anexos', 'as' => 'anexos.', 'middleware' => 'auth'], function(){
    Route::get('/', 'AnexoController@index')->name('index');
    Route::post('/store', 'AnexoController@store')->name('store');
    Route::get('/getFile/{id}', 'AnexoController@getFile')->name('getFile');
});

//Endereco
Route::group(['prefix' => '/endereco', 'as' => 'endereco.', 'middleware' => 'auth'], function(){
    Route::get('', 'EnderecoController@index')->name('index');
    Route::post('/store', 'EnderecoController@store')->name('store');
    Route::post('/destroy/{id}', 'EnderecoController@destroy')->name('destroy');
    Route::get('/edit/{id}', 'EnderecoController@edit')->name('edit');
    Route::post('/update/{id}', 'EnderecoController@update')->name('update');
});
