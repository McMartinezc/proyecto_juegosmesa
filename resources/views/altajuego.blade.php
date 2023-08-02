@extends('layout')

@section('contenido')
    <h2>Alta de Juego</h2>
    <form method="POST" action="{{ route('guardarjuego') }}">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required autofocus>
        </div>

        <div class="mb-3">
        <label class="form-label">Descripción:</label>
        <textarea class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="n_jugadores" class="form-label">Nº Jugadores</label>
            <input type="text" class="form-control" id="n_jugadores" name="n_jugadores" value="{{ old('n_jugadores') }}" required>
        </div>

        <div class="mb-3">
            <label for="tematica" class="form-label">Temática</label>
            <input type="text" class="form-control" id="tematica" name="tematica" value="{{ old('tematica') }}" required>
        </div>

        <div class="mb-3">
            <label for="tiempo_juego" class="form-label">Tiempo Juego</label>
            <input type="text" class="form-control" id="tiempo_juego" name="tiempo_juego" value="{{ old('tiempo_juego') }}" required>
        </div>

        <div class="mb-3">
            <label for="tiempo_juego" class="form-label">Imagen del juego:</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="{{ old('imagen') }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
