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

// Route::get('/', 'BaseController@index');
Route::get('/create', 'IndexController@create');

Route::get('/city', 'CityController@index');
Route::post('/city', 'CityController@store');
Route::get('/city/{id}', 'CityController@show');
Route::put('/city/{id}', 'CityController@update');
Route::delete('/city/{id}', 'CityController@destroy');