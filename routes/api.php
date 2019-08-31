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

Route::any('forbidden', function () {
    return response()->json(['message' => 'Forbidden: Unauthenticated'], 403);
})->name('forbidden');

Route::prefix('auth')->group(function () {
    Route::post('sign-in', 'SignInController@store');
    Route::post('register', 'RegisterController@store');

    Route::middleware('auth')->post('sign-out', 'SignInController@destroy');
});

Route::middleware('auth')->group(function () {
    Route::prefix('boards')->group(function () {
        Route::get('/', 'BoardController@index');
        Route::post('/', 'BoardController@store');
        Route::get('/{board}', 'BoardController@show');
        Route::patch('/{board}', 'BoardController@update');
        Route::delete('/{board}', 'BoardController@destroy');
    });

    Route::prefix('soundclips')->group(function () {
        Route::get('/', 'SoundClipController@index');
        Route::post('/', 'SoundClipController@store');
        Route::get('/{soundClip}', 'SoundClipController@show');
        Route::patch('/{soundClip}', 'SoundClipController@update');
        Route::delete('/{soundClip}', 'SoundClipController@destroy');

        Route::post('/{soundClip}/upload', 'SoundClipController@upload');
    });
});
