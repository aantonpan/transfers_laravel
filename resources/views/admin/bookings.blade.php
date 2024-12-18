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
                    <th>Ganancia del hotel (€)</th> <!-- Nueva columna para el precio del hotel -->
                    <th>Pago del viajero (€)</th> <!-- Nueva columna para el precio del viajero -->
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
                        <!-- Mostrar el precio total del hotel -->
                        <td>{{ number_format($booking->price_hotel, 2) }} €</td> 

                        <!-- Mostrar el precio total del viajero -->
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
        <div class="d-flex justify-content-center gap-3">
            <!-- Botón para añadir nueva reserva -->
            <a href="{{ url('admin/bookings/createReservation') }}" class="btn btn-success ml-3">Añadir nueva reserva</a>
            <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Volver atrás</a>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content p-5" action="{{ route('admin.updateBooking', '') }}" id="editBookingForm" method="POST">
                @csrf
                @method('PUT')
                <!-- Tipo de Reserva -->
                <div class="mb-3">
                    <label for="reservation_type" class="form-label">Tipo de Reserva</label>
                    <select disabled class="form-control" id="reservation_type" name="reservation_type" required
                        onchange="handleReservationType()">
                        <option value="">Selecciona el tipo de reserva</option>
                        <option value="aeropuerto_hotel">Aeropuerto -> Hotel</option>
                        <option value="hotel_aeropuerto">Hotel -> Aeropuerto</option>
                        <option value="ida_vuelta">Ida y Vuelta</option>
                    </select>
                </div>

                <!-- Campos para Aeropuerto -> Hotel -->
                <div id="aeropuerto_hotel_fields" class="reservation-fields d-none">
                    <h5 class="mb-3">Datos: Aeropuerto → Hotel</h5>
                    <div class="mb-3">
                        <label for="arrival_date" class="form-label">Día de Llegada</label>
                        <input type="date" class="form-control" id="arrival_date" name="arrival_date">
                    </div>
                    <div class="mb-3">
                        <label for="arrival_time" class="form-label">Hora de Llegada</label>
                        <input type="time" class="form-control" id="arrival_time" name="arrival_time">
                    </div>
                    <div class="mb-3">
                        <label for="flight_number" class="form-label">Número de Vuelo</label>
                        <input type="text" class="form-control" id="flight_number" name="flight_number">
                    </div>
                    <div class="mb-3">
                        <label for="origin_airport" class="form-label">Aeropuerto de Origen</label>
                        <input type="text" class="form-control" id="origin_airport" name="origin_airport">
                    </div>
                </div>

                <!-- Campos para Hotel -> Aeropuerto -->
                <div id="hotel_aeropuerto_fields" class="reservation-fields d-none">
                    <h5 class="mb-3">Datos: Hotel → Aeropuerto</h5>
                    <div class="mb-3">
                        <label for="flight_day" class="form-label">Día del Vuelo</label>
                        <input type="date" class="form-control" id="flight_day" name="flight_day">
                    </div>
                    <div class="mb-3">
                        <label for="flight_time" class="form-label">Hora del Vuelo</label>
                        <input type="time" class="form-control" id="flight_time" name="flight_time">
                    </div>
                    <div class="mb-3">
                        <label for="pickup_time" class="form-label">Hora de Recogida</label>
                        <input type="time" class="form-control" id="pickup_time" name="pickup_time">
                    </div>
                    <div class="mb-3">
                        <label for="flight_number_return" class="form-label">Número de Vuelo</label>
                        <input type="text" class="form-control" id="flight_number_return" name="flight_number_return">
                    </div>
                </div>

                <!-- Hotel de Destino/Recogida -->
                <div class="mb-3">
                    <label for="hotel_id" class="form-label">Hotel de Destino/Recogida</label>
                    <select class="form-control" id="hotel_id" name="hotel_id" required>
                        <option value="">Selecciona un hotel</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Número de Viajeros -->
                <div class="mb-3">
                    <label for="travelers_count" class="form-label">Número de Viajeros</label>
                    <input type="number" class="form-control" id="travelers_count" name="travelers_count"
                        min="1" required>
                </div>

                <!-- Selección de Traveler -->
                <div class="mb-3">
                    <label for="traveler_id" class="form-label">Seleccionar Viajero</label>
                    <select class="form-control" id="traveler_id" name="traveler_id" required
                        onchange="updateTravelerDetails()">
                        <option value="">Selecciona un viajero</option>
                        @foreach ($travelers as $traveler)
                            {{-- La variable $travelers contiene usuarios de la tabla travelers --}}
                            <option value="{{ $traveler->id }}" data-email="{{ $traveler->user->email }}"

                                data-name="{{ $traveler->user->name }}">
                                {{ $traveler->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Contenedor oculto para los detalles del traveler -->
                <div id="traveler_details" class="d-none">
                    <!-- Detalles del Traveler -->
                    <div class="mb-3">
                        <label for="traveler_name" class="form-label">Nombre del Viajero</label>
                        <input type="text" class="form-control" id="traveler_name" name="traveler_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="traveler_email" class="form-label">Correo Electrónico del Viajero</label>
                        <input type="email" class="form-control" id="traveler_email" name="traveler_email" readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Editar Reserva</button>
                <!-- Botón "Volver atrás" centrado -->
                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ url('admin/bookings') }}" class="btn btn-secondary">Volver atrás</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function editBooking(booking) {
                const form = document.getElementById('editBookingForm');
                form.action = "{{ route('admin.updateBooking', '') }}/" + booking.id;

                new bootstrap.Modal(document.getElementById('editBookingModal')).show();

                document.getElementById('traveler_id').value = booking.traveler.id;
                document.getElementById('hotel_id').value = booking.hotel_id;
                document.getElementById('travelers_count').value = booking.travelers_count || '';
                document.getElementById('reservation_type').value = booking.reservation_type;
                handleReservationType();

                // Aeropuerto -> Hotel
                document.getElementById('arrival_date').value = booking.arrival_date;
                document.getElementById('arrival_time').value = booking.arrival_time;
                document.getElementById('flight_number').value = booking.flight_number;
                document.getElementById('origin_airport').value = booking.origin_airport;

                // Hotel -> Aeropuerto
                document.getElementById('flight_number_return').value = booking.flight_number_return;
                document.getElementById('flight_day').value = booking.flight_day;
                document.getElementById('flight_time').value = booking.flight_time;
                document.getElementById('pickup_time').value = booking.pickup_time;
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