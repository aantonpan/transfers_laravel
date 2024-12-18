<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Traveler;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard principal del administrador
    public function index()
    {
        return view('admin.admin-dashboard');
    }

    // Listado de hoteles
    public function hotels()
    {
        $hotels = User::where('role', 'hotel')->get();
        return view('admin.hotels', compact('hotels'));
    }

    // Listado de viajeros
    public function travelers()
    {
        $travelers = User::where('role', 'traveler')->get();
        return view('admin.travelers', compact('travelers'));
    }

    // Listado de reservas
    public function bookings()
    {
        $bookings = Booking::with(['hotel', 'traveler'])->get();
        return view('admin.bookings', compact('bookings'));
    }

    // Eliminar usuario (hotel o viajero)
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
    public function createReservation()
{
    // Obtener todos los hoteles disponibles para la reserva
    $hotels = Hotel::all();
    // Obtener todos los hoteles disponibles para la reserva
    $user = Auth::user();
    $travelers = User::where('role', 'traveler')->get();
    
    return view('admin.admin-createReservation', compact('hotels', 'travelers'));
}

// Almacenar la nueva reserva en la base de datos
public function storeReservation(Request $request)
{
     // Validar la entrada
     $data = $request->validate([
        'reservation_type' => 'required|string',
        'hotel_id' => 'required|exists:hotels,id',
        'travelers_count' => 'required|integer|min:1',
        'traveler_id' => 'required|exists:users,id', // Validar que el viajero existe en la tabla de usuarios
        'arrival_date' => 'nullable|date',
        'arrival_time' => 'nullable',
        'flight_number' => 'nullable|string',
        'origin_airport' => 'nullable|string',
        'flight_day' => 'nullable|date',
        'flight_time' => 'nullable',
        'pickup_time' => 'nullable',
        'flight_number_return' => 'nullable|string',
    ]);

    // Obtener el viajero de la tabla travelers
    $traveler = Traveler::where('user_id', $data['traveler_id'])->first();

    // Crear la reserva
    $booking = new Booking();
    $booking->user_id = auth()->id(); // ID del usuario logueado
    $booking->traveler_id = $traveler->id;  // ID del viajero seleccionado
    $booking->hotel_id = $data['hotel_id'];
    $booking->reservation_type = $data['reservation_type'];
    $booking->travelers_count = $data['travelers_count'];
    $booking->arrival_date = $data['arrival_date'] ?? null;
    $booking->arrival_time = $data['arrival_time'] ?? null;
    $booking->flight_number = $data['flight_number'] ?? null;
    $booking->origin_airport = $data['origin_airport'] ?? null;
    $booking->flight_day = $data['flight_day'] ?? null;
    $booking->flight_time = $data['flight_time'] ?? null;
    $booking->pickup_time = $data['pickup_time'] ?? null;
    $booking->flight_number_return = $data['flight_number_return'] ?? null;
    $booking->booking_date = now();
    $booking->save();

    // Redirigir con éxito
    return redirect()->route('admin.bookings')->with('success', 'Reserva creada con éxito.');
}
}
