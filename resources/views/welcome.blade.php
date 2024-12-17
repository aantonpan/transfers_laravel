@extends('layouts.app')

@section('title', 'Bienvenido a Isla Transfers')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 text-center">
    <div>
        <h1 class="display-4 fw-bold mb-4">Reserva tu trayecto con <span class="text-primary">Isla Transfers</span></h1>
        <p class="lead mb-5">La mejor solución para conectar viajeros y hoteles. ¡Fácil, rápido y confiable!</p>
        <img src="{{ asset('images/logo.png') }}" alt="Landing Image" class="img-fluid mb-4" style="max-height: 300px;">

        <!-- Botones -->
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('login.hotel') }}" class="btn btn-success btn-sm px-3 py-2">
                Soy Hotel
            </a>
            <a href="{{ route('login.traveler') }}" class="btn btn-success btn-sm px-3 py-2">
                Soy Viajero
            </a>
        </div>
    </div>
</div>

@endsection
