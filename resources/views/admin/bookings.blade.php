@extends('layouts.app')

@section('title', 'Gestión de Reservas')

@section('content')
    <div class="container mb-5">
        <div class="mb-4">
            <form action="{{ url('admin/bookings') }}" method="GET" class="form-inline" id="hotelFilterForm">
                <label for="hotel_id" class="mr-2">Hoteles</label>
                <select name="hotel_id" id="hotel_id" class="form-control" onchange="document.getElementById('hotelFilterForm').submit()">
                    <option value="">Todos los hoteles</option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <h1 class="mb-4">Lista de Reservas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo de reserva</th>
                    <th>Nombre del hotel</th>
                    <th>Fecha de la reserva</th>
                    <th>Ganancia del hotel (€)</th>
                    <th>Pago del viajero (€)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->traveler->user->name }}</td>
                        <td>{{ $booking->reservation_type }}</td>
                        <td>{{ $booking->hotel->name }}</td>
                        <td>
                            @if($booking->reservation_type == 'aeropuerto_hotel')
                                {{ date('d-m-Y', strtotime($booking->arrival_date)) }}
                            @endif
                            @if($booking->reservation_type == 'hotel_aeropuerto')
                                {{ date('d-m-Y', strtotime($booking->flight_day)) }}
                            @endif
                            @if($booking->reservation_type == 'ida_vuelta')
                                {{ date('d-m-Y', strtotime($booking->arrival_date))}} - {{date('d-m-Y', strtotime($booking->flight_day)) }}
                            @endif
                        </td>
                        <td>{{ number_format($booking->price_hotel, 2) }} €</td> 
                        <td>{{ number_format($booking->price_total, 2) }} €</td> 
                        <td>
                            <button class="btn btn-warning" onclick="editBooking(@json($booking))">
                                Editar
                            </button>
                            <form action="{{ route('admin.bookings.delete', $booking) }}" method="POST"
                                style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(request('hotel_id'))
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#totalPriceModal">
                Ver Suma Total de Reservas de Este Mes
            </button>
        @endif

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('admin/bookings/createReservation') }}" class="btn btn-success ml-3">Añadir nueva reserva</a>
            <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Volver atrás</a>
        </div>
    </div>

    <!-- Modal Total Price -->
    <div class="modal fade" id="totalPriceModal" tabindex="-1" aria-labelledby="totalPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-5">
            <h5 class="modal-title" id="totalPriceModalLabel" style="font-size: 2em; text-decoration: underline; text-align: center;">
            <strong>Ganancia</strong>
            </h5>
            <p class="text-center">Total acumulado de las reservas del <strong>{{ $hotelName }}</strong> :</p>
            <p class="text-center" style="font-size: 2.5em; font-weight: bold;">{{ number_format($totalPrice, 2) }} €</p>     
            <div class="d-flex justify-content-center mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editBooking(booking) {
                const form = document.getElementById('editBookingForm');
                form.action = "{{ route('admin.updateBooking', '') }}/" + booking.id;

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