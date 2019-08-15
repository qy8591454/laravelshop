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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('floor', 'IndexController@floor');
    Route::post('mycar', 'IndexController@mycar');
    Route::post('number', 'IndexController@number');
    Route::post('area', 'IndexController@area');
    Route::post('orders', 'IndexController@orders');
    Route::post('orders_add', 'IndexController@orders_add');
});

Route::group([
    'middleware' => 'api',
     'prefix' => 'pay'
], function ($router) {
    /////
    Route::get('index', 'PayController@index');
    Route::get('return', 'PayController@return');
    Route::get('notify', 'PayController@notify');
});
Route::post('goods', 'IndexController@goods');
Route::post('goodshp', 'IndexController@goodshp');
Route::post('car', 'IndexController@car');
Route::post('user_name', 'IndexController@user_name');
Route::post('city', 'IndexController@city');
