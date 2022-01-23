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

Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@doLogin');

Route::middleware('auth')->group(function() {

    Route::get('/', 'App\Http\Controllers\JournalController@dashboard')->name('index');

    Route::get('/journal', 'App\Http\Controllers\JournalController@index');
    Route::get('/calendar', 'App\Http\Controllers\JournalController@calendar');


    Route::get('/journal/{id}/edit', 'App\Http\Controllers\JournalController@edit');
    Route::post('/journal/{id}/edit', 'App\Http\Controllers\JournalController@save');

    Route::get('/event', 'App\Http\Controllers\EventController@index');
    Route::get('/event/{subtype}', 'App\Http\Controllers\EventController@view');

    Route::get('/gauge', 'App\Http\Controllers\GaugeController@index');
    Route::get('/gauge/{subtype}', 'App\Http\Controllers\GaugeController@view');

    Route::get('/journal/add', 'App\Http\Controllers\JournalController@add');
    Route::get('/journal/add/{type}', 'App\Http\Controllers\JournalController@add');
    Route::get('/journal/add/{type}/{subtype}', 'App\Http\Controllers\JournalController@add');

    Route::post('/journal/add/{type}', 'App\Http\Controllers\JournalController@create');
    Route::post('/journal/add/{type}/{subtype}', 'App\Http\Controllers\JournalController@create');

});
