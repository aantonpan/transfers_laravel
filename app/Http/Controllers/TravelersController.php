<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
