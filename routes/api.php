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


Route::post('/login', 'Api\Auth\LoginDomain\LoginController@login');

Route::middleware('auth:api')->post('/logout', 'Api\Auth\LogoutDomain\LogoutController@logout');
Route::post('/register', 'Api\Auth\RegisterDomain\RegisterController@register');
Route::middleware('auth:api')->post('/clock/in', 'Api\TimeLog\ClockInDomain\ClockInController@clockIn');
Route::middleware('auth:api')->post('/clock/out', 'Api\TimeLog\ClockOutDomain\ClockOutController@clockOut');
