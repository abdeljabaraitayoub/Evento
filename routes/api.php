<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/reservations', 'App\Http\Controllers\ReservationController@index');
Route::get('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@show');
Route::post('/reservations', 'App\Http\Controllers\ReservationController@store');
Route::put('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@update');
Route::delete('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@destroy');

Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoryController@show');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
Route::put('/categories/{category}', 'App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{category}', 'App\Http\Controllers\CategoryController@destroy');

Route::get('/users', 'App\Http\Controllers\UserController@index');
Route::get('/users/{user}', 'App\Http\Controllers\UserController@show');
Route::post('/users', 'App\Http\Controllers\UserController@store');
Route::put('/users/{user}', 'App\Http\Controllers\UserController@update');
Route::delete('/users/{user}', 'App\Http\Controllers\UserController@destroy');

Route::get('/events', 'App\Http\Controllers\EventController@index');
Route::get('/events/{event}', 'App\Http\Controllers\EventController@show');
Route::post('/events', 'App\Http\Controllers\EventController@store');
Route::put('/events/{event}', 'App\Http\Controllers\EventController@update');
Route::delete('/events/{event}', 'App\Http\Controllers\EventController@destroy');
