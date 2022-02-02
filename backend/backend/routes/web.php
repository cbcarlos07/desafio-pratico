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
    return view('welcome');
});

Route::group(['middleware' => 'cors','as'=> 'backend.','prefix' =>'products'], function(){
    Route::get('',['as' => 'index', 'uses' => 'APIController@index']);
    Route::get('{id}',['as' => 'buscarPorId', 'uses' => 'APIController@buscarPorId']);
    Route::post('',['as' => 'criar', 'uses' => 'APIController@criar']);
    Route::put('{id}',['as' => 'editar', 'uses' => 'APIController@editar']);
    Route::delete('{id}',['as' => 'remover', 'uses' => 'APIController@remover']);
});

