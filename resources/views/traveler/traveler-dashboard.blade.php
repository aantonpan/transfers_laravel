@extends('layouts.app')

@section('title', 'Dashboard Viajero')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard del Viajero: {{ Auth::user()->name }}</h1>
    <h3>Mis Reservas</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Nombre del Hotel</th>
                <th>Email del Hotel</th>
                <th>Fecha de la Reserva</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->hotel->name }}</td>
                <td>{{ $reservation->hotel->location }}</td>
                <td>{{ $reservation->booking_date }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No tienes reservas asociadas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
