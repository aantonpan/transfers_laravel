<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Traveler;
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
}
