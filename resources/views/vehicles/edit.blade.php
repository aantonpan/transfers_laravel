@extends('layouts.app')

@section('title', 'Editar Vehículo')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Editar Vehículo</h1>
    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" id="brand" name="brand" class="form-control" value="{{ $vehicle->brand }}">
        </div>
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" id="model" name="model" class="form-control" value="{{ $vehicle->model }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
