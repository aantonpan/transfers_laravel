@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="container">
    <h1>Registro</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>
@endsection
