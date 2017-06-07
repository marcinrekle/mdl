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
//dd(public_path());
//Auth::loginUsingId(5);
//dd(Auth::user()->attrs->values['address']);
//config(['database.connections.mysql.prefix' => 'test']);
//dd(config('database.connections.mysql.prefix'));
//dd(config('database.connections.mysql.database'));
//dd(bcrypt('biuro'));
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('auth/{provider?}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider?}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/register/confirm/{confirm_code}', 'Auth\RegisterController@confirm')->middleware('guest')->name('confirmEmail');
Route::post('/register/confirm/', 'Auth\RegisterController@confirmSetPassword')->middleware('guest')->name('confirmSetPassword');
Route::get('/register/confirmed/', 'Auth\RegisterController@confirmed')->name('confirmedEmail');



Route::group(['middleware' => 'auth'], function () {

Route::get('/', 'UserController@show');


Route::get('/user/{id}/edit', 'UserController@edit')->name('userEdit');
Route::patch('/user/{id}', 'UserController@update')->name('userUpdate');

//Route::get('/student','StudentController@index');
//Route::get('/student/{id}','StudentController@show');
Route::resource('student', 'StudentController');
Route::resource('field', 'FieldController');
Route::resource('user', 'UserController');
Route::resource('payment', 'PaymentController');
Route::resource('drive', 'DriveController');
Route::resource('hour', 'HourController');
Route::resource('permission', 'PermissionController');
Route::resource('role', 'RoleController');
Route::get('/role/{role}/permission','RoleController@permission')->name('role.permission');
Route::patch('/role/{role}/permission','RoleController@permissionUpdate')->name('role.permissionUpdate');

Route::get('/home', 'HomeController@index')->name('home');
});