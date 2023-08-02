@extends('layout')

@section('contenido')
    <h2>Modificación de {{ $juego->nombre }}</h2>
    <br>
    <form id='formulario' method='post' action="{{ route('actualizarjuego', ['juego' => $juego->idjuego]) }}">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label class="form-label">Juego:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $juego->nombre) }}">
            @error('nombre')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $juego->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Número de jugadores:</label>
            <input type="text" class="form-control" id="n_jugadores" name="n_jugadores" value="{{ old('n_jugadores', $juego->n_jugadores) }}">
            @error('n_jugadores')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Temática:</label>
            <input type="text" class="form-control" id="tematica" name="tematica" value="{{ old('tematica', $juego->tematica) }}">
            @error('tematica')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tiempo de juego (minutos):</label>
            <input type="text" class="form-control" id="tiempo_juego" name="tiempo_juego" value="{{ old('tiempo_juego', $juego->tiempo_juego) }}">
            @error('tiempo_juego')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen:</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="{{ old('imagen', $juego->imagen) }}">
            @error('imagen')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Modificar Juego</button>
    </form>
<!-- Mostrar mensaje de éxito -->
@if (session()->has('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<!-- Mostrar mensaje de información -->
@if (session()->has('info'))
<div class="alert alert-info" role="alert">
    {{ session('info') }}
</div>
@endif

<!-- Mostrar mensaje de advertencia -->
@if (session()->has('warning'))
<div class="alert alert-warning" role="alert">
    {{ session('warning') }}
</div>
@endif

<!-- Mostrar mensaje de error -->
@if (session()->has('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif

<!-- Mostrar mensajes de error de validación -->
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
