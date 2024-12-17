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

// Almacenar la nueva reserva en la base de datos
public function store(Request $request)
{
    // Validar la entrada
    $request->validate([
        'hotel_id' => 'required|exists:hotels,id',
        'booking_date' => 'required|date',
    ]);

     // Obtener el viajero autenticado
     $user = Auth::user();
     
     $traveler = Traveler::where('user_id', $user->id)->first();
    
    
      // Crear una nueva reserva asociada al viajero
      $booking = new Booking();
      $booking->traveler_id = $traveler->id; // Asociamos al viajero actual
      $booking->hotel_id = $request->hotel_id;
      $booking->booking_date = $request->booking_date;
      $booking->save();

    // Redirigir con éxito
    return redirect()->route('traveler.dashboard')->with('success', 'Reserva creada con éxito.');
}


}
