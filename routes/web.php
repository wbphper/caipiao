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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::group(['domain' => 'test.laravel.cn'],function(){
//
//    Route::get('/test', 'IndexController@index');
//
//});

Route::get('/', 'IndexController@index');

Route::get('/code', 'CodeController@code');

Route::get('/add_code', 'IndexController@add_code');

Route::post('/add_code_submit', 'IndexController@add_code_submit');

Route::get('/add_ruler', 'IndexController@add_ruler');

Route::post('/add_ruler_submit', 'IndexController@add_ruler_submit');