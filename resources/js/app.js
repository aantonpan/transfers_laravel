import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import Swal from 'sweetalert2';
import '../css/app.css'; // Archivo CSS principal



// Exportar SweetAlert globalmente
window.Swal = Swal;

// Función para rellenar el modal con datos dinámicos
window.populateHotelModal = function (id, name, email) {
    document.getElementById('editHotelForm').action = `/hotels/${id}`;
    document.getElementById('hotel_name').value = name;
    document.getElementById('hotel_email').value = email;
};


console.log('Hola desde app.js');
