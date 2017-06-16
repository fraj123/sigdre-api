<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'cors'], function (){
    Route::post('/auth_login', 'UserController@auth');

    Route::get('/usuarios', 'UserController@index');
    Route::post('/usuarios_add', 'UserController@store');
    Route::post('/usuarios_edit/{id}', 'UserController@update');

    Route::get('/usuarios_estados', 'UsuarioEstadosController@index');

    Route::get('/cargos', 'CargosController@index');

    Route::get('/privilegios', 'PrivilegiosController@index');
    Route::post('/privilegios_add', 'PrivilegiosController@store');
    Route::post('/privilegios_edit/{id}', 'PrivilegiosController@update');
});
