@extends('layouts.app')

@section('title', 'Editar Viajero')

@section('styles')
    @vite('resources/css/traveler.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Editar Viajero</h1>
    <form action="{{ route('travelers.update', $traveler->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $traveler->name }}">
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $traveler->email }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
