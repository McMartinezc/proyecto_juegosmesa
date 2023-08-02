<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JuegoController extends Controller
{
    // Método para consultar juegos
    public function consultaJuegos(Request $request)
    {
        $filtro = $request->input('filtro');

        // Utilizar el método consulta() para obtener los juegos filtrados
        $juegos = Juego::consulta($filtro);

        // Verificar si no se encontraron juegos
        $mensaje = null;
        if ($juegos->isEmpty()) {
            $mensaje = 'No se ha encontrado juego en la base de datos';
        }

        return view('welcome', compact('juegos', 'filtro', 'mensaje'));
    }

    //Dar de alta un juego a la base de datos
    public function guardar(Request $request)
    {
        // Validamos datos recibidos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'n_jugadores' => 'required',
            'tematica' => 'required',
            'tiempo_juego' => 'required',
            'imagen' => 'nullable',
        ]);

        if ($validator->fails()) {
            // Agregar log con los errores de validación
            Log::info('Errores de validación:', $validator->errors()->all());
            return redirect()->route('altajuego')->withErrors($validator)->withInput();
        }

        try {
            // Verificamos si el juego existe en la lista general
            $juegoExistente = Juego::where('nombre', $request->input('nombre'))->first();

            if ($juegoExistente) {
                // Agregar log con mensaje informativo
                Log::info('El juego ya existe en la base de datos general.');
                return view('welcome')->with('juegoExistente', $juegoExistente)->with('mensaje', 'El juego ya existe en la base de datos general.');
            }

            // Si el juego no existe en la lista general, proceder a crearlo
            $juego = Juego::create($request->all());

            // Obtener id usuario
            $idUsuario = Auth::id();

            // Asociar el juego con el usuario en la tabla de intersección "juego_usuario"
            $juego->usuarios()->attach($idUsuario);

            // Agregar log con los datos del juego creado
            // Log::info('Juego creado:', $juego->toArray());

            return redirect()->route('welcome')->with('success', 'Juego dado de alta en la BD.');
        } catch (QueryException $e) {
            // Agregar log con la excepción
            Log::error('Error al guardar el juego:', ['exception' => $e->getMessage()]);
            $datos['juego'] = $request->all();
            $datos['mensaje'] = $e->getMessage();
            return view('altajuego')->with($datos);
        }
    }

    // Método para actualizar los datos de un juego en la base de datos
    public function actualizar(Request $request, $id)
    {
        // Buscamos el juego a modificar
        $juego = Juego::findOrFail($id);

        // Validamos datos recibidos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'n_jugadores' => 'required',
            'tematica' => 'required',
            'tiempo_juego' => 'required',
            'imagen' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('modificarjuego', ['juego' => $id])->withErrors($validator)->withInput();
        }

        // Actualizamos los datos del juego
        $juego->update($request->all());

        return redirect()->route('consultajuegos')->with('status', 'Juego modificado correctamente.');
    }

    // Método para eliminar un juego de la base de datos
    public function eliminar($id)
    {
        try {
            // Buscamos el juego a eliminar
            $juego = Juego::findOrFail($id);

            // Eliminamos el juego
            $juego->delete();

            return redirect()->route('home')->with('status', 'Juego eliminado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home')->with('error', 'Juego no existe en la base de datos.');
        } catch (QueryException $e) {
            return redirect()->route('home')->with('error', 'Error al eliminar el juego de la BD.');
        }
    }


    //Detalle juego
    public function detalleJuego($id)
    {
        $juego = Juego::findOrFail($id);
        return view('detallejuego', compact('juego'));
    }
}
