<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Api\SeatController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;

Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Tickets + nested
        Route::resource('tickets', TicketController::class);
        Route::resource('seats', SeatController::class);
        Route::resource('orders', OrderController::class);

        Route::prefix('booking')->name('booking.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('select-seat/{ticket}', [BookingController::class, 'selectSeat'])->name('select-seat');
            Route::post('customer-form', [BookingController::class, 'loadCustomerForm'])->name('customer-form');
        });

        // Promos
        Route::resource('promos', PromoController::class);

        // Cities, Studios, Cinemas
        Route::resource('cities', CityController::class);
        Route::resource('studios', StudioController::class);
        Route::resource('cinemas', CinemaController::class);

        // Movies
        Route::resource('movies', MovieController::class);

        // Actors
        Route::resource('actors', ActorController::class)->except(['show']);
    });

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

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Default redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'isAdmin']);
