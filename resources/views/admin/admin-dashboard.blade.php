@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Control del Administrador</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('admin.hotels') }}" class="btn btn-primary w-100 py-3">Gestión de Hoteles</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.travelers') }}" class="btn btn-success w-100 py-3">Gestión de Viajeros</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.bookings') }}" class="btn btn-warning w-100 py-3">Gestión de Reservas</a>
        </div>
    </div>
    <div class="pt-5" id='calendar'></div>
</div>
<!-- Modal -->
<div class="modal fade" id="journeyModal" tabindex="-1" aria-labelledby="journeyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="journeyModalLabel">Detalles del trayecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="journeyDetails">
          <!-- Los detalles del journey se cargarán aquí -->
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
    // console.log(@json($journeys))

    function mapObjects(array) {
        return array.map(item => ({
            id: item.id,
            title: `Journey ${item.type} from ${item.origin} to ${item.destination}`,
            start: new Date(`${item.date}T${item.time}`), // Combina fecha y hora y lo convierte en objeto Date
            booking_id: item.booking_id,
            type: item.type,
            date: item.date,
            time: item.time,
            origin: item.origin,
            destination: item.destination,
            travelers_count: item.travelers_count,
            traveler_mail: item.traveler_mail
        }));
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC',
            initialView: 'dayGridMonth',
            aspectRatio: 1.5,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: "dayGridMonth,timeGridWeek,timeGridDay"
            },
            events: mapObjects(@json($journeys)),
            eventClick: function(info) {

                console.log(info)
                // Obtener los detalles del evento
                var journey = info.event.extendedProps;
                
                 // Usar la fecha de FullCalendar para obtener la fecha y hora correctas
                 var eventStart = info.event.start; // Obtener el objeto Date de FullCalendar

                // Formatear la fecha y la hora
                var formattedDate = eventStart.toLocaleDateString('es-ES'); // Formato de fecha en español
                var formattedTime = eventStart.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }); // Formato de hora

                // Mostrar los detalles en el modal
                var journeyDetails = `
                    <p><strong>ID del trayecto:</strong> ${journey.booking_id}</p>
                    <p><strong>Tipo de trayecto:</strong> ${journey.type}</p>
                    <p><strong>Fecha:</strong> ${formattedDate}</p>
                    <p><strong>Hora:</strong> ${formattedTime}</p>
                    <p><strong>Origen:</strong> ${journey.origin}</p>
                    <p><strong>Destino:</strong> ${journey.destination}</p>
                    <p><strong>Número de viajeros:</strong> ${journey.travelers_count}</p>
                    <p><strong>Email de contacto del viajero:</strong> ${journey.traveler_mail}</p>
                `;

                // Insertar los detalles en el modal
                document.getElementById('journeyDetails').innerHTML = journeyDetails;

                // Mostrar el modal
                var modal = new bootstrap.Modal(document.getElementById('journeyModal'));
                modal.show();
            }
        });

        calendar.render();
    });
</script>
@endpush

@endsection

