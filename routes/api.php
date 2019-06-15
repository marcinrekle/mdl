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
    Route::get('auth/user', 'Auth\LoginController@user');
	Route::get('auth/refresh','Auth\LoginController@refresh');
    Route::resource('user', 'UserController');
    Route::resource('payment', 'PaymentController');
    Route::resource('drive', 'DriveController');
    Route::resource('hour', 'HourController');
    Route::get('role/permission', 'RoleController@permission');
    Route::patch('role/{role}/permissionUpdate', 'RoleController@permissionUpdate');
    Route::resource('role', 'RoleController');
    //Route::apiResource('permission', 'PermissionController');

    Route::get('permission',['middleware' =>'permission:permission-retrive|permission-crud', 'uses' => 'PermissionController@index']);
    Route::post('permission',['middleware' =>'permission:permission-create|permission-crud', 'uses' => 'PermissionController@store']);
    Route::patch('permission/{id}',['middleware' =>'permission:permission-update|permission-crud', 'uses' => 'PermissionController@update']);
    Route::delete('permission/{id}',['middleware' =>'permission:permission-delete|permission-crud', 'uses' => 'PermissionController@delete']);
    Route::get('student','StudentController@show');

});
Route::group(['prefix' => 'auth'], function(){
	Auth::routes();
});
