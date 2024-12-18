@extends('layouts.app')

@section('title', 'Dashboard Viajero')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard del Viajero: {{ Auth::user()->name }}</h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Mis Reservas</h3>
        <a href="{{ url('traveler/reservation') }}" class="btn btn-primary">Crear nueva reserva</a>
    </div>

    <!-- Mostrar el mensaje de éxito -->
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Tipo de Reserva</th>
                <th>Nombre del Hotel</th>
                <th>Fecha de la Reserva</th>
                <th>Cantidad de Viajeros</th>
                <th>Precio de la reserva (€)</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->reservation_type }}</td>
                    <td>{{ $reservation->hotel->name }}</td>
                    <td>
                        @if($reservation->reservation_type == 'aeropuerto_hotel')
                            {{ date('d-m-Y', strtotime($reservation->arrival_date)) }}
                        @endif
                        @if($reservation->reservation_type == 'hotel_aeropuerto')
                            {{ date('d-m-Y', strtotime($reservation->flight_day)) }}
                        @endif
                        @if($reservation->reservation_type == 'ida_vuelta')
                            {{ date('d-m-Y', strtotime($reservation->arrival_date)) }} - {{ date('d-m-Y', strtotime($reservation->flight_day)) }}
                        @endif
                    </td>
                    <td>{{ $reservation->travelers_count }}</td>
                    <td>{{ number_format($reservation->price_total, 2) }} €</td> <!-- Precio Total -->
                    <td>
                            <button class="btn btn-warning" onclick="editBooking())">
                                Editar
                            </button>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No tienes reservas asociadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection