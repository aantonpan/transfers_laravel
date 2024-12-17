@extends('layouts.app')

@section('title', 'Gestión de Hoteles')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Hoteles</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hotels as $hotel)
            <tr>
                <td>{{ $hotel->id }}</td>
                <td>{{ $hotel->name }}</td>
                <td>{{ $hotel->email }}</td>
                <td>
                    <button class="btn btn-warning" onclick="editHotel({{ $hotel->id }}, '{{ $hotel->name }}', '{{ $hotel->email }}')">Editar</button>
                    <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
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
                    <label for="hotel_email" class="mt-2">Email:</label>
                    <input type="email" id="hotel_email" name="email" class="form-control" required>
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
    function editHotel(id, name, email) {
        const form = document.getElementById('editHotelForm');
        form.action = `/admin/hotels/${id}`;
        document.getElementById('hotel_name').value = name;
        document.getElementById('hotel_email').value = email;
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
