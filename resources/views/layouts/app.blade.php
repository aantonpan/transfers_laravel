<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Isla Transfers')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@400..800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Vite CSS y JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <div class="container-fluid">
            <!-- Logo e imagen -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Isla Transfers" class="me-2" style="height: 50px;">
                <span class="fs-4 fw-bold" style="font-family: 'Baloo Paaji 2', cursive;">Isla Transfer</span>
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link fw-bold text-success">
                                @if (Auth::user()->role === 'admin')
                                    Administrador
                                @elseif (Auth::user()->role === 'hotel')
                                    Hotel
                                @elseif (Auth::user()->role === 'traveler')
                                    Viajero
                                @endif
                            </span>
                        </li>
                        <li class="nav-item">
                        <form method="post" action="/logout">
                            @csrf
                            <button class="nav-link text-danger fw-bold">Cerrar sesión</button>
                        </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="py-4">
        @yield('content')
    </main>


    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <div class="container-fluid">
            <p>&copy; 2024 PHP POWER</p>
        </div>
    </footer>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
