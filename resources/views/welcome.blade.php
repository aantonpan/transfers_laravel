@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
    <h1>Bienvenido a Gestión Transfers</h1>
    <p>Gestiona tus reservas, vehículos, y más de forma sencilla.</p>
    <a href="{{ route('login') }}">Iniciar Sesión</a>
    <a href="{{ route('register') }}">Registrarse</a>
@endsection
