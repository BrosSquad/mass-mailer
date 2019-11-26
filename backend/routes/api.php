<?php

use App\Http\Resources\User;
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

Route::middleware(['jwt.auth'])->get('/me', static function (Request $request) {
    return ok(new User($request->user()));
});

Route::post('/request-password-change', 'AuthApi\PasswordChangeController@requestNewPassword');
Route::middleware(['jwt.auth'])
    ->post('/change-password', 'AuthApi\PasswordChangeController@changePassword');


Route::prefix('auth')->group(static function () {
    Route::post('login', 'AuthApi\LoginController@login');
});

Route::middleware(['jwt.auth'])->prefix('application')->group(static function () {
    Route::post('/', 'ApplicationController@createApplication');
    Route::post('/app-key', 'ApplicationController@createAppKey');
    Route::delete('/{id}', 'ApplicationController@deleteApplication');
    Route::delete('/app-key/{id}', 'ApplicationController@deleteAppKey');
});

Route::middleware('jwt.auth')->prefix('users')->group(static function () {
    Route::middleware(['admin'])
        ->post('/', 'AuthApi\UserController@create');
    Route::delete('/{id}', 'AuthApi\UserController@delete');
    Route::post('/change-image', 'AuthApi\UserController@changeImage');
});

Route::middleware(['jwt.auth'])->prefix('messages')->group(static function () {
    Route::post('/{applicationId}', 'MessageController@createMessage');
});
