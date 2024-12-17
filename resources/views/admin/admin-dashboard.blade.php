@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Control del Administrador</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('admin.hotels') }}" class="btn btn-primary w-100 py-3">Gestión de Hoteles</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.travelers') }}" class="btn btn-success w-100 py-3">Gestión de Viajeros</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.bookings') }}" class="btn btn-warning w-100 py-3">Gestión de Reservas</a>
        </div>
    </div>
</div>
@endsection
