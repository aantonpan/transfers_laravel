<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Traveler;

class RegisterController extends Controller
{
    /**
     * Mostrar formulario de registro para administradores.
     */
    public function showAdminRegisterForm()
    {
        return view('auth.register.register-admin');
    }

    /**
     * Mostrar formulario de registro para hoteles.
     */
    public function showHotelRegisterForm()
    {
        return view('auth.register.register-hotel');
    }

    /**
     * Mostrar formulario de registro para viajeros.
     */
    public function showTravelerRegisterForm()
    {
        return view('auth.register.register-traveler');
    }

    public function showPassportForm()
{
    return view('auth.register.passport');
}

    /**
     * Procesar registro de un nuevo usuario.
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
            'role' => 'required|in:admin,hotel,traveler',
        ]);
        // echo($request->password);die;
        // Crear el usuario en la base de datos
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($request->password), // Encriptar la contraseña
            'role' => $validatedData['role'], // Guardar el rol del usuario
        ]);

        // Autenticar al usuario recién creado
        auth()->login($user);

        // Redirigir según el rol del usuario
    if ($user->role === 'traveler') {
        return redirect()->route('traveler.passport.form')->with('success', 'Registro exitoso como Viajero. Ingresa tu número de pasaporte.');
    }

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard')->with('success', 'Registro exitoso como Administrador.');
        case 'hotel':
            return redirect()->route('hotel.dashboard')->with('success', 'Registro exitoso como Hotel.');
        default:
            return redirect()->route('welcome')->withErrors(['error' => 'Rol no válido.']);
    }
    }

    public function storePassport(Request $request)
    {
        $request->validate([
            'passport_number' => 'required|string',
        ]);

        // Asumimos que el usuario ya está autenticado
        $user = auth()->user();

        // Crear un nuevo registro en la tabla travelers
        $traveler = Traveler::create([
            'user_id' => $user->id,  // Asociamos el usuario autenticado
            'passport_number' => $request->passport_number,  // Guardamos el número de pasaporte
        ]);

        return redirect()->route('traveler.dashboard')->with('success', 'Número de pasaporte guardado correctamente.');
    }
}