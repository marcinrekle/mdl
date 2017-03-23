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
//Auth::loginUsingId(2);
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('auth/{provider?}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider?}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/register/confirm/{confirm_code}', 'Auth\RegisterController@confirm')->name('confirmEmail');
Route::post('/register/confirm/', 'Auth\RegisterController@confirmSetPassword')->name('confirmSetPassword');

Route::get('/home', 'HomeController@index');
