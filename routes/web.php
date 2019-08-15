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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('hello', function () {
//     return 'Hello, Welcome to LaravelAcademy.org';
// });
Route::group(['middleware' => App\Http\Middleware\CheckLogin::class,], function () {
    Route::get('show', 'indexController@show'); 
    Route::get('loginout', 'LoginController@loginout');
});
Route::any('logindo', 'LoginController@loginshow');
Route::get('login', 'LoginController@show');
Route::get('index', 'IndexController@index');
Route::get('sort', 'IndexController@sort');
Route::get('floor', 'IndexController@floor');
Route::get('auth/login', 'AuthController@login');
Route::get('wer', function () {
    echo $hashed = Hash::make('aa');
});
