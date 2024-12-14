@extends('layouts.app')

@section('title', 'Gestión de Reservas')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Lista de Reservas</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary">Nueva Reserva</a>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Destino</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí van los datos dinámicos -->
        </tbody>
    </table>
</div>
@endsection
