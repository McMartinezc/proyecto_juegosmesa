<!-- web -->
<?php

use App\Http\Controllers\Auth\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AutenticacionSesionController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\VistasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', [VistasController::class, 'welcome'])->name('home');

// Ruta para consulta juegos
Route::get('/juegos', [JuegoController::class, 'consultaJuegos'])->name('consultajuegos');

// AUTH
// Rutas para el formulario de registro
Route::get('/registro', function(){
    return view('auth.registro');
})->name('registro');
Route::post('/registro', [UsuarioController::class, 'registro'])->name('registro');

// Rutas para el formulario de login
Route::get('/login', function(){
    return view('auth.login');
})->name('login');
Route::post('/login', [AutenticacionSesionController::class, 'login'])->name('login');
Route::post('/logout', [AutenticacionSesionController::class, 'logout'])->name('logout');

// Rutas para el CRUD de juegos (alta, modificación, baja)
Route::get('/juegos/alta', [VistasController::class, 'vistaAltaJuego'])->name('altajuego')->middleware('auth');
Route::post('/juegos/alta', [JuegoController::class, 'guardar'])->name('guardarjuego')->middleware('auth');
Route::get('/juegos/{juego}/modificar', [VistasController::class, 'vistaModificarJuego'])->name('modificarjuego')->middleware('auth');
Route::put('/juegos/{juego}/modificar', [JuegoController::class, 'actualizar'])->name('actualizarjuego')->middleware('auth');
Route::delete('/juegos/{juego}/eliminar', [JuegoController::class, 'eliminar'])->name('eliminarjuego')->middleware('auth');
Route::get('/juegos/{juego}', [JuegoController::class, 'detalleJuego'])->name('detallejuego');

