<?php

use Illuminate\Http\Request;
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
    Route::get('login', 'LoginController@login');
});

Route::prefix('application')->group(static function () {
    Route::get('/{page}/{perPage}', 'ApplicationController@getAppllications');
    Route::get('/{id}', 'ApplicationController@getAppllication');
    Route::post('/', 'ApplicationController@create');
    Route::patch('/{id}', 'ApplicationController@update');
    Route::delete('/{id}', 'ApplicationController@delete');
});

Route::prefix('users')->group(static function() {
    Route::post('/', 'UserController@create');
});

Route::prefix('messages')->group(static function () {
    Route::get('/', 'MessageController@getMessages');
    Route::post('/', 'MessageController@create');
});
