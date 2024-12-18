<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Traveler;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function bookings()
    {
        $bookings = Booking::with(['hotel', 'traveler'])->get();
        $hotels = Hotel::all();
        $travelers = Traveler::all();
        return view('admin.bookings', compact('bookings', 'hotels', 'travelers'));
    }

    public function profile()
    {
        // Obtener el usuario logueado
        $user = Auth::user();

        // Obtener el viajero asociado al usuario
        $traveler = Traveler::where('user_id', $user->id)->first();
        // Retornar la vista con los datos del viajero
        return view('profile.adminProfile', compact('traveler', 'user'));
    }

    public function updateProfile(Request $request)
    {
        // Validar los campos del perfil
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'name' => 'required|string|max:255',
    ]);
    
    // Obtener el usuario autenticado
    $user = Auth::user();
    
    $hotels = Hotel::where('user_id', $user->id)->get();

    // Actualizar los datos del perfil
    $user->name = $request->name;
    $user->email = $request->email;

    
    
    $user->save();
    

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
