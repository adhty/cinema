<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Tickets Routes
|--------------------------------------------------------------------------
*/
Route::resource('tickets', TicketController::class);

/*
|--------------------------------------------------------------------------
| Seats Routes
|--------------------------------------------------------------------------
*/
Route::get('/seats', [SeatsController::class, 'index'])->name('seats.index');
Route::get('/seats/{id}', [SeatsController::class, 'show'])->name('seats.show');
Route::get('/seats/ticket/{ticketId}', [SeatsController::class, 'byTicket'])->name('seats.by-ticket');

/*
|--------------------------------------------------------------------------
| Orders Routes
|--------------------------------------------------------------------------
*/
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('orders.show');
Route::put('/orders/{id}/payment', [OrdersController::class, 'updatePayment'])->name('orders.update-payment');
Route::put('/orders/{id}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');
Route::delete('/orders/{id}', [OrdersController::class, 'destroy'])->name('orders.destroy');

/*
|--------------------------------------------------------------------------
| Customer Booking Routes
|--------------------------------------------------------------------------
*/
Route::get('/booking', [\App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/select-seat/{ticketId}', [\App\Http\Controllers\BookingController::class, 'selectSeat'])->name('booking.select-seat');
Route::get('/booking/customer-form/{seatId}', [\App\Http\Controllers\BookingController::class, 'customerForm'])->name('booking.customer-form');
Route::post('/booking/process/{seatId}', [\App\Http\Controllers\BookingController::class, 'processBooking'])->name('booking.process');
Route::get('/booking/confirmation/{orderId}', [\App\Http\Controllers\BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::post('/booking/simulate-payment/{orderId}', [\App\Http\Controllers\BookingController::class, 'simulatePayment'])->name('booking.simulate-payment');
Route::get('/booking/ticket/{orderId}', [\App\Http\Controllers\BookingController::class, 'ticket'])->name('booking.ticket');
Route::put('/booking/cancel/{orderId}', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('booking.cancel');





/*
|--------------------------------------------------------------------------
| CRUD Cities, Studios, Cinemas
|--------------------------------------------------------------------------
*/
Route::resource('cities', CityController::class);
Route::resource('studios', StudioController::class);
Route::resource('cinemas', CinemaController::class);

/*
|--------------------------------------------------------------------------
| Movies
|--------------------------------------------------------------------------
*/
Route::resource('movies', MovieController::class);

/*
|--------------------------------------------------------------------------
| Promos
|--------------------------------------------------------------------------
*/
Route::resource('promos',PromoController::class);

/*
|--------------------------------------------------------------------------
| Actors (nested di dalam Movies)
|--------------------------------------------------------------------------
*/
// Actors are now managed directly in the movie form
// Route::resource('movies.actors', ActorController::class)->shallow()->only(['create', 'store', 'edit', 'update', 'destroy']);

// Regular actor routes for direct access (if needed)
Route::resource('actors', ActorController::class)->except(['show']);

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->withoutMiddleware(['auth', 'isAdmin']);

Route::post('/login', [LoginController::class, 'login'])
    ->withoutMiddleware(['auth', 'isAdmin']);

    // Logout route
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Default redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'isAdmin']);

