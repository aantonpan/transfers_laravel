@extends('layouts.app')

@section('title', 'Gestión de Reservas')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Reservas</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hotel</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->traveler->user->name }}</td>
                <td>{{ $booking->hotel->name }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>
                    <button class="btn btn-warning" onclick="editBooking({{ $booking->id }}, '{{ $booking->traveler_id }}', '{{ $booking->hotel_id }}', '{{ $booking->booking_date }}')">Editar</button>
                    <form action="{{ route('admin.bookings.delete', $booking) }}" method="POST" style="display:inline;" class="delete-form">
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
            <a href="{{ url('admin/bookings/createReservation') }}" class="btn btn-success ml-3">Añadir nueva reserva</a>
    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Volver atrás</a>
     </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editBookingForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookingModalLabel">Editar Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="traveler_id">ID Viajero:</label>
                    <input type="number" id="traveler_id" name="traveler_id" class="form-control" required>
                    <label for="hotel_id" class="mt-2">ID Hotel:</label>
                    <input type="number" id="hotel_id" name="hotel_id" class="form-control" required>
                    <label for="booking_date" class="mt-2">Fecha:</label>
                    <input type="date" id="booking_date" name="booking_date" class="form-control" required>
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
    function editBooking(id, travelerId, hotelId, bookingDate) {
        const form = document.getElementById('editBookingForm');
        form.action = `/admin/bookings/${id}`;
        document.getElementById('traveler_id').value = travelerId;
        document.getElementById('hotel_id').value = hotelId;
        document.getElementById('booking_date').value = bookingDate;
        new bootstrap.Modal(document.getElementById('editBookingModal')).show();
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
