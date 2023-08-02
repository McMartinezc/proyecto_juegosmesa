@extends('layout')

@section('contenido')

<!-- La tabla con el listado de juegos -->
@if ($juegos->isEmpty())
    <h4>No se encontraron juegos.</h4>
@else
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
                    <!-- ... Agregar otros botones o acciones si es necesario ... -->
                </td>
            </tr>
        @endforeach
    </table>
@endif
@endsection