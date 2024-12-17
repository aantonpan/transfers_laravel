<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

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
            // echo(json_encode($reservations));die;
            return view('hotel.hotel-dashboard', compact('hotels'));
        }
        // Si no tiene acceso, redirigir con error
        return redirect()->route('welcome')->withErrors(['error' => 'Acceso denegado: No tienes permisos.']);
    }


    // Actualizar información del hotel
    public function update(Request $request, $id)
    {
        $hotel = User::findOrFail($id);
        $hotel->update($request->only(['name', 'email']));

        return back()->with('success', 'Hotel actualizado correctamente.');
    }

    // Eliminar hotel
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Hotel eliminado correctamente.');
    }

}
