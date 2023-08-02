<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Authenticatable
{
    //Alta usuario
    public function registro(Request $datos)
    {

        $datos->validate([
            'nombre' => 'required|string',
            'password' => 'required|string|confirmed',
            'email' => 'required|email|unique:usuarios,email',
            'foto' => 'nullable',
        ]);

        //Creamos nuevo usuario
        $usuario = Usuario::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'password' => bcrypt($datos['password']),
            'foto' => $datos['foto'],
        ]);

        Auth::login($usuario);
        return redirect()->route('home');
    }

    // Método para mostrar la vista de modificación de usuario
    public function VistaModificar()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Retornar la vista "modificarusuario" con los datos del usuario a mostrar
        return view('modificarusuario', compact('usuario'));
    }

    //Método modificación usuario
    public function actualizar(Request $request, $idusuario)
    {
        // Buscar el usuario por su ID
        $usuario = Usuario::findOrFail($idusuario);
    
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'nullable|string',
            'password' => 'nullable|string|confirmed',
            'foto' => 'nullable|string',
        ]);
    
        // Actualizar los datos del usuario
        if ($request->filled('nombre')) {
            $usuario->nombre = $request->nombre;
        }
    
        // Verificamos si se ha proporcionado una nueva contraseña
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password); // Hasheamos la nueva contraseña
        }
    
        // Verificamos si se ha proporcionado una nueva URL de foto
        if ($request->filled('foto')) {
            $usuario->foto = $request->foto;
        }
    
         // Verificamos si se han realizado cambios en el modelo Usuario
         if (!$usuario->isDirty()) {
            return redirect()->route('modificarusuario')->with('info', 'No se han realizado modificaciones.');
        }

        $usuario->save();
    
        // Redireccionar a la vista de modificación con un mensaje de éxito
        return redirect()->route('modificarusuario')->with('success', 'Información actualizada correctamente.');
    }
    
    
}
