@extends('layout')

@section('contenido')
    <!-- Contenido de la vista de detalle -->
    <div class="card">
        @if ($juego->imagen)
        <img src="{{ $juego->imagen }}" class="card-img-top" alt="{{ $juego->nombre }}">
        @else
        <img src="/img/joc.jpg" class="card-img-top-none" alt="{{ $juego->nombre }}">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $juego->nombre }}</h5>
            <p class="card-text"><strong>Número de Jugadores:</strong> {{ $juego->n_jugadores }}</p>
            <p class="card-text"><strong>Tiempo de Juego:</strong> {{ $juego->tiempo_juego }}</p>
            <p class="card-text"><strong>Temática:</strong> {{ $juego->tematica }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $juego->descripcion }}</p>
        </div>
    </div>
@endsection

