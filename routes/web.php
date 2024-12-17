<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\TravelersController;
use App\Http\Controllers\Auth\LoginController;

// Página principal - Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación
Route::prefix('login')->group(function () {
    Route::get('admin', [LoginController::class, 'showAdminLoginForm'])->name('login.admin');
    Route::get('hotel', [LoginController::class, 'showHotelLoginForm'])->name('login.hotel');
    Route::get('traveler', [LoginController::class, 'showTravelerLoginForm'])->name('login.traveler');
    Route::post('/', [LoginController::class, 'login'])->name('login');
    Route::post('hotel', [LoginController::class, 'login'])->name('hotel.login.post');
    Route::post('traveler', [LoginController::class, 'login'])->name('traveler.login.post');
    Route::post('admin', [LoginController::class, 'login'])->name('admin.login.post');
});

// Rutas para los registros
Route::prefix('register')->group(function () {
    Route::get('hotel', function () {
        return view('auth.register.register-hotel');
    })->name('register.hotel');
    Route::get('traveler', function () {
        return view('auth.register.register-traveler');
    })->name('register.traveler');
});

// Ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard del usuario según su rol (autenticación obligatoria)
Route::middleware('auth')->group(function () {
    // Rutas para el administrador
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
        Route::get('/travelers', [AdminController::class, 'travelers'])->name('admin.travelers');
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });

    // Rutas para hoteles
    Route::prefix('hotel')->group(function () {
        Route::get('/dashboard', [HotelsController::class, 'dashboard'])->name('hotel.dashboard');
    });

    // Rutas para viajeros
    Route::prefix('traveler')->group(function () {
        Route::get('/dashboard', [TravelersController::class, 'dashboard'])->name('traveler.dashboard');
    });
});

// Rutas de recursos CRUD para hoteles
Route::resource('hotels', HotelsController::class)->only([
    'index', 'update', 'destroy'
]);

// Rutas de recursos CRUD para viajeros
Route::resource('travelers', TravelersController::class)->only([
    'index', 'update', 'destroy'
]);

// Rutas de recursos CRUD para reservas (bookings)
Route::resource('bookings', BookingsController::class)->only([
    'index', 'update', 'destroy'
]);

// Route::get('/hotel/dashboard', function () {
//     if (Auth::check() && Auth::user()->role === 'hotel') {
//         $reservations = Auth::user()->hotelBookings; // Cargar reservas
//         return view('hotels.dashboard', compact('reservations'));
//     }

//     // Si no cumple la condición, redirige a la página principal
//     return redirect()->route('welcome')->withErrors(['error' => 'Acceso denegado.']);
// })->middleware('auth')->name('hotel.dashboard');
