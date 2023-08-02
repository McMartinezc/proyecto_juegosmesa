<!-- login.blade -->
@extends('layout')

@section('contenido')
    <h2>Iniciar sesión</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? null }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Recuérdame</label>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar sesión</button>

        <!-- Para mostrar los mensajes de error de credenciales -->
        @error('login')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
    </form>
    <!-- Para mostrar el estado de la sesión del usuario -->
    @if(session('status'))
        <div class="alert alert-warning" role="alert">{{ session('status') }}</div>
    @endif
@endsection
