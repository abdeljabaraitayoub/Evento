<?php

use App\Http\Middleware\EventMiddleware;
use GuzzleHttp\Middleware;
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

Route::get('/tickets', 'App\Http\Controllers\TicketController@index');
Route::get('/tickets/{ticket}', 'App\Http\Controllers\TicketController@show');
Route::Post('/tickets/{reservation}', 'App\Http\Controllers\TicketController@store');

Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoryController@show');

Route::get('/users/{user}', 'App\Http\Controllers\UserController@show');

Route::middleware('check.role:admin')->group(function () {
    Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
    Route::put('/categories/{category}', 'App\Http\Controllers\CategoryController@update');
    Route::delete('/categories/{category}', 'App\Http\Controllers\CategoryController@destroy');

    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::post('/users', 'App\Http\Controllers\UserController@store');
    Route::put('/users/{user}', 'App\Http\Controllers\UserController@update');
    Route::delete('/users/{user}', 'App\Http\Controllers\UserController@destroy');
    Route::get('/statistiques', 'App\Http\Controllers\StatistiqueController@index');
    Route::patch('/events/{event}', 'App\Http\Controllers\EventController@validateEvent');
    Route::get('/events/all', 'App\Http\Controllers\EventController@all');
});
Route::get('/events/{event}', 'App\Http\Controllers\EventController@show');

Route::post('/reservations', 'App\Http\Controllers\ReservationController@store');
Route::middleware('check.role:organizer')->group(function () {

    Route::post('/events', 'App\Http\Controllers\EventController@store');
    Route::put('/events/{event}', 'App\Http\Controllers\EventController@update');
    Route::delete('/events/{event}', 'App\Http\Controllers\EventController@destroy');
    Route::get('/events/{Event}/reservations', 'App\Http\Controllers\ReservationController@getEventReservations')->Middleware(EventMiddleware::class);
    Route::get('/events/{Event}/Statistiques', 'App\Http\Controllers\ReservationController@statistics')->Middleware(EventMiddleware::class);
    Route::get("/event", 'App\Http\Controllers\EventController@EventsByUser');
    Route::put('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@update');
    Route::delete('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@destroy');
    Route::patch('/reservations/{reservation}', 'App\Http\Controllers\ReservationController@confirmReservation')->Middleware(EventMiddleware::class);
});

Route::get('/events', 'App\Http\Controllers\EventController@index');


Route::Post('/login', 'App\Http\Controllers\AuthController@login');
Route::Post('/register', 'App\Http\Controllers\AuthController@register');
Route::Post('/me', 'App\Http\Controllers\AuthController@me');
Route::post('/generateResetToken', 'App\Http\Controllers\AuthController@generateResetToken');
Route::post('/resetPassword', 'App\Http\Controllers\AuthController@resetPassword');



// Route::get('/generate', 'App\Http\Controllers\TicketController@generate');


Route::post('/payment', 'App\Http\Controllers\PaymentController@handlePayment');
