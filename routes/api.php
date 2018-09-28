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

/* Setup CORS */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


Route::get('/', ['as' => 'default', function () {return redirect()->to('http://www.gotongroyong.in');}]);
/*
Authentication API (no roles yet)
*/
Route::post("register", 'Auth\RegisterController@register');
Route::post("login", 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'auth:api'], function() {
//     //logout api
//     Route::post('logout', 'Auth\LoginController@logout');
//     Route::post('userdetail', 'Auth\LoginController@details');
//     Route::post('testdemo', 'Auth\LoginController@test');
//
//     //Route::post('userdetail', 'Auth\LoginController@details');
//
// });

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('testdemo', 'Test\TestController@test');
    Route::post('userdetail', 'UserController@getDetails');
});

// Route::middleware('auth:api')->post('logout', function (Request $request) {
//         $user = auth()->user();
//         //$user = Auth::guard('api')->user();
//         //$user = $this->guard()->user();
//         //$tok = $user->remember_token;
//         if ($user) {
//             //$user->generateToken();
//             return response()->json(['data' => 'theres user'], 200);
//             $user->remember_token = null;
//             $user->save();
//         }
//
//         return response()->json(['data' => 'success logout'], 200);
// });
