<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
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
}
