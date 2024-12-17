<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\TravelersController;
use App\Http\Controllers\BookingsController;

// Ruta de verificación de la API
Route::get('/check', function () {
    return response()->json(['status' => 'API is working'], 200);
});

// Grupo de rutas para la API de Hoteles
Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelsController::class, 'index']);      // Listar todos los hoteles
    Route::get('/{id}', [HotelsController::class, 'show']);   // Mostrar un hotel específico
    Route::post('/', [HotelsController::class, 'store']);     // Crear un hotel
    Route::put('/{id}', [HotelsController::class, 'update']); // Actualizar un hotel
    Route::delete('/{id}', [HotelsController::class, 'destroy']); // Eliminar un hotel
});

// Grupo de rutas para la API de Viajeros
Route::prefix('travelers')->group(function () {
    Route::get('/', [TravelersController::class, 'index']);
    Route::get('/{id}', [TravelersController::class, 'show']);
    Route::post('/', [TravelersController::class, 'store']);
    Route::put('/{id}', [TravelersController::class, 'update']);
    Route::delete('/{id}', [TravelersController::class, 'destroy']);
});

// Grupo de rutas para la API de Reservas
Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingsController::class, 'index']);
    Route::get('/{id}', [BookingsController::class, 'show']);
    Route::post('/', [BookingsController::class, 'store']);
    Route::put('/{id}', [BookingsController::class, 'update']);
    Route::delete('/{id}', [BookingsController::class, 'destroy']);
});
