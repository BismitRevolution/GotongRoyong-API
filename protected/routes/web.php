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
    if(is_null(Auth::user())) {
        return redirect(url('/login'));
    } else {
        return redirect(url('/admin/dashboard'));
    }
});

Route::get('/send/email', 'PageController@mail');

Route::get('/users/pahlawan/paginate','PageUserNGOController@getUserPaginate');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/', function () {
//    return view('admin.login');
//});

Route::post('/checklogin', 'PageController@checkLoginRole');

Route::get('admin',  function () {
    return redirect('admin/dashboard');
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
        Route::post('delete-user',  'PageUserNGOController@delete_user');

    });

    Route::prefix('campaigns')->group(function () {

        Route::get('create',  'PageCampaignsController@create');
        Route::get('edit-campaign/{id}',  'PageCampaignsController@edit_campaign');
        Route::post('submit-create',  'PageCampaignsController@submit_create');
        Route::get('list-campaign',  'PageCampaignsController@list_campaign');
        Route::post('update-campaign','PageCampaignsController@update_campaign' );
        Route::post('delete','PageCampaignsController@delete_campaign' );

    });

    Route::prefix('ads')->group(function () {

        Route::get('create-advertiser',  'PageAdsController@create_advertiser');
        Route::post('submit-advertiser',  'PageAdsController@submit_advertiser');
        Route::get('create-content',  'PageAdsController@create_content');
        Route::post('submit-content',  'PageAdsController@submit_content');
        Route::get('edit-content/{id}',  'PageAdsController@edit_content');
        Route::post('update-content',  'PageAdsController@update_content');
        Route::get('list-ads',  'PageAdsController@list_ads');
        Route::post('delete-ads','PageAdsController@delete_ads');

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




Route::get("campaign-list/paginate", 'PageCampaignsController@getCampaignsListPaginate');