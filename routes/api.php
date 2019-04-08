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

Route::group(['middleware' => 'jwt.auth'], function () {
    route::get('auth/user', 'Auth\LoginController@user');
    Route::resource('user', 'UserController');
    Route::resource('payment', 'PaymentController');
    Route::resource('drive', 'DriveController');
    Route::resource('hour', 'HourController');
});
Route::group(['prefix' => 'auth'], function(){
	Auth::routes();
	Route::get('/refresh','Auth\LoginController@refresh');
});
