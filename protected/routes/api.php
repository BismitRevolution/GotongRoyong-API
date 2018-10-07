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

/*
Setup CORS
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::get('/', ['as' => 'default', function () {return redirect()->to('http://www.gotongroyong.in');}]);

/*
Variables
 */
$_CAMPAIGN = "campaign";

/*
Authentication API (no roles yet)
*/
Route::post("register", 'Auth\RegisterController@register');
Route::post("login", 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout');

/*
Campaigns without Auth
*/
Route::post("$_CAMPAIGN/campaign-list/all", 'CampaignsController@getCampaignsList');
Route::post("$_CAMPAIGN/campaign-list/active", 'CampaignsController@getCampaignsListActive');
Route::post("$_CAMPAIGN/campaign-list/detail", 'CampaignsController@getCampaignsDetail');
Route::post("$_CAMPAIGN/campaign-list/user", 'CampaignsController@getCampaignsUser');

/*
Route Middleware
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){

    /*
    Variables
    */
    $_CAMPAIGN = "campaign";
    $_DONATES = "donates";

    /*
    Log out etc
     */
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('testdemo', 'Test\TestController@test');
    Route::post('userdetail', 'UserController@getDetails');

    /*
    CAMPAIGNS with Auth
    */
    Route::post("$_CAMPAIGN/campaign-list/create", 'CampaignsController@createCampaign');
    Route::post("$_CAMPAIGN/campaign-list/delete", 'CampaignsController@deleteCampaign');

    /*
    CAMPAIGN ADS DONATES
     */
    Route::post("$_DONATES/campaign-ads/create", 'CamAdsDonatesController@createDonates');
    Route::post("$_DONATES/campaign-ads/donate-success",'CamAdsDonatesController@updateDonations');
    Route::post("$_DONATES/campaign-ads/target-url",'CamAdsDonatesController@clickUrl');
    Route::post("$_DONATES/campaign-ads/user-participation",'CamAdsDonatesController@getListByUser');

});
