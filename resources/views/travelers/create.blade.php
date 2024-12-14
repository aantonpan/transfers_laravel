@extends('layouts.app')

@section('title', 'Nuevo Viajero')

@section('styles')
    @vite('resources/css/traveler.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Nuevo Viajero</h1>
    <form action="{{ route('travelers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
