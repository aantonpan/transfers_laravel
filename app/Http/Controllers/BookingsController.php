<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    // Mostrar listado de bookings
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }

    // Mostrar formulario para crear un nuevo booking
    public function create()
    {
        return view('bookings.create');
    }

    // Guardar un nuevo booking
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        Booking::create($request->all());
        return redirect()->route('bookings.index')->with('success', 'Booking creado exitosamente.');
    }

    // Mostrar formulario para editar un booking existente
    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    // Actualizar un booking existente
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $booking->update($request->all());
        return redirect()->route('bookings.index')->with('success', 'Booking actualizado exitosamente.');
    }

    // Eliminar un booking
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking eliminado exitosamente.');
    }
}
