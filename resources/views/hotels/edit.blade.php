@extends('layouts.app')

@section('title', 'Editar Hotel')

@section('styles')
    @vite('resources/css/hotel.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Editar Hotel</h1>
    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre del Hotel</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $hotel->name }}">
        </div>
        <div class="form-group">
            <label for="location">Ubicación</label>
            <input type="text" id="location" name="location" class="form-control" value="{{ $hotel->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
