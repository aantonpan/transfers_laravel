<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Traveler;
use App\Models\Journey;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HotelsController extends Controller
{
    // Mostrar lista de hoteles
    public function index()
    {
        $hotels = User::where('role', 'hotel')->with('hotels')->get();
        return view('admin.hotels', compact('hotels'));
    }
    public function reservations()
    {
        // Verificar si el usuario está autenticado y tiene el rol adecuado
        if (Auth::check() && Auth::user()->role === 'hotel') {
            $user = Auth::user();
            $hotels = Hotel::where('user_id', $user->id)->get();
            $reservations = [];
            foreach ($hotels as $key => $value) {
                $reservation = $value->getBookingsWithRelations();
                // $reservation = Booking::where('hotel_id', $value->id)->get();
                array_push($reservations, ...$reservation);
            }
            // echo(json_encode($reservations));die;
            return view('hotel.hotel-reservations', compact('reservations'));
        }
        // Si no tiene acceso, redirigir con error
        return redirect()->route('welcome')->withErrors(['error' => 'Acceso denegado: No tienes permisos.']);
    }


    public function dashboard()
    {
        // Verificar si el usuario está autenticado y tiene el rol adecuado
        if (Auth::check() && Auth::user()->role === 'hotel') {
            $user = Auth::user();
            $hotels = Hotel::where('user_id', $user->id)->get();
        
            return view('hotel.hotel-dashboard', compact('hotels'));
        }
        // Si no tiene acceso, redirigir con error
        return redirect()->route('welcome')->withErrors(['error' => 'Acceso denegado: No tienes permisos.']);
    }
    public function profile()
    {
        // Obtener el usuario logueado
        $user = Auth::user();

        // Obtener el viajero asociado al usuario
        $traveler = Traveler::where('user_id', $user->id)->first();
        $hotel = Hotel::where('user_id', $user->id)->first();
        // Retornar la vista con los datos del viajero
        return view('profile.hotelProfile', compact('traveler', 'user', 'hotel'));
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
public function update(Request $request, $id)
{
    // Buscar el hotel por su ID
    $hotel = Hotel::findOrFail($id);
    // Actualizar los campos del hotel con los datos enviados
    $hotel->update($request->only([
        'name', 
        'location', 
    ]));

    // Redirigir con un mensaje de éxito
    return back()->with('success', 'Hotel actualizado correctamente.');
}
    // Eliminar hotel
    public function destroy($id)
    {
        Hotel::findOrFail($id)->delete();
        return back()->with('success', 'Hotel eliminado correctamente.');
    }

// Mostrar el formulario para agregar un nuevo hotel
public function createHotel()
{
    return view('hotel/hotel-createHotel');
}

// Guardar el nuevo hotel en la base de datos
public function storeHotel(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
    ]);

    // Crear el nuevo hotel y asociarlo al usuario autenticado (si se requiere)
    $hotel = new Hotel();
    $hotel->name = $request->name;
    $hotel->location = $request->location;
    $hotel->user_id = Auth::id();  // Asocia el hotel con el usuario autenticado
    $hotel->save();

    return redirect()->route('hotel.dashboard')->with('success', 'Nuevo hotel añadido con éxito.');
}
// Mostrar el formulario para crear una nueva reserva
public function createReservation()
{
    // Obtener todos los hoteles disponibles para la reserva
    $user = Auth::user();
    $users = User::where('role', 'traveler')->get();
    // Filtrar los hoteles asociados al usuario autenticado
    $hotels = Hotel::where('user_id', $user->id)->get();
    

    return view('hotel.hotel-createReservation', compact('hotels', 'users'));
}

// Almacenar la nueva reserva en la base de datos
public function storeReservation(Request $request)
{
     // Validar la entrada
    $data = $request->validate([
        'reservation_type' => 'required|string',
        'hotel_id' => 'required|exists:hotels,id',
        'travelers_count' => 'required|integer|min:1',
        'user_id' => 'required|exists:users,id', // Validar que el viajero existe en la tabla de usuarios
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
    // Obtener el viajero de la tabla travelers
    $traveler = Traveler::where('user_id', $request->user_id)->first();
    $user = User::where('id', $request->user_id)->first();
    $hotel = Hotel::where('id', $request->hotel_id)->first();
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
    $booking->pickup_airport = $data['pickup_airport'] ?? null;
    $booking->booking_date = now();
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

    // Redirigir con éxito
    return redirect()->route('hotel.dashboard')->with('success', 'Reserva creada con éxito.');
}
}
