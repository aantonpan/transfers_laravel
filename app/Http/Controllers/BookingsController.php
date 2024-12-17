<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    // Mostrar listado de reservas
    public function index()
    {
        $bookings = Booking::with(['hotel', 'user'])->get();
        return view('admin.bookings', compact('bookings'));
    }

    // Editar reserva
    public function update(Request $request, $id)
    {
        $reservation = Booking::findOrFail($id);
        $reservation->update($request->only(['hotel_id', 'user_id', 'booking_date']));

        return back()->with('success', 'Reserva actualizada correctamente.');
    }

    // Eliminar reserva
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return back()->with('success', 'Reserva eliminada correctamente.');
    }
}
