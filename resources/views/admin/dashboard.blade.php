@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('styles')
    @vite('resources/css/admin.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Panel de Administración</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('hotels.index') }}" class="dashboard-card">
            <h2>Gestión de Hoteles</h2>
            <p>Ver y administrar todos los hoteles registrados.</p>
        </a>
        <a href="{{ route('vehicles.index') }}" class="dashboard-card">
            <h2>Gestión de Vehículos</h2>
            <p>Gestiona los vehículos disponibles para los traslados.</p>
        </a>
        <a href="{{ route('travelers.index') }}" class="dashboard-card">
            <h2>Gestión de Viajeros</h2>
            <p>Administra todos los viajeros registrados en el sistema.</p>
        </a>
        <a href="{{ route('bookings.index') }}" class="dashboard-card">
            <h2>Gestión de Reservas</h2>
            <p>Controla las reservas realizadas por los usuarios.</p>
        </a>
    </div>
</div>
@endsection
