<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Cambia si tu modelo de usuarios tiene otro nombre
use App\Models\Booking; // Si deseas gestionar reservas desde aquí
use App\Models\Hotel; // Para gestionar hoteles

class AdminController extends Controller
{
    /**
     * Mostrar el panel de administración.
     */
    public function index()
    {
        return view('admin.dashboard'); // Asegúrate de tener una vista en resources/views/admin/dashboard.blade.php
    }

    /**
     * Listar todos los usuarios.
     */
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Listar todas las reservas.
     */
    public function bookings()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    /**
     * Listar todos los hoteles.
     */
    public function hotels()
    {
        $hotels = Hotel::all();
        return response()->json($hotels);
    }

    /**
     * Actualizar información de un usuario.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user]);
    }

    /**
     * Eliminar un usuario.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
