<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\TravelersController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\AdminController;

// Ruta de ejemplo para verificar la API
Route::get('/check', function () {
    return response()->json(['status' => 'API is working'], 200);
});

// Rutas de Hotels
Route::get('/hotels', [HotelsController::class, 'index']); // Listar hoteles
Route::get('/hotels/{id}', [HotelsController::class, 'show']); // Mostrar un hotel
Route::post('/hotels', [HotelsController::class, 'store']); // Crear hotel
Route::put('/hotels/{id}', [HotelsController::class, 'update']); // Actualizar hotel
Route::delete('/hotels/{id}', [HotelsController::class, 'destroy']); // Eliminar hotel

// Rutas de Vehicles
Route::get('/vehicles', [VehiclesController::class, 'index']); // Listar vehículos
Route::get('/vehicles/{id}', [VehiclesController::class, 'show']); // Mostrar vehículo
Route::post('/vehicles', [VehiclesController::class, 'store']); // Crear vehículo
Route::put('/vehicles/{id}', [VehiclesController::class, 'update']); // Actualizar vehículo
Route::delete('/vehicles/{id}', [VehiclesController::class, 'destroy']); // Eliminar vehículo

// Rutas de Travelers
Route::get('/travelers', [TravelersController::class, 'index']); // Listar viajeros
Route::get('/travelers/{id}', [TravelersController::class, 'show']); // Mostrar viajero
Route::post('/travelers', [TravelersController::class, 'store']); // Crear viajero
Route::put('/travelers/{id}', [TravelersController::class, 'update']); // Actualizar viajero
Route::delete('/travelers/{id}', [TravelersController::class, 'destroy']); // Eliminar viajero

// Rutas de Bookings
Route::get('/bookings', [BookingsController::class, 'index']); // Listar reservas
Route::get('/bookings/{id}', [BookingsController::class, 'show']); // Mostrar reserva
Route::post('/bookings', [BookingsController::class, 'store']); // Crear reserva
Route::put('/bookings/{id}', [BookingsController::class, 'update']); // Actualizar reserva
Route::delete('/bookings/{id}', [BookingsController::class, 'destroy']); // Eliminar reserva

// Rutas de Admin
Route::get('/admin', [AdminController::class, 'index']); // Panel principal
Route::get('/admin/users', [AdminController::class, 'users']); // Listar usuarios
Route::get('/admin/bookings', [AdminController::class, 'bookings']); // Listar reservas
Route::get('/admin/hotels', [AdminController::class, 'hotels']); // Listar hoteles
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']); // Actualizar usuario
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']); // Eliminar usuario
