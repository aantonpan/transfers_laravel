@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container">
    <h1>Mi Perfil de administrador</h1>

    <form action="{{ route('admin.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>
        <!-- Correo Electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>
        

        

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </form>

    <!-- Botón para cambiar la contraseña -->
    <button id="changePasswordButton" class="btn btn-warning mt-4">Cambiar Contraseña</button>

    <!-- Formulario para cambiar la contraseña (inicialmente oculto) -->
    <form id="changePasswordForm" action="{{ route('admin.updatePassword') }}" method="POST" class="mt-4" style="display: none;">
        @csrf
        @method('PUT')

        <!-- Contraseña Actual -->
    <div class="mb-3">
        <label for="current_password" class="form-label">Contraseña Actual</label>
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
        
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

        <!-- Nueva Contraseña -->
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva Contraseña</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <!-- Confirmar Nueva Contraseña -->
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <!-- Botón para cambiar la contraseña -->
        <button type="submit" class="btn btn-success">Actualizar Contraseña</button>
    </form>
</div>

@push('scripts')
<script>
    @if($errors->any())
    const form2 = document.getElementById('changePasswordForm');
    form2.style.display = 'block';
    @endif
// Mostrar y ocultar el formulario de cambiar la contraseña
    document.getElementById('changePasswordButton').addEventListener('click', function() {
        const form = document.getElementById('changePasswordForm');

        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>
@endpush
<!-- Mostrar el mensaje de éxito -->
@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection
