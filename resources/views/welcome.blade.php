@extends('layout')

@section('contenido')
<!-- Saludo al usuario si está autenticado -->
@auth
<section class="usuari">
    <div class="img-container">
    @if (Auth::user()->foto)
        <img src="{{ Auth::user()->foto }}" alt="{{ Auth::user()->nombre }}">
    @else
        <img src="/img/user.png" alt="{{ Auth::user()->nombre }}">
    @endif
    </div>

    <h2>¡Hola, {{ Auth::user()->nombre }}!</h2>
</section>
@endauth

<!-- Mostrar mensaje si está seteado -->
@if (isset($mensaje))
<div class="alert alert-success" role="alert">{{ $mensaje }}</div>
@endif

<!-- Mostrar mensaje si está seteado -->
@if (session()->has('success'))
<div class="alert alert-success" role="alert">{{ session('success') }}</div>
@endif

<!-- Tabla con el listado de juegos -->
<table id='juegos' class="table table-striped">
    <tr>
        <th>Juego</th>
        <th>Nº Jugadores</th>
        <th>Temática</th>
        <th>Tiempo Juego</th>
        <th>Acciones</th>
    </tr>
    @foreach ($juegos as $juego)
    <tr>
        <td>{{ $juego->nombre }}</td>
        <td>{{ $juego->n_jugadores }}</td>
        <td>{{ $juego->tematica }}</td>
        <td>{{ $juego->tiempo_juego }}</td>
        <td>
            <!-- Botón para ver el detalle del juego -->
            <a href="{{ route('detallejuego', ['juego' => $juego->idjuego]) }}" class="btn btn-primary">Detalle</a>

            <!-- Mostrar botones solo cuando el usuario está autenticado -->
            @auth
            <!-- Botón para modificar el juego -->
            <a href="{{ route('modificarjuego', ['juego' => $juego->idjuego]) }}" class="btn btn-success">Editar</a>

            <!-- Formulario para eliminar el juego -->
            <form action="{{ route('eliminarjuego', ['juego' => $juego->idjuego]) }}" method="POST" style="display: inline-block;">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            @endauth
        </td>
    </tr>
    @endforeach
</table>

<!--Botón alta juego solo cuando el usuario está autenticado -->
@auth
<a href="{{ route('altajuego') }}" class="btn btn-primary">Dar de alta un juego</a>
@endauth

@endsection