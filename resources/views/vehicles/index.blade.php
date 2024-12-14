@extends('layouts.app')

@section('title', 'Gestión de Vehículos')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Lista de Vehículos</h1>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Nuevo Vehículo</a>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí van los datos dinámicos -->
        </tbody>
    </table>
</div>
@endsection
