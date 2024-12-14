@extends('layouts.app')

@section('title', 'Nueva Reserva')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Nueva Reserva</h1>
    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="client_name">Nombre del Cliente</label>
            <input type="text" id="client_name" name="client_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="destination">Destino</label>
            <input type="text" id="destination" name="destination" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
