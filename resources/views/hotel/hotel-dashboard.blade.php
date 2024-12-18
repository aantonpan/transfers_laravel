@extends('layouts.app')

@section('title', 'Dashboard Hotel')

@section('content')
<div class="container">
     <!-- Contenedor Flex para el botón y el H1 -->
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de hoteles del usuario: {{ Auth::user()->name }}</h1>
        <div>
            <a href="{{ url('hotel/reservations') }}" class="btn btn-primary">Listado de reservas</a>
            <!-- Botón para añadir nuevo hotel -->
            <a href="{{ url('hotel/createHotel') }}" class="btn btn-success ml-3">Añadir nuevo hotel</a>
        </div>
    </div>

    <!-- Encabezado H3 -->
    <h3>Hoteles asociados</h3>

    <!-- Tabla de Hoteles -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID del hotel</th>
                <th>Nombre del hotel</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hotels as $hotel)
            <tr>
                <td>{{ $hotel->id }}</td>
                <td>{{ $hotel->name }}</td>
                <td>{{ $hotel->location }}</td>
                <td>
                        <button class="btn btn-warning" onclick="editHotel({{ $hotel->id }}, '{{ $hotel->name }}', '{{ $hotel->location }}')">Editar</button>
                        <form action="{{ route('hotel.hotels.delete', $hotel->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Eliminar</button>
                        </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No hay ningún hotel asociado asociado a {{ Auth::user()->name }}.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
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
                    <input type="text" id="hotel_ubicacion" name="location" class="form-control" required>
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
