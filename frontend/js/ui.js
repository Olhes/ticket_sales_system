// frontend/js/ui.js
//funciones para manipular interfaz de usuario(mostrar mensjes,actualizar visibilidad)
const messageArea = document.getElementById('messageArea');

export function displayMessage(message, type) {
    messageArea.textContent = message;
    messageArea.className = `message ${type}`;
    messageArea.style.display = 'block';
    setTimeout(() => {
        messageArea.style.display = 'none';
    }, 5000);
}

export function updateUIVisibility(isLoggedIn, userEmail = '', userRole = '') {
    const loggedInUser = document.getElementById('loggedInUser');
    const userEmailDisplay = document.getElementById('userEmailDisplay');
    const userRoleDisplay = document.getElementById('userRoleDisplay');
    const logoutBtn = document.getElementById('logoutBtn');
    const searchScheduleForm = document.getElementById('searchScheduleForm');
    const bookTicketForm = document.getElementById('bookTicketForm');
    const viewMyTicketsBtn = document.getElementById('viewMyTicketsBtn');
    const schedulesResult = document.getElementById('schedulesResult');
    const ticketsResult = document.getElementById('ticketsResult');

    if (isLoggedIn) {
        loggedInUser.style.display = 'block';
        userEmailDisplay.textContent = userEmail;
        userRoleDisplay.textContent = userRole;
        logoutBtn.style.display = 'block';
        searchScheduleForm.style.display = 'block';
        bookTicketForm.style.display = 'block';
        viewMyTicketsBtn.style.display = 'block';
    } else {
        loggedInUser.style.display = 'none';
        logoutBtn.style.display = 'none';
        searchScheduleForm.style.display = 'none';
        bookTicketForm.style.display = 'none';
        viewMyTicketsBtn.style.display = 'none';
        schedulesResult.style.display = 'none'; // Ocultar resultados si no hay sesión
        ticketsResult.style.display = 'none';   // Ocultar resultados si no hay sesión
    }
}

export function renderSchedules(schedules) {
    const schedulesList = document.getElementById('schedulesList');
    const schedulesResult = document.getElementById('schedulesResult');
    schedulesList.innerHTML = ''; // Limpiar lista

    if (schedules && schedules.length > 0) {
        schedulesResult.style.display = 'block';
        schedules.forEach(schedule => {
            const li = document.createElement('li');
            li.innerHTML = `
                <strong>ID: ${schedule.id}</strong> - ${schedule.origin} a ${schedule.destination}<br>
                Bus: ${schedule.plate_number} (${schedule.model})<br>
                Salida: ${schedule.departure_time} - Llegada: ${schedule.arrival_time}<br>
                Fecha: ${schedule.date} - Precio: $${schedule.price} - Asientos Disponibles: ${schedule.available_seats}
            `;
            schedulesList.appendChild(li);
        });
    } else {
        schedulesResult.style.display = 'none';
    }
}

export function renderTickets(tickets) {
    const ticketsList = document.getElementById('ticketsList');
    const ticketsResult = document.getElementById('ticketsResult');
    ticketsList.innerHTML = ''; // Limpiar lista

    if (tickets && tickets.length > 0) {
        ticketsResult.style.display = 'block';
        tickets.forEach(ticket => {
            const li = document.createElement('li');
            const bookingDate = new Date(ticket.booking_date).toLocaleString();
            li.innerHTML = `
                <div>
                    <strong>Ticket ID: ${ticket.ticket_id}</strong> (Asiento: ${ticket.seat_number})<br>
                    Ruta: ${ticket.origin} a ${ticket.destination}<br>
                    Viaje: ${ticket.date} ${ticket.departure_time} (Bus: ${ticket.plate_number})<br>
                    Precio: $${ticket.price} - Estado: ${ticket.status}<br>
                    Reservado el: ${bookingDate}
                </div>
                ${ticket.status === 'booked' ? `<button class="action-btn" data-ticket-id="${ticket.ticket_id}">Cancelar Ticket</button>` : ''}
            `;
            ticketsList.appendChild(li);
        });
    } else {
        ticketsResult.style.display = 'none';
    }
}