@extends('layouts.app')

@section('title', 'Gestión de Hoteles')

@section('styles')
    @vite('resources/css/hotel.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Lista de Hoteles</h1>
    <a href="{{ route('hotels.create') }}" class="btn btn-primary">Nuevo Hotel</a>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí van los datos dinámicos -->
        </tbody>
    </table>
</div>
@endsection
