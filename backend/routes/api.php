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

Route::middleware(['auth:api'])->get('/me', static function (Request $request) {
    return ok(new User($request->user()));
});

Route::post('/request-password-change', 'Auth\PasswordChangeController@requestNewPassword');
Route::middleware(['auth:api'])
    ->post('/change-password', 'Auth\PasswordChangeController@changePassword');


Route::prefix('auth')->group(static function () {
    Route::post('login', 'Auth\LoginController@login');
});

Route::middleware(['auth:api'])->prefix('application')->group(static function () {
});

Route::middleware('auth:api')->prefix('users')->group(static function() {
    Route::middleware(['admin'])
        ->post('/', 'Auth\UserController@create');
    Route::delete('/{id}', 'Auth\UserController@delete');
});

Route::middleware(['auth:api'])->prefix('messages')->group(static function () {
});
