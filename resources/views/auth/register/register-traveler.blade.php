@extends('layouts.app')

@section('title', 'Registro Viajero')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center mb-4">Registro de Viajero</h3>
        <form action="{{ route('traveler.register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nombre Completo</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>
    </div>
</div>
@endsection
