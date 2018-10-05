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

    Route::prefix('verified-user')->group(function () {

        Route::get('create',  'PageUserNGOController@create');
        Route::get('edit/{id}',  'PageUserNGOController@edit');
        Route::post('submit-create',  'PageUserNGOController@submit_create');
        Route::post('update',  'PageUserNGOController@update');
        Route::get('list',  'PageUserNGOController@list_user');

    });

    Route::prefix('campaigns')->group(function () {

        Route::get('create',  'PageCampaignsController@create');
        Route::post('submit-create',  'PageCampaignsController@submit_create');
        Route::get('list',  'PageCampaignsController@list_campaign');

    });

    Route::prefix('ads')->group(function () {

        Route::get('create-advertiser',  'PageAdsController@create_advertiser');
        Route::get('create-content',  'PageAdsController@create_content');
        Route::get('list-ads',  'PageAdsController@list_ads');

    });



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
