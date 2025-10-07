<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CityController,
    StudioController,
    CinemaController,
    MovieController,
    PromoController,
    ActorController,
    OrderController,
    SeatController,
    TicketController
};

Route::middleware('api')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Cities
    |--------------------------------------------------------------------------
    */
    Route::get('cities', [CityController::class, 'index']);
    Route::post('cities', [CityController::class, 'store']);
    Route::get('cities/{id}', [CityController::class, 'show']);
    Route::put('cities/{id}', [CityController::class, 'update']);
    Route::delete('cities/{id}', [CityController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Studios
    |--------------------------------------------------------------------------
    */
    Route::get('studios', [StudioController::class, 'index']);
    Route::post('studios', [StudioController::class, 'store']);
    Route::get('studios/{id}', [StudioController::class, 'show']);
    Route::put('studios/{id}', [StudioController::class, 'update']);
    Route::delete('studios/{id}', [StudioController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Cinemas
    |--------------------------------------------------------------------------
    */
    Route::get('cinemas', [CinemaController::class, 'index']);
    Route::post('cinemas', [CinemaController::class, 'store']);
    Route::get('cinemas/{id}', [CinemaController::class, 'show']);
    Route::put('cinemas/{id}', [CinemaController::class, 'update']);
    Route::delete('cinemas/{id}', [CinemaController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Movies
    |--------------------------------------------------------------------------
    */
    Route::get('movies', [MovieController::class, 'index']);
    Route::post('movies', [MovieController::class, 'store']);
    Route::get('movies/{id}', [MovieController::class, 'show']);
    Route::put('movies/{id}', [MovieController::class, 'update']);
    Route::delete('movies/{id}', [MovieController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Promos
    |--------------------------------------------------------------------------
    */
    Route::get('promos', [PromoController::class, 'index']);
    Route::post('promos', [PromoController::class, 'store']);
    Route::get('promos/{id}', [PromoController::class, 'show']);
    Route::put('promos/{id}', [PromoController::class, 'update']);
    Route::delete('promos/{id}', [PromoController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Actors
    |--------------------------------------------------------------------------
    */
    Route::get('actors', [ActorController::class, 'index']);
    Route::post('actors', [ActorController::class, 'store']);
    Route::get('actors/{id}', [ActorController::class, 'show']);
    Route::put('actors/{id}', [ActorController::class, 'update']);
    Route::delete('actors/{id}', [ActorController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */
    Route::get('orders', [OrderController::class, 'index']); // Bisa filter by user_id
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::put('orders/{id}/payment', [OrderController::class, 'updatePayment']);
    Route::put('orders/{id}/cancel', [OrderController::class, 'cancel']);

    /*
    |--------------------------------------------------------------------------
    | Seats
    |--------------------------------------------------------------------------
    */
    // User Side
    Route::get('seats', [SeatController::class, 'index']);
    Route::get('seats/{id}', [SeatController::class, 'show']);
    Route::get('seats/ticket/{ticketId}', [SeatController::class, 'byTicket']);
    Route::get('seats/available', [SeatController::class, 'available']); // ?ticket_id=xx

    // Admin Side
    Route::post('seats', [SeatController::class, 'store']);
    Route::put('seats/{id}', [SeatController::class, 'update']);
    Route::delete('seats/{id}', [SeatController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Tickets
    |--------------------------------------------------------------------------
    */
    Route::get('tickets', [TicketController::class, 'index']);            // List semua tiket
    Route::get('tickets/{id}', [TicketController::class, 'show']);        // Detail tiket
    Route::get('tickets/{id}/seats', [TicketController::class, 'seats']); // Kursi per tiket
    Route::post('tickets', [TicketController::class, 'store']);           // Tambah tiket
    Route::put('tickets/{id}', [TicketController::class, 'update']);      // Update tiket
    Route::delete('tickets/{id}', [TicketController::class, 'destroy']);  // Hapus tiket
});
