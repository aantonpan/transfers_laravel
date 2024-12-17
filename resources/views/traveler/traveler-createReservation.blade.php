@extends('layouts.app')

@section('title', 'Crear Reserva')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Nueva Reserva</h1>

    <form action="{{ route('traveler.reservation.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hotel_id" class="form-label">Selecciona un Hotel</label>
            <select class="form-control" id="hotel_id" name="hotel_id" required>
                <option value="">Selecciona un hotel</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Fecha de la Reserva</label>
            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Crear Reserva</button>
    </form>
</div>
@endsection