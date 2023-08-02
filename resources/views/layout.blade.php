<!-- layout.blade -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tauler de jocs</title>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/estils.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">Tauler de jocs</a>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>

                    <!-- Mostrar el menú de acuerdo al estado de autenticación del usuario -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registro') }}">Registro</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <span class="nav-link">{{ Auth::user()->nombre }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <a class="nav-link" onclick="this.closest('form').submit()" href="#">Logout</a>
                        </form>
                    </li>
                    @endguest
                </ul>

                <!-- Campo de búsqueda -->
                <form class="d-flex" action="{{ route('consultajuegos') }}" method="get">
                    <input class="form-control me-2" type="search" placeholder="Buscar Juego" aria-label="Search" id="filtro" name="filtro" value="{{ $filtro ?? null}}">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        @yield('contenido')

    </div>

    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>