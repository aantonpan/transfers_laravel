<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión Transfers')</title>
    <!-- Incluye el CSS procesado por Vite -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Navegación -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex justify-between items-center py-6">
                <a href="/" class="text-xl font-bold text-blue-600">Gestión Transfers</a>
                <div>
                    <a href="/login" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
                    <a href="/register" class="ml-4 text-sm text-gray-700 hover:text-gray-900">Registro</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-sm text-gray-500">&copy; 2024 Gestión Transfers</p>
        </div>
    </footer>
</body>
</html>
