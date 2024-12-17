<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class HotelsController extends Controller
{
    // Mostrar lista de hoteles
    public function index()
    {
        $hotels = User::where('role', 'hotel')->get();
        return view('admin.hotels', compact('hotels'));
    }

    public function dashboard()
    {
        // Verificar si el usuario está autenticado y tiene el rol adecuado
        if (Auth::check() && Auth::user()->role === 'hotel') {
            $reservations = Auth::user()->hotelBookings; // Obtener las reservas asociadas
            return view('hotels.dashboard', compact('reservations'));
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
