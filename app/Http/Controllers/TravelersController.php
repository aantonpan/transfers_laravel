<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Traveler;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class TravelersController extends Controller
{
    // Mostrar lista de viajeros
    public function index()
    {
        $travelers = User::where('role', 'traveler')->get();
        return view('admin.travelers', compact('travelers'));
    }

    
    // Actualizar información del viajero
    public function updateProfile(Request $request)
    {
        // Validar los campos del perfil
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'passport_number' => 'required|string|max:255',
    ]);
    
    // Obtener el usuario autenticado
    $user = Auth::user();
    $traveler = Traveler::where('user_id', $user->id)->first();

    // Actualizar los datos del perfil
    $user->name = $request->name;
    $user->email = $request->email;

    $traveler->passport_number = $request->passport_number;
    
    $user->save();
    $traveler->save();

        // Redirigir con éxito
        return back()->with('success', 'Perfil actualizado correctamente.');
    }
    public function updatePassword(Request $request)
{
    // Validar los campos de la contraseña
    $request->validate([
        'current_password' => 'required|string|min:4',
        'new_password' => 'required|string|min:4',  // Asegúrate de que las contraseñas coinciden
    ]);
    
    // Obtener el usuario autenticado
    $user = Auth::user();
    // Verificar si la contraseña actual es correcta
    if (Hash::check($request->current_password, $user->password)) {
        
    // Cambiar la contraseña, asegurándote de usar Hash::make() para cifrar
    $user->password = Hash::make($request->new_password); 
    $user->save();
    
    // Redirigir con un mensaje de éxito
    return back()->with('success', 'Contraseña actualizada correctamente.');
    }
    return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
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
    public function profile()
    {
        // Obtener el usuario logueado
        $user = Auth::user();

        // Obtener el viajero asociado al usuario
        $traveler = Traveler::where('user_id', $user->id)->first();
        // Retornar la vista con los datos del viajero
        return view('profile.travelerProfile', compact('traveler', 'user'));
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
        'pickup_airport' => 'nullable|string',
    ]);

    // Obtener el viajero autenticado
    $user = Auth::user();
    $hotel = Hotel::where('id', $request->hotel_id)->first();
    $traveler = Traveler::where('user_id', $user->id)->first();
    $userType = auth()->user()->role;
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
    $booking->pickup_airport = $data['pickup_airport'] ?? null;
    $booking->booking_date = now();
    $booking->user_type = $userType;

    if ($data['reservation_type'] === 'ida_vuelta') {
        $booking->price_total = 40; // Precio total para ida y vuelta
        $booking->price_hotel = 29; // Lo que recibe el hotel
    } else {
        $booking->price_total = 25; // Precio total para ida o vuelta
        $booking->price_hotel = 18; // Lo que recibe el hotel
    }

    $booking->save();

    // Crear trayectos
    if ($data['reservation_type'] === 'aeropuerto_hotel' || $data['reservation_type'] === 'ida_vuelta') {
        // Trayecto de ida
        $journey = new Journey();
        $journey->booking_id = $booking->id;
        $journey->type = 'ida';
        $journey->date = $data['arrival_date'];
        $journey->time = $data['arrival_time'];
        $journey->origin = $data['origin_airport'];
        $journey->destination = $hotel->name;
        $journey->travelers_count = $data['travelers_count'];
        $journey->traveler_mail = $user->email;
        $journey->save();
    }

    if ($data['reservation_type'] === 'hotel_aeropuerto' || $data['reservation_type'] === 'ida_vuelta') {
        // Trayecto de vuelta
        $journey = new Journey();
        $journey->booking_id = $booking->id;
        $journey->type = 'vuelta';
        $journey->date = $data['flight_day'];
        $journey->time = $data['pickup_time'];
        $journey->origin = $hotel->name;
        $journey->destination = $data['pickup_airport'];
        $journey->travelers_count = $data['travelers_count'];
        $journey->traveler_mail = $user->email;
        $journey->save();
    }


    return redirect()->route('traveler.dashboard')->with('success', 'Reserva creada correctamente.');
}


}
