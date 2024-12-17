<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Traveler;
use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TravelersController extends Controller
{
    // Mostrar lista de viajeros
    public function index()
    {
        $travelers = User::where('role', 'traveler')->get();
        return view('admin.travelers', compact('travelers'));
    }

    // Actualizar información del viajero
    public function update(Request $request, $id)
    {
        $traveler = User::findOrFail($id);
        $traveler->update($request->only(['name', 'email']));

        return back()->with('success', 'Viajero actualizado correctamente.');
    }

    // Eliminar viajero
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Viajero eliminado correctamente.');
    }

    public function dashboard(){
        $user = Auth::user();
        $traveler = Traveler::where('user_id', $user->id)->first();
        $reservations = Booking::where('traveler_id', $traveler->id)->get();
        return view('traveler.traveler-dashboard', compact('reservations'));
    }

// Mostrar el formulario para crear una nueva reserva
public function create()
{
    // Obtener todos los hoteles disponibles para la reserva
    $hotels = Hotel::all();

    return view('traveler.traveler-createReservation', compact('hotels'));
}

public function store(Request $request)
{

    // Validar la entrada
    $data = $request->validate([
        'reservation_type' => 'required|string',
        'hotel_id' => 'required|exists:hotels,id',
        'travelers_count' => 'required|integer|min:1',
        'arrival_date' => 'nullable|date',
        'arrival_time' => 'nullable',
        'flight_number' => 'nullable|string',
        'origin_airport' => 'nullable|string',
        'flight_day' => 'nullable|date',
        'flight_time' => 'nullable',
        'pickup_time' => 'nullable',
        'flight_number_return' => 'nullable|string',
    ]);

    // Obtener el viajero autenticado
    $user = Auth::user();
     
    $traveler = Traveler::where('user_id', $user->id)->first();
    // Crear la reserva
    $booking = new Booking();
    $booking->user_id = auth()->id(); // ID del usuario logueado
    $booking->traveler_id = $traveler->id; // Asociamos al viajero actual
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

    return redirect()->route('traveler.dashboard')->with('success', 'Reserva creada correctamente.');
}


}
