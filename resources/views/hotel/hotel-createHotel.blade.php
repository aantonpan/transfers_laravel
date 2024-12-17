<!-- resources/views/hotel/create.blade.php -->
@extends('layouts.app')

@section('title', 'Añadir Nuevo Hotel')

@section('content')
<div class="container">
    <h1>Añadir Nuevo Hotel</h1>

    <!-- Formulario para añadir un nuevo hotel -->
    <form action="{{ url('hotel/createHotel') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Hotel</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del hotel" required>
        </div>
        
        <div class="mb-3">
            <label for="location" class="form-label">Ubicación del Hotel</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Ubicación" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Hotel</button>
    </form>
    <a href="{{ url('hotel/dashboard') }}" class="btn btn-secondary mt-3">Volver atrás</a>
    
</div>
@endsection