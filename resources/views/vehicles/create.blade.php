@extends('layouts.app')

@section('title', 'Nuevo Vehículo')

@section('styles')
    @vite('resources/css/general.css')
@endsection

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Nuevo Vehículo</h1>
    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" id="brand" name="brand" class="form-control">
        </div>
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" id="model" name="model" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
