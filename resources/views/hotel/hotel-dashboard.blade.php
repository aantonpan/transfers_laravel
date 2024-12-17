@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
    <!-- Contenedor Flex para el botón y el H1 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reservas en hoteles del usuario: {{ Auth::user()->name }}</h1>
        <a href="{{ url('hotel/reservations') }}" class="btn btn-primary">Listado de reservas</a>
    </div>

    <!-- Encabezado H3 -->
    <h3>Reservas Asociadas</h3>

    <!-- Tabla de Hoteles -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Hotel</th>
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
                <td colspan="4" class="text-center">No hay reservas asociadas a tu hotel.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection