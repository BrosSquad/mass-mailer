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

Route::middleware(['signed'])->get('/unsubscribe/{appId}/{subscriberId}', 'SubscriptionController@delete');

Route::middleware(['auth:api'])->group(
    static function () {
        Route::get('/me', 'HomeController@me');
        Route::prefix('application')->group(
            static function () {
                Route::get('/', 'ApplicationController@get');
                Route::get('/{id}', 'ApplicationController@getOne');
                Route::post('/', 'ApplicationController@store');
                Route::post('/app-key', 'ApplicationController@createAppKey');
                Route::delete('/{id}', 'ApplicationController@deleteApplication');
                Route::delete('/app-key/{id}', 'ApplicationController@deleteAppKey');
            }
        );
        Route::prefix('users')->group(
            static function () {
                Route::post('/', 'AuthApi\UserController@create');
                Route::delete('/{id}', 'AuthApi\UserController@delete');
                Route::post('/change-image', 'AuthApi\UserController@changeImage');
            }
        );

    }
);

Route::prefix('subscribers')->group(
    static function () {
        Route::post('/', 'SubscriptionController@store');
        Route::get('/', 'SubscriptionController@get');
        Route::get('/{id}', 'SubscriptionController@getOne');
        Route::put('/{id}', 'SubscriptionController@update');
    }
);



Route::middleware(['app_key'])->group(
    static function () {
        Route::prefix('/messages')->group(
            static function () {
                Route::post('/', 'MessageController@createMessage');
            }
        );
    }
);



