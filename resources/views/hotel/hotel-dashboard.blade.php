@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
     <!-- Contenedor Flex para el botón y el H1 -->
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de hoteles del usuario: {{ Auth::user()->name }}</h1>
        <div>
            <a href="{{ url('hotel/reservations') }}" class="btn btn-primary">Listado de reservas</a>
            <!-- Botón para añadir nuevo hotel -->
            <a href="{{ url('hotel/createHotel') }}" class="btn btn-success ml-3">Añadir nuevo hotel</a>
        </div>
    </div>

    <!-- Encabezado H3 -->
    <h3>Hoteles asociados</h3>

    <!-- Tabla de Hoteles -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID del hotel</th>
                <th>Nombre del hotel</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hotels as $hotel)
            <tr>
                <td>{{ $hotel->id }}</td>
                <td>{{ $hotel->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No hay ningún hotel asociado asociado a {{ Auth::user()->name }}.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection