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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/subscribers/unsubscribe/{appId}/{subscriberId}', 'SubscriptionController@delete')
    ->name('unsub')
    ->middleware(['signed']);

Auth::routes(['register' => false, 'verify' => true]);
