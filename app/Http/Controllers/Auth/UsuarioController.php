<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Authenticatable
{
     //Alta usuario
     public function registro(Request $datos){

        $datos->validate([
            'nombre'=>'required|string',
            'password'=>'required|string|confirmed',
            'email'=>'required|email|unique:usuarios,email',
            'foto'=>'nullable',
        ]);

        //Creamos nuevo usuario
        $usuario = Usuario::create([
            'nombre'=>$datos['nombre'],
            'email'=>$datos['email'],
            'password'=>bcrypt($datos['password']),
            'foto'=>$datos['foto'],
        ]);

        Auth::login($usuario);
        return redirect()->route('home');
    }
}
