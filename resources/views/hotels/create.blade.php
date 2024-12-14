@extends('layouts.app')

@section('title', 'Nuevo Hotel')

@section('styles')
    @vite('resources/css/hotel.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Nuevo Hotel</h1>
    <form action="{{ route('hotels.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre del Hotel</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="location">Ubicación</label>
            <input type="text" id="location" name="location" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
