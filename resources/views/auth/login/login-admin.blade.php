@extends('layouts.app')

@section('title', 'Login Administrador')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
    <div class="row shadow-lg rounded-3 overflow-hidden" style="max-width: 1200px;">
        <!-- Imagen -->
        <div class="col-md-6 p-0">
            <img src="{{ asset('images/logo-blanc.png') }}" alt="Administrador Login" class="img-fluid w-100" style="object-fit: cover; height: 100%;">
        </div>
        <!-- Formulario -->
        <div class="col-md-6 p-5 d-flex align-items-center justify-content-center bg-white">
            <div class="w-100">
                <h3 class="text-center fw-bold mb-4 text-primary">Accede como Administrador</h3>
                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf
                    <!-- ID del administrador -->
                    <div class="mb-3">
                        <label for="admin_id" class="form-label fw-bold">ID</label>
                        <input type="text" class="form-control" id="admin_id" name="admin_id" placeholder="Introduce el ID de administrador" required>
                    </div>
                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Clave</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu clave" required>
                    </div>
                    <!-- Botón de acceso -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold text-uppercase">Acceder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
