@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Editar Reserva</h1>
    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="client_name">Nombre del Cliente</label>
            <input type="text" id="client_name" name="client_name" class="form-control" value="{{ $booking->client_name }}">
        </div>
        <div class="form-group">
            <label for="destination">Destino</label>
            <input type="text" id="destination" name="destination" class="form-control" value="{{ $booking->destination }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
