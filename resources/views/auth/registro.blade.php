<!-- registro.blade -->
@extends('layout')

@section('contenido')
<h2>Registro de usuario</h2>
<form method="POST" action="{{ route('registro') }}">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') ?? null }}">
    </div>
    <!--Mensaje error-->
    @error('nombre')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="text" class="form-control" id="foto" name="foto" accept="image/*" value="{{ old('foto') ?? null }}">
    </div>
    <!--Mensaje error-->
    @error('foto')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? null }}">
    </div>
    <!--Mensaje error-->
    @error('email')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <!--Mensaje error-->
    @error('password')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <!--Mensaje error-->
    @error('password_confirmation')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<!--Mensajes-->
@if(session('status'))
<div class="alert alert-warning" role="alert">{{ session('status') }}</div>
@endif

@endsection