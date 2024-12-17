@extends('layouts.app')

@section('title', 'Login Hoteles')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
    <div class="row shadow-lg rounded-3 overflow-hidden" style="max-width: 1200px;">
        <!-- Imagen -->
        <div class="col-md-6 p-0">
            <img src="{{ asset('images/login-hotel.jpg') }}" alt="Hotel Login" class="img-fluid w-100" style="object-fit: cover; height: 100%;">
        </div>
        <!-- Formulario -->
        <div class="col-md-6 p-5 d-flex align-items-center justify-content-center bg-white">
            <div class="w-100">
                <h3 class="text-center fw-bold mb-4 text-success">Tu hotel en Isla Transfers</h3>
                <form action="{{ route('hotel.login.post') }}" method="POST">
                    @csrf
                    <!-- Usuario -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Usuario</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Introduce tu usuario" required>
                    </div>
                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                    </div>
                    <!-- Botones -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold text-uppercase">Acceder</button>
                        <a href="{{ route('register.hotel') }}" class="btn btn-custom fw-bold text-uppercase">Formulario de Inscripción</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
