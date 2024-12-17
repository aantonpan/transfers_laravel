<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de importar el modelo User

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login para administradores.
     */
    public function showAdminLoginForm()
    {
        return view('auth.login.login-admin');
    }

    /**
     * Mostrar formulario de login para hoteles.
     */
    public function showHotelLoginForm()
    {
        return view('auth.login.login-hotel');
    }

    /**
     * Mostrar formulario de login para viajeros.
     */
    public function showTravelerLoginForm()
    {
        return view('auth.login.login-traveler');
    }

    /**
     * Procesar login.
     */
    public function login(Request $request)
    {
        // Validar los datos ingresados
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Verificar si el usuario existe
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['error' => 'El correo electrónico no está registrado.'])->withInput();
        }

        // Verificar si la contraseña es válida
        // if (!Hash($request->password, $user->password)) {
        if (!($request->password == $user->password)) {
            return back()->withErrors(['error' => 'La contraseña es incorrecta.'])->withInput();
        }

        // Autenticar al usuario
        Auth::login($user);

        // Redirigir según el rol del usuario
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenido Administrador.');
            case 'hotel':
                return redirect()->route('hotel.dashboard')->with('success', 'Bienvenido al panel del hotel.');
            case 'traveler':
                return redirect()->route('traveler.dashboard')->with('success', 'Bienvenido viajero.');
            default:
                Auth::logout(); // Cerrar sesión si el rol es desconocido
                return redirect()->route('welcome')->withErrors(['error' => 'Rol no autorizado.']);
        }
    }

    /**
     * Cerrar sesión del usuario.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome')->with('success', 'Sesión cerrada correctamente.');
    }
}
