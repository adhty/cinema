<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;

Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Tickets
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('/create', [TicketController::class, 'create'])->name('create');
            Route::post('/store', [TicketController::class, 'store'])->name('store');
            Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
            Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
            Route::put('/{ticket}', [TicketController::class, 'update'])->name('update');
            Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        });

        // Seats
        Route::prefix('seats')->name('seats.')->group(function () {
            Route::get('/', [SeatsController::class, 'index'])->name('index');
            Route::get('/create', [SeatsController::class, 'create'])->name('create');
            Route::post('/store', [SeatsController::class, 'store'])->name('store');
            Route::get('/{seat}', [SeatsController::class, 'show'])->name('show');
            Route::get('/{seat}/edit', [SeatsController::class, 'edit'])->name('edit');
            Route::put('/{seat}', [SeatsController::class, 'update'])->name('update');
            Route::delete('/{seat}', [SeatsController::class, 'destroy'])->name('destroy');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('index');
            Route::get('/seats/available', [OrdersController::class, 'availableSeats'])->name('seats.available');
            Route::get('/create', [OrdersController::class, 'create'])->name('create');
            Route::post('/store', [OrdersController::class, 'store'])->name('store');
            Route::get('/{order}', [OrdersController::class, 'show'])->name('show');
            Route::get('/{order}/edit', [OrdersController::class, 'edit'])->name('edit');
            Route::put('/{order}', [OrdersController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrdersController::class, 'destroy'])->name('destroy');
        });

        // Booking
        Route::prefix('booking')->name('booking.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('select-seat/{ticket}', [BookingController::class, 'selectSeat'])->name('select-seat');
            Route::post('customer-form', [BookingController::class, 'loadCustomerForm'])->name('customer-form');
        });

        // Promos
        Route::prefix('promos')->name('promos.')->group(function () {
            Route::get('/', [PromoController::class, 'index'])->name('index');
            Route::get('/create', [PromoController::class, 'create'])->name('create');
            Route::post('/store', [PromoController::class, 'store'])->name('store');
            Route::get('/{promo}', [PromoController::class, 'show'])->name('show');
            Route::get('/{promo}/edit', [PromoController::class, 'edit'])->name('edit');
            Route::put('/{promo}', [PromoController::class, 'update'])->name('update');
            Route::delete('/{promo}', [PromoController::class, 'destroy'])->name('destroy');
        });

        // Cities
        Route::prefix('cities')->name('cities.')->group(function () {
            Route::get('/', [CityController::class, 'index'])->name('index');
            Route::get('/create', [CityController::class, 'create'])->name('create');
            Route::post('/store', [CityController::class, 'store'])->name('store');
            Route::get('/{city}', [CityController::class, 'show'])->name('show');
            Route::get('/{city}/edit', [CityController::class, 'edit'])->name('edit');
            Route::put('/{city}', [CityController::class, 'update'])->name('update');
            Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
        });

        // Studios
        Route::prefix('studios')->name('studios.')->group(function () {
            Route::get('/', [StudioController::class, 'index'])->name('index');
            Route::get('/create', [StudioController::class, 'create'])->name('create');
            Route::post('/store', [StudioController::class, 'store'])->name('store');
            Route::get('/{studio}', [StudioController::class, 'show'])->name('show');
            Route::get('/{studio}/edit', [StudioController::class, 'edit'])->name('edit');
            Route::put('/{studio}', [StudioController::class, 'update'])->name('update');
            Route::delete('/{studio}', [StudioController::class, 'destroy'])->name('destroy');
        });

        // Cinemas
        Route::prefix('cinemas')->name('cinemas.')->group(function () {
            Route::get('/', [CinemaController::class, 'index'])->name('index');
            Route::get('/create', [CinemaController::class, 'create'])->name('create');
            Route::post('/store', [CinemaController::class, 'store'])->name('store');
            Route::get('/{cinema}', [CinemaController::class, 'show'])->name('show');
            Route::get('/{cinema}/edit', [CinemaController::class, 'edit'])->name('edit');
            Route::put('/{cinema}', [CinemaController::class, 'update'])->name('update');
            Route::delete('/{cinema}', [CinemaController::class, 'destroy'])->name('destroy');
        });

        // Movies
        Route::prefix('movies')->name('movies.')->group(function () {
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
        });

        // Actors
        Route::prefix('actors')->name('actors.')->group(function () {
            Route::get('/', [ActorController::class, 'index'])->name('index');
            Route::get('/create', [ActorController::class, 'create'])->name('create');
            Route::post('/store', [ActorController::class, 'store'])->name('store');
            Route::get('/{actor}', [ActorController::class, 'show'])->name('show');
            Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('edit');
            Route::put('/{actor}', [ActorController::class, 'update'])->name('update');
            Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('destroy');
        });

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');      // daftar user
            Route::get('/create', [UserController::class, 'create'])->name('create'); // form tambah
            Route::post('/store', [UserController::class, 'store'])->name('store');   // simpan data baru
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit'); // form edit
            Route::put('/{user}', [UserController::class, 'update'])->name('update'); // update data
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // hapus
        });
    });

// Payment (public)
Route::post('/order', [OrdersController::class, 'store'])->name('order.store');
Route::get('/payment/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->withoutMiddleware(['auth', 'isAdmin']);

Route::post('/login', [LoginController::class, 'login'])
    ->withoutMiddleware(['auth', 'isAdmin']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Redirect default
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'isAdmin']);
