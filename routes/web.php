<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\TravelersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// Página principal - Landing Page
Route::get('/', function () {
    $user = Auth::user();
    if (!$user){
        return view('welcome');
    }
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenido Administrador.');
        case 'hotel':
            return redirect()->route('hotel.dashboard')->with('success', 'Bienvenido al panel del hotel.');
        case 'traveler':
            return redirect()->route('traveler.dashboard')->with('success', 'Bienvenido viajero.');
        default:
            Auth::logout(); // Cerrar sesión si el rol es desconocido
            return redirect()->route('welcome')->withErrors(['error' => 'Rol no autorizado.']);
    }
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
Route::prefix('register')->group(function () {
    Route::get('hotel', [RegisterController::class, 'showHotelRegisterForm'])->name('register.hotel'); // Mostrar el formulario
    Route::get('traveler', [RegisterController::class, 'showHotelRegisterForm'])->name('register.traveler'); // Mostrar el formulario
    Route::get('admin', [RegisterController::class, 'showHotelRegisterForm'])->name('register.admin'); // Mostrar el formulario
    
    Route::post('hotel', [RegisterController::class, 'register'])->name('hotel.register'); // Procesar el registro
    Route::post('traveler', [RegisterController::class, 'register'])->name('traveler.register'); // Procesar el registro
    Route::post('admin', [RegisterController::class, 'register'])->name('admin.register'); // Procesar el registro
});

Route::get('/traveler/passport', [RegisterController::class, 'showPassportForm'])->name('traveler.passport.form');
Route::post('/traveler/passport', [RegisterController::class, 'storePassport'])->name('traveler.passport.store');

// Ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard del usuario según su rol (autenticación obligatoria)
Route::middleware('auth')->group(function () {
    // Rutas para el administrador
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
        Route::put('/hotels/{id}', [HotelsController::class, 'update'])->name('admin.hotels.update');
        Route::delete('/hotels/{id}', [AdminController::class, 'deleteUser'])->name('admin.hotels.delete');
        
        Route::get('/travelers', [AdminController::class, 'travelers'])->name('admin.travelers');
        Route::put('/travelers/{id}', [AdminController::class, 'updateUser'])->name('admin.travelers.update');
        Route::delete('/travelers/{id}', [AdminController::class, 'deleteUser'])->name('admin.travelers.delete');
        

        Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
        Route::put('/bookings/{id}', [BookingsController::class, 'update'])->name('admin.bookings.update');
        Route::delete('/bookings/{id}', [BookingsController::class, 'destroy'])->name('admin.bookings.delete');
        
        Route::get('/bookings/createReservation', [AdminController::class, 'createReservation'])->name('admin.createReservation');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
        
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
        Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
        Route::put('/bookings/updateBooking/{id}', [BookingsController::class, 'updateBooking'])->name('admin.updateBooking');
         
        Route::post('/bookings/createReservation', [AdminController::class, 'storeReservation'])->name('admin.createReservation.store');
    
    });

    // Rutas para hoteles
    Route::prefix('hotel')->group(function () {
        Route::get('/dashboard', [HotelsController::class, 'dashboard'])->name('hotel.dashboard');
        Route::get('/reservations', [HotelsController::class, 'reservations'])->name('hotel.reservations');
        Route::get('/createHotel', [HotelsController::class, 'createHotel'])->name('hotel.createHotel');
        Route::get('/reservations/createReservation', [HotelsController::class, 'createReservation'])->name('hotel.createReservation');
        Route::get('/profile', [HotelsController::class, 'profile'])->name('hotel.profile');

        Route::put('/profile', [HotelsController::class, 'updateProfile'])->name('hotel.updateProfile');
        Route::put('/profile/password', [HotelsController::class, 'updatePassword'])->name('hotel.updatePassword');
        Route::put('/hotels/{id}', [HotelsController::class, 'update'])->name('hotel.hotels.update');
        Route::put('/admin/bookings/{id}', [AdminBookingController::class, 'updateBooking'])->name('admin.updateBooking');

        Route::delete('/hotels/{id}', [HotelsController::class, 'destroy'])->name('hotel.hotels.delete');
        Route::delete('/reservations/{id}', [HotelsController::class, 'destroy'])->name('hotel.reservations.delete');


        Route::post('/createHotel', [HotelsController::class, 'storeHotel'])->name('hotel.CreateHotel.store');
        Route::post('/reservations/createReservation', [HotelsController::class, 'storeReservation'])->name('hotel.createReservation.store');
    
   
    });

    // Rutas para viajeros
    Route::prefix('traveler')->group(function () {
        Route::get('/dashboard', [TravelersController::class, 'dashboard'])->name('traveler.dashboard');
        Route::get('/reservation', [TravelersController::class, 'create'])->name('traveler.reservation.create');
        Route::get('/profile', [TravelersController::class, 'profile'])->name('traveler.profile');

        Route::put('/profile', [TravelersController::class, 'updateProfile'])->name('traveler.updateProfile');
        Route::put('/profile/password', [TravelersController::class, 'updatePassword'])->name('traveler.updatePassword');
        // Ruta para almacenar la nueva reserva
        Route::post('/reservation', [TravelersController::class, 'store'])->name('traveler.reservation.store');
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
