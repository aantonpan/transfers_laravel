<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Traveler;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;

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
    $travelers = Traveler::with('user')->get();

    return view('admin.admin-createReservation', compact('hotels', 'travelers'));
}

// Almacenar la nueva reserva en la base de datos
public function storeReservation(Request $request)
{
    // Validar la entrada
    $request->validate([
        'traveler_id' => 'required|exists:travelers,id',
        'hotel_id' => 'required|exists:hotels,id',
        'booking_date' => 'required|date',
    ]);
    
      // Crear una nueva reserva asociada al viajero
      $booking = new Booking();
      $booking->traveler_id = $request->traveler_id;
      $booking->hotel_id = $request->hotel_id;
      $booking->booking_date = $request->booking_date;
      $booking->save();

    // Redirigir con éxito
    return redirect()->route('admin.bookings')->with('success', 'Reserva creada con éxito.');
}
}
