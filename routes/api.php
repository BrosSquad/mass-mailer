<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(static function () {
    Route::post('login', 'LoginController@login');
});

Route::middleware(['auth:api'])->prefix('application')->group(static function () {
    Route::get('/{page}/{perPage}', 'ApplicationController@getApplication');
    Route::get('/{id}', 'ApplicationController@getApplications');
    Route::post('/', 'ApplicationController@create');
    Route::patch('/{id}', 'ApplicationController@update');
    Route::delete('/{id}', 'ApplicationController@delete');
});

Route::middleware('auth:api')->prefix('users')->group(static function() {
    Route::post('/', 'UserController@create');
});

Route::middleware(['auth:api'])->prefix('messages')->group(static function () {
    Route::get('/{page}/{perPage}', 'MessageController@getMessages');
    Route::post('/', 'MessageController@create');
    Route::get('/{id}', 'MessageController@getMessage');
    Route::delete('/{id}', 'MessageController@delete');
});
