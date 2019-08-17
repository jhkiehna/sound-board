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

Route::get('/', function () {
    return "Hello from slash page";
});

Route::prefix('auth')->group(function () {
    Route::post('sign-in', 'SignInController@store');
    Route::post('register', 'RegisterController@store');

    Route::middleware('auth')->post('sign-out', 'SignInController@destroy');
});
