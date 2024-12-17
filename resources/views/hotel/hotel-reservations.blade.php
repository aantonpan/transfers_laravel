@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
    <!-- Contenedor Flex para el botón y el H1 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Hoteles del usuario: {{ Auth::user()->name }}</h1>
        <a href="{{ url('hotel/dashboard') }}" class="btn btn-primary">Listado de hoteles</a>
    </div>
    <h3>Reservas Asociadas</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Hotel</th>
                <th>Nombre del Viajero</th>
                <th>Email del Viajero</th>
                <th>Fecha de la Reserva</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->hotel->name }}</td>
                <td>{{ $reservation->traveler->user->name }}</td>
                <td>{{ $reservation->traveler->user->email }}</td>
                <td>{{ $reservation->booking_date }}</td>
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
