@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard del Hotel: {{ Auth::user()->name }}</h1>
    <h3>Reservas Asociadas</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Nombre del Viajero</th>
                <th>Email del Viajero</th>
                <th>Fecha de la Reserva</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->traveler->name }}</td>
                <td>{{ $reservation->traveler->email }}</td>
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
