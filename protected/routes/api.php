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
$_AUTH = "auth";
$_CAMPAIGN = "campaign";
$_DONATES = "donates";


/*
Authentication API (no roles yet)
*/
Route::post("$_AUTH/register", 'Auth\RegisterController@register');
Route::post("$_AUTH/login", 'Auth\LoginControllerAPI@loginAPI');
Route::post("$_AUTH/user/total", 'UserController@countUsers');
Route::post("$_AUTH/user/detail", 'UserController@getDetailById');
Route::post("$_AUTH/user/detail-username", 'UserController@getUserByUsername');


//Route::post('logout', 'Auth\LoginController@logout');

/*
Campaigns without Auth
*/
Route::post("$_CAMPAIGN/campaign-list/all", 'CampaignsController@getCampaignsList');
Route::post("$_CAMPAIGN/campaign-list/active", 'CampaignsController@getCampaignsListActive');
Route::post("$_CAMPAIGN/campaign-list/detail", 'CampaignsController@getCampaignsDetail');
Route::post("$_CAMPAIGN/campaign-list/user", 'CampaignsController@getCampaignsUser');
Route::post("$_CAMPAIGN/campaign-list/total", 'CampaignsController@countCampaign');
Route::post("$_CAMPAIGN/campaign-list/paginate", 'CampaignsController@getCampaignsListPaginate');

/*
Campaign Ads Donate
 */
 Route::post("$_DONATES/campaign-ads/total", 'CamAdsDonatesController@countDonations');
 Route::post("$_DONATES/campaign-ads/total-money-result", 'CamAdsDonatesController@countMoney');

/*
Route Middleware
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



    /*
    Variables
    */
    $_AUTH = "auth";
    $_CAMPAIGN = "campaign";
    $_DONATES = "donates";
    $_LOG = "log";

    /*
    User
     */
    Route::post("$_AUTH/user/logout", 'Auth\LoginControllerAPI@logoutAPI');
    Route::post("$_AUTH/user/testdemo", 'Test\TestController@test');
    Route::post("$_AUTH/user/self-detail", 'UserController@getDetails');
    Route::post("users/pahlawan/paginate",'PageUserNGOController@getUserPaginate');
    Route::post("$_AUTH/user/update", 'UserController@updateUser');
    
    //Route::post("$_AUTH/user/update-pahlawan", 'UserController@updateUserPahlawan');


    /*
    CAMPAIGNS with Auth
    */
    Route::post("$_CAMPAIGN/campaign-list/create", 'CampaignsController@createCampaign');
    Route::post("$_CAMPAIGN/campaign-list/delete", 'CampaignsController@deleteCampaign');
    Route::post("$_CAMPAIGN/campaign-list/complete", 'CampaignsController@completeStatus');

    /*
    CAMPAIGN ADS DONATES
     */
    Route::post("$_DONATES/campaign-ads/create", 'CamAdsDonatesController@createDonates');
    Route::post("$_DONATES/campaign-ads/donate-success",'CamAdsDonatesController@updateDonations');
    Route::post("$_DONATES/campaign-ads/target-url",'CamAdsDonatesController@clickUrl');
    Route::post("$_DONATES/campaign-ads/user-participation",'CamAdsDonatesController@getListByUser');
    Route::post("$_DONATES/campaign-ads/campaign-participation",'CamAdsDonatesController@getListByCampaign');
    Route::post("$_DONATES/campaign-ads/campaign-participation-self",'CamAdsDonatesController@getListByCampaignSelf');
    Route::post("$_DONATES/campaign-ads/share-success",'CamAdsDonatesController@updateDonationShare');

    /*
    LOG USERS
     */
    Route::post("$_LOG/create", 'LogUsersController@createLog');
