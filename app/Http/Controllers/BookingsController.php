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

    public function updateBooking(Request $request, $id){
        $reservation = Booking::findOrFail($id);

        $reservation->update($request->only([
            'arrival_date',
            'arrival_time',
            'flight_number',
            'origin_airport',
            'flight_day',
            'flight_time',
            'pickup_time',
            'flight_number_return',
            'pickup_airport',
            'hotel_id',
            'travelers_count',
            'traveler_id',
        ]));


        return back()->with('success', 'Reserva actualizada correctamente.');

    }

    // Eliminar reserva
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return back()->with('success', 'Reserva eliminada correctamente.');
    }
    public function store(Request $request)
{
    $request->validate([
        'reservation_type' => 'required|in:aeropuerto_hotel,hotel_aeropuerto,ida_vuelta',
        'hotel_id' => 'required|exists:hotels,id',
        'traveler_id' => 'required|exists:travelers,id',
        // otras validaciones
    ]);

    // Determinar el tipo de usuario
    $userType = Auth::user()->role; // 'traveler', 'admin', o 'hotel'

    $booking = new Booking($request->all());
    $booking->user_type = $userType;

    // Calcular precios
    $prices = $booking->calculatePrices();
    $booking->price_total = $prices['total'];
    $booking->price_hotel = $prices['hotel'];

    $booking->save();

    return redirect()->route('bookings.index')->with('success', 'Reserva creada correctamente.');
}
}
