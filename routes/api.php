<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\StudioController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\ActorController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SeatController;

// Cities
Route::middleware('api')->group(function () {
    Route::get('/cities', [CityController::class, 'index']);
    Route::post('/cities', [CityController::class, 'store']);
    Route::get('/cities/{city}', [CityController::class, 'show']);
    Route::put('/cities/{city}', [CityController::class, 'update']);
    Route::delete('/cities/{city}', [CityController::class, 'destroy']);
});

// Studios
Route::middleware('api')->group(function () {
    Route::get('/studios', [StudioController::class, 'index']);
    Route::post('/studios', [StudioController::class, 'store']);
    Route::get('/studios/{studio}', [StudioController::class, 'show']);
    Route::put('/studios/{studio}', [StudioController::class, 'update']);
    Route::delete('/studios/{studio}', [StudioController::class, 'destroy']);
});

// Cinemas
Route::middleware('api')->group(function () {
    Route::get('/cinemas', [CinemaController::class, 'index']);
    Route::post('/cinemas', [CinemaController::class, 'store']);
    Route::get('/cinemas/{cinema}', [CinemaController::class, 'show']);
    Route::put('/cinemas/{cinema}', [CinemaController::class, 'update']);
    Route::delete('/cinemas/{cinema}', [CinemaController::class, 'destroy']);
});

// Movies
Route::middleware('api')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    Route::post('/movies', [MovieController::class, 'store']);
    Route::get('/movies/{movie}', [MovieController::class, 'show']);
    Route::put('/movies/{movie}', [MovieController::class, 'update']);
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy']);
});

// Promos
Route::middleware('api')->group(function () {
    Route::get('/promos', [PromoController::class, 'index']);
    Route::post('/promos', [PromoController::class, 'store']);
    Route::get('/promos/{promo}', [PromoController::class, 'show']);
    Route::put('/promos/{promo}', [PromoController::class, 'update']);
    Route::delete('/promos/{promo}', [PromoController::class, 'destroy']);
});

// Actors
Route::middleware('api')->group(function () {
    Route::get('/actors', [ActorController::class, 'index']);
    Route::post('/actors', [ActorController::class, 'store']);
    Route::get('/actors/{actor}', [ActorController::class, 'show']);
    Route::put('/actors/{actor}', [ActorController::class, 'update']);
    Route::delete('/actors/{actor}', [ActorController::class, 'destroy']);
});

// Orders
Route::middleware('api')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']); // Get orders by user_id (query param)
    Route::post('/orders', [OrderController::class, 'store']); // Create new order
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Get specific order
    Route::put('/orders/{id}/payment', [OrderController::class, 'updatePayment']); // Update payment status
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']); // Cancel order
});

// Seats
Route::middleware('api')->group(function () {
Route::get('/seats/available', [SeatController::class, 'available']); 
Route::get('/seats/ticket/{ticketId}', [SeatController::class, 'byTicket']); 
Route::get('/seats/{id}', [SeatController::class, 'show']);
});
