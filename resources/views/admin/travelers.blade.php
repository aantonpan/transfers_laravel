@extends('layouts.app')

@section('title', 'Gestión de Viajeros')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Viajeros</h1>
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
            @foreach($travelers as $traveler)
            <tr>
                <td>{{ $traveler->id }}</td>
                <td>{{ $traveler->name }}</td>
                <td>{{ $traveler->email }}</td>
                <td>
                    <button class="btn btn-warning" onclick="editTraveler({{ $traveler->id }}, '{{ $traveler->name }}', '{{ $traveler->email }}')">Editar</button>
                    <form action="{{ route('admin.travelers.delete', $traveler->id) }}" method="POST" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center gap-3">
        <!-- Botón para añadir nuevo hotel -->
            <a href="{{ url('register/admin') }}" class="btn btn-success ml-3">Añadir nuevo usuario</a>
    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Volver atrás</a>
     </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editTravelerModal" tabindex="-1" aria-labelledby="editTravelerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form id="editTravelerForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTravelerModalLabel">Editar Viajero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="traveler_name">Nombre:</label>
                    <input type="text" id="traveler_name" name="name" class="form-control" required>
                    <label for="traveler_email" class="mt-2">Email:</label>
                    <input type="email" id="traveler_email" name="email" class="form-control" required>
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
    function editTraveler(id, name, email) {
        const form = document.getElementById('editTravelerForm');
        form.action = "{{ route('admin.travelers.update', '') }}/" + id;
        document.getElementById('traveler_name').value = name;
        document.getElementById('traveler_email').value = email;
        new bootstrap.Modal(document.getElementById('editTravelerModal')).show();
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
