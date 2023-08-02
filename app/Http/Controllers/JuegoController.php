<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class JuegoController extends Controller
{

// Método para consultar juegos
public function consultajuegos(Request $request)
{
    // Obtener el filtro ingresado en el formulario de búsqueda
    $filtro = $request->input('filtro');

    // Obtener todos los juegos o filtrar por nombre si se ha proporcionado un filtro
    $juegos = Juego::when($filtro, function ($query, $filtro) {
        // Utilizamos el método "where" con "like" para buscar juegos que coincidan con el filtro
        return $query->where('nombre', 'like', "%$filtro%");
    })->get();

    // Verificar si no se encontraron juegos para mostrar un mensaje
    $mensaje = null;
    if ($juegos->isEmpty()) {
        $mensaje = 'No se ha encontrado juego en la base de datos';
    }

    // Pasar los juegos, filtro y mensaje a la vista
    $datos = [
        'juegos' => $juegos,
        'filtro' => $filtro,
        'mensaje' => $mensaje,
    ];

    // Retornar la vista "consultajuegos" con los datos a mostrar
    return view('welcome', $datos);
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
                // Mensaje de juego existente
                return $this->mostrarMensajeRedireccionar('altajuego', 'info', 'El juego ya existe en la base de datos general.');
            }

            // Si el juego no existe en la lista general, proceder a crearlo
            $juego = Juego::create($request->all());

            // Obtener id usuario
            $idUsuario = Auth::id();

            // Asociar el juego con el usuario en la tabla de intersección "juego_usuario"
            $juego->usuarios()->attach($idUsuario);

            // Mensaje de éxito
            return $this->mostrarMensajeRedireccionar('home', 'success', 'Juego dado de alta en la BD.');
        } catch (QueryException $e) {
            // Mensaje de error
            return $this->mostrarMensajeRedireccionar('altajuego', 'error', 'Error al guardar el juego: ' . $e->getMessage());
        }
    }

    //Método modificar juego
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

    // Comparamos los datos enviados en el formulario con los datos actuales del juego
    $datosFormulario = $request->all();
    $datosActuales = $juego->toArray();

    if (Arr::except($datosFormulario, ['_token', '_method']) === Arr::except($datosActuales, ['idjuego', 'created_at', 'updated_at'])) {
        // Si los datos son iguales, mostramos un mensaje de advertencia y redireccionamos
        return redirect()->route('modificarjuego', ['juego' => $id])->with('warning', 'No se realizaron cambios en el juego.');
    }

    // Actualizamos los datos del juego
    $juego->update($datosFormulario);

    // Mensaje de éxito
    return $this->mostrarMensajeRedireccionar('consultajuegos', 'success', 'Juego modificado correctamente.');
}

    // Método para eliminar un juego de la base de datos
    public function eliminar($id)
    {
        try {
            // Buscamos el juego a eliminar
            $juego = Juego::findOrFail($id);

            // Eliminamos el juego
            $juego->delete();

            // Juego eliminado correctamente
            return $this->mostrarMensajeRedireccionar('home', 'success', 'Juego eliminado correctamente.');
        } catch (ModelNotFoundException $e) {
            // Mensaje de error
            return $this->mostrarMensajeRedireccionar('home', 'error', 'Juego no existe en la base de datos.');
        } catch (QueryException $e) {
            // Mensaje de error
            return $this->mostrarMensajeRedireccionar('home', 'error', 'Error al eliminar el juego de la BD.');
        }
    }

    //Detalle juego
    public function detalleJuego($id)
    {
        $juego = Juego::findOrFail($id);
        return view('detallejuego', compact('juego'));
    }

    // Función para mostrar mensaje en la vista y redireccionar
    private function mostrarMensajeRedireccionar($ruta, $tipo, $mensaje)
    {
        session()->flash($tipo, $mensaje);
        return redirect()->route($ruta);
    }
}
