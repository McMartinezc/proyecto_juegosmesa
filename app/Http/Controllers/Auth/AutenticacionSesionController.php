<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AutenticacionSesionController extends Controller
{
    // Método login
    public function login(Request $request)
    {
        // Validamos datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Checkbox
        $recordar = $request->has('remember');

        // Intentamos autenticar al usuario con la opción de "Recuérdame"
        $login = Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ], $recordar);

        if (!$login) {
            return redirect()->route('login')->withErrors(['login' => 'Email o contraseña incorrecto']);
        }
    
        $request->session()->regenerate();
    
        // Pasar el mensaje como parámetro en la redirección hacia la vista home
        return redirect()->route('home')->with(['mensaje' => 'Login Correcto']);
    }

    // Método logout
    public function logout(Request $request)
    {
        // Realizar desconexión, el proveedor será web
        Auth::guard('web')->logout();

        // Invalidamos la sesión iniciada
        $request->session()->invalidate();

        // Generamos un nuevo token para evitar ataques de sesión antigua
        $request->session()->regenerateToken();

        $datos['status'] = 'Usuario desconectado';
        return redirect()->route('login')->with($datos);
    }
}

