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

Route::resource('admin', 'AdminController');
Route::resource('booking', 'BookingController');
Route::resource('pengguna', 'PenggunaController');
Route::resource('peralatan', 'PeralatanController');
Route::resource('perbaikan', 'PerbaikanController');
Route::resource('statistik', 'StatistikController');
Route::resource('transaksi', 'TransaksiController');
Route::resource('articles', 'ArticleController');
Route::resource('dashboard', 'DashboardController');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::post('checkEmail', 'AdminController@foundAdminWithEmail');

//Route::post('auth/login', array('uses' => 'Auth\AuthController@postLogin'));

Route::get('/peralatan', function () {
    return view('peralatan.index');
});
Route::get('/api/v1/peralatan/{id?}', 'PeralatanController@peralatan');
Route::post('/api/v1/peralatan', 'PeralatanController@store');
Route::post('/api/v1/peralatan/{id}', 'PeralatanController@update');
Route::delete('/api/v1/peralatan/{id}', 'PeralatanController@destroy');

Route::get('/perbaikan', function () {
    return view('perbaikan.index');
});
Route::get('/api/v1/perbaikan/{id?}', 'PerbaikanController@perbaikan');
Route::post('/api/v1/perbaikan', 'PerbaikanController@store');
Route::post('/api/v1/perbaikan/{id}', 'PerbaikanController@update');
Route::post('/api/v1/perbaikan/end/{id}', 'PerbaikanController@end');
Route::delete('/api/v1/perbaikan/{id}', 'PerbaikanController@destroy');