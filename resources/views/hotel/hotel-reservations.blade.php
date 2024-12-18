@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
    <!-- Contenedor Flex para el botón y el H1 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de reservas del usuario: {{ Auth::user()->name }}</h1>
        <div>
            <a href="{{ url('hotel/dashboard') }}" class="btn btn-primary">Listado de hoteles</a>
            <!-- Botón para añadir nuevo hotel -->
            <a href="{{ url('hotel/reservations/createReservation') }}" class="btn btn-success ml-3">Añadir nueva reserva</a>
        </div>

    </div>
    

    <div class="mb-4">
    <form action="{{ url('hotel/reservations') }}" method="GET" class="form-inline" id="hotelFilterForm">
        <label for="hotel_id" class="mr-2">Hoteles</label>
        <select name="hotel_id" id="hotel_id" class="form-control" onchange="document.getElementById('hotelFilterForm').submit()">
            <option value="">Todos los hoteles</option>
            @foreach ($hotels as $hotel)
                <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                    {{ $hotel->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>
<h3>Reservas Asociadas</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>tipo de reserva</th>
                <th>Nombre del Hotel</th>
                <th>Fecha de la Reserva</th>
                <th>Nº de Viajeros</th>
                <th>Datos del viajero</th>
                <th>Ganancia por reserva</th>
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
                        {{ date('d-m-Y', strtotime($reservation->arrival_date))}} - {{date('d-m-Y', strtotime($reservation->flight_day)) }}
                        @endif
                    </td>
                    <td>{{ $reservation->travelers_count }}</td>
                    <td>{{ $reservation->traveler->user->name }} - {{ $reservation->traveler->user->email }}</td>
                    <td>{{ number_format($reservation->price_hotel, 2) }} €</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No tienes reservas asociadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
