// frontend/js/main.js
//Punto de entrada principal, inicialización y gestión de eventos
import { registerUser, loginUser, logoutUser, checkLoginStatusOnLoad } from './auth.js';
import { searchSchedules } from './schedules.js';
import { bookTicket, viewMyTickets, cancelTicket } from './tickets.js';
import { displayMessage } from './ui.js'; // Solo si necesitas displayMessage directamente aquí

// Obtener referencias a los elementos del DOM
const registerForm = document.getElementById('registerForm');
const loginForm = document.getElementById('loginForm');
const logoutBtn = document.getElementById('logoutBtn');
const searchScheduleForm = document.getElementById('searchScheduleForm');
const bookTicketForm = document.getElementById('bookTicketForm');
const viewMyTicketsBtn = document.getElementById('viewMyTicketsBtn');
const ticketsList = document.getElementById('ticketsList'); // Para delegación de eventos de cancelar

// --- Event Listeners ---

// Registro de usuario
registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(registerForm);
    const data = Object.fromEntries(formData.entries());
    const success = await registerUser(data.name, data.email, data.password);
    if (success) {
        registerForm.reset();
    }
});

// Inicio de sesión
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(loginForm);
    const data = Object.fromEntries(formData.entries());
    const success = await loginUser(data.email, data.password);
    if (success) {
        loginForm.reset();
    }
});

// Cerrar sesión
logoutBtn.addEventListener('click', async () => {
    await logoutUser();
});

// Buscar horarios
searchScheduleForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(searchScheduleForm);
    const data = Object.fromEntries(formData.entries());
    await searchSchedules(data.route_id, data.date);
});

// Reservar ticket
bookTicketForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(bookTicketForm);
    const data = Object.fromEntries(formData.entries());
    const success = await bookTicket(data.schedule_id, data.seat_number);
    if (success) {
        bookTicketForm.reset();
        // Opcional: Si quieres que los horarios se refresquen automáticamente después de una reserva,
        // puedes disparar el evento del formulario de búsqueda de horarios aquí:
        // document.getElementById('searchScheduleForm').dispatchEvent(new Event('submit'));
    }
});

// Ver mis tickets
viewMyTicketsBtn.addEventListener('click', async () => {
    await viewMyTickets();
});

// Cancelar ticket (delegación de eventos para botones dinámicos)
ticketsList.addEventListener('click', async (e) => {
    if (e.target.classList.contains('action-btn')) {
        const ticketId = e.target.dataset.ticketId;
        await cancelTicket(ticketId);
    }
});


// --- Inicialización ---
// Verificar el estado de la sesión al cargar la página
checkLoginStatusOnLoad();