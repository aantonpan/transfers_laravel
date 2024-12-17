@extends('layouts.app')

@section('title', 'Registro Hotel')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center mb-4">Registro</h3>
        <form action="{{ route('traveler.register') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label fw-bold">Nombre de usuario</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de usuario" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label fw-bold">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label fw-bold">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-bold">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required>
    </div>

    <!-- Selección de Rol -->
    <div class="mb-3">
        <label for="role" class="form-label fw-bold">Selecciona tu Rol</label>
        <select name="role" id="role" class="form-control" required>
            <option value="hotel">Hotel</option>
            <option value="traveler"selected>Viajero</option>
            <option value="admin">Administrador</option>
        </select>
        </div>
    <button type="submit" class="btn btn-success w-100">Registrarse</button>
</form>
    </div>
</div>
@endsection
