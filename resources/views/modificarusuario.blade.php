@extends('layout')

@section('contenido')
    <h2>Modificar información de {{ $usuario->nombre }}</h2>
    <br>

    <!-- Mensaje de éxito (si existe) -->
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensaje de información (si existe) -->
    @if(session('info'))
        <div class="alert alert-info" role="alert">
            {{ session('info') }}
        </div>
    @endif

    <!-- Mensajes de error (si existen) -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formulario" method="post" action="{{ route('actualizarusuario', ['idusuario' => $usuario->idusuario]) }}">
        @method('PUT')
        @csrf
        <!--Campo para cambiar el nombre-->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
        </div>
        <!--Mensaje error-->
        @error('nombre')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <!--Campo para cambiar la foto-->
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="text" class="form-control" id="foto" name="foto" value="{{ old('foto', $usuario->foto) }}">
        </div>
        <!--Mensaje error-->
        @error('foto')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <!--Campo para cambiar la contraseña-->
        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <!--Mensaje error-->
        @error('password')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

            <!--Campo para cambiar la contraseña-->
            <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <!--Mensaje error-->
        @error('password')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <br>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
@endsection
