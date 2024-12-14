<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\TravelersController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\AdminController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta adicional para el home (redirecciona al welcome)
Route::get('/home', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rutas de hoteles (CRUD completo usando resource)
Route::resource('hotels', HotelsController::class);

// Rutas de vehículos (CRUD completo usando resource)
Route::resource('vehicles', VehiclesController::class);

// Rutas de viajeros (CRUD completo usando resource)
Route::resource('travelers', TravelersController::class);

// Rutas de reservas (CRUD completo usando resource)
Route::resource('bookings', BookingsController::class);

// Rutas de administración
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index'); // Panel de administración
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users'); // Listar usuarios
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings'); // Listar reservas
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('admin.hotels'); // Listar hoteles
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update'); // Actualizar usuario
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Eliminar usuario
});

// Ruta adicional para el dashboard
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
