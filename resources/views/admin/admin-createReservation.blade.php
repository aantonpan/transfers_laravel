@extends('layouts.app')

@section('title', 'Crear Reserva')

@section('content')
    <div class="container">
        <h1 class="mb-4">Crear Nueva Reserva</h1>

        <form action="{{ route('admin.createReservation.store') }}" method="POST">
            @csrf
            <!-- Tipo de Reserva -->
            <div class="mb-3">
                <label for="reservation_type" class="form-label">Tipo de Reserva</label>
                <select class="form-control" id="reservation_type" name="reservation_type" required
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
                <div class="mb-3">
                <label for="pickup_airport" class="form-label">Aeropuerto de recogida</label>
                <input type="text" class="form-control" id="pickup_airport" name="pickup_airport">
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
                <input type="number" class="form-control" id="travelers_count" name="travelers_count" min="1"
                    required>
            </div>

            <!-- Selección de Traveler -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Seleccionar Viajero</label>
                <select class="form-control" id="user_id" name="user_id" required
                    onchange="updateTravelerDetails()">
                    <option value="">Selecciona un viajero</option>
                    @foreach ($users as $user)
                        {{-- La variable $users contiene usuarios de la tabla users --}}
                        <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                            data-name="{{ $user->name }}">
                            {{ $user->name }}
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

            <button type="submit" class="btn btn-success w-100">Crear Reserva</button>
            <!-- Botón "Volver atrás" centrado -->
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ url('admin/bookings') }}" class="btn btn-secondary">Volver atrás</a>
            </div>
        </form>


    </div>
    @push('scripts')
        <script>
            function handleReservationType() {
                const reservationType = document.getElementById('reservation_type').value;

                // Ocultar todos los campos
                document.querySelectorAll('.reservation-fields').forEach(field => field.classList.add('d-none'));

                // Mostrar los campos correspondientes
                if (reservationType === 'aeropuerto_hotel') {
                    document.getElementById('aeropuerto_hotel_fields').classList.remove('d-none');
                } else if (reservationType === 'hotel_aeropuerto') {
                    document.getElementById('hotel_aeropuerto_fields').classList.remove('d-none');
                } else if (reservationType === 'ida_vuelta') {
                    document.getElementById('aeropuerto_hotel_fields').classList.remove('d-none');
                    document.getElementById('hotel_aeropuerto_fields').classList.remove('d-none');
                }
            }

            function updateTravelerDetails() {
                const travelerSelect = document.getElementById('traveler_id');
                const selectedOption = travelerSelect.options[travelerSelect.selectedIndex];
                const travelerDetails = document.getElementById('traveler_details');

                // Si hay un viajero seleccionado
                if (selectedOption.value) {
                    // Rellenar los detalles del viajero
                    document.getElementById('traveler_name').value = selectedOption.dataset.name || '';
                    document.getElementById('traveler_email').value = selectedOption.dataset.email || '';

                    // Mostrar el contenedor de detalles
                    travelerDetails.classList.remove('d-none');
                } else {
                    // Ocultar el contenedor de detalles y limpiar los valores
                    travelerDetails.classList.add('d-none');
                    document.getElementById('traveler_name').value = '';
                    document.getElementById('traveler_email').value = '';
                }
            }
        </script>
    @endpush
@endsection