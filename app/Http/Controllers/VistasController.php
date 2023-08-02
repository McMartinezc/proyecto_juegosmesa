<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Juego;

class VistasController extends Controller
{
    public function welcome()
    {
        // Obtener todos los juegos
        $juegos = Juego::all();
        // Pasar los datos a la vista welcome
        return view('welcome', compact('juegos'));
    }
    
  
   // Vista alta juego
    public function vistaAltaJuego()
    {
        return view('altajuego');
    }

    // Método para mostrar la vista de modificar un juego
    public function vistaModificarJuego($id)
    {
        $juego = Juego::findOrFail($id);
        return view('modificar')->with('juego', $juego);
    }

}
