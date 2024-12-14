@extends('layouts.app')

@section('title', 'Gestión de Viajeros')

@section('styles')
    @vite('resources/css/traveler.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Lista de Viajeros</h1>
    <a href="{{ route('travelers.create') }}" class="btn btn-primary">Nuevo Viajero</a>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí van los datos dinámicos -->
        </tbody>
    </table>
</div>
@endsection
