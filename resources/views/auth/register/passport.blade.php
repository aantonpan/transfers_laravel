@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ingresa tu Número de Pasaporte</h2>

        <form action="{{ route('traveler.passport.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="passport_number" class="form-label fw-bold">Número de Pasaporte</label>
                <input type="text" class="form-control" id="passport_number" name="passport_number" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Guardar Pasaporte</button>
        </form>
    </div>
@endsection