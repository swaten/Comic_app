<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'App\Http\Controllers\Main@index');
Route::post('subscribe_form', 'App\Http\Controllers\Main@subscribe_form');
Route::post('unsubscribe_form', 'App\Http\Controllers\Main@unsubscribe_form');

Route::get('send_comic', 'App\Http\Controllers\Main@send_comic');
Route::get('get_random_comic_id', 'App\Http\Controllers\Main@get_random_comic_id');
