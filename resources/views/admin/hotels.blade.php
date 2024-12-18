@extends('layouts.app')

@section('title', 'Gestión de Hoteles')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Hoteles</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hotel</th>
                <th>Ubicación</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            @foreach($hotels as $user)
                @foreach($user->hotels as $hotel) <!-- Iterar sobre los hoteles del usuario -->
                <tr>
                    <td>{{ $hotel->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ $hotel->location}}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editHotel({{ $hotel->id }}, '{{ $hotel->name }}', '{{ $hotel->location }}')">Editar</button>
                        <form action="{{ route('hotel.hotels.delete', $hotel) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center gap-3">
      <a href="{{ url('hotel/dashboard') }}" class="btn btn-secondary">Volver atrás</a>
     </div>
     
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editHotelForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHotelModalLabel">Editar Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="hotel_name">Nombre:</label>
                    <input type="text" id="hotel_name" name="name" class="form-control" required>
                    <label for="hotel_ubicacion">Ubicación:</label>
                    <input type="text" id="hotel_ubicacion" name="ubicacion" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editHotel(id, name, ubicacion) {
        const form = document.getElementById('editHotelForm');
        form.action = `/hotel/hotels/${id}`;
        document.getElementById('hotel_name').value = name;
        document.getElementById('hotel_ubicacion').value = ubicacion;
        new bootstrap.Modal(document.getElementById('editHotelModal')).show();
    }

    function confirmDelete(button) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>
@endpush
@endsection
