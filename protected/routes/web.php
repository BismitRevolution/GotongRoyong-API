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

Route::get('/', function () {
    return view('admin.login');
});

Route::post('/checklogin', 'PageController@checkLoginRole');

Route::prefix('super-admin')->group(function () {

    Route::get('dashboard',  function () {
        return view('admin.super-dashboard');
    });

});

Route::prefix('admin')->group(function () {

    Route::get('dashboard',  function () {
        return view('admin.dashboard');
    });

    Route::get('create-user-verified',  'PageUserNGOController@create');

    Route::get('laporan',  function () {
        return view('admin.laporan');
    });

    Route::get('bisnis',  function () {
        return view('admin.bisnis');
    });

    Route::get('pengaturan-tiket',  function () {
        return view('admin.pengaturan-tiket');
    });

});
