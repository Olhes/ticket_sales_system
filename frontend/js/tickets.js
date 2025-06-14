// frontend/js/tickets.js
//Logica para reservar,ver,cancelar ticketsS
import { makeApiRequest } from './api.js';
import { displayMessage, renderTickets } from './ui.js';
import { searchSchedules } from './schedules.js'; // Necesario para refrescar horarios después de reservar

export async function bookTicket(scheduleId, seatNumber) {
    const result = await makeApiRequest('/tickets/book', 'POST', { schedule_id: scheduleId, seat_number: seatNumber });
    if (result && result.success) {
        displayMessage(result.message, 'success');
        // Opcional: Después de reservar, podrías querer actualizar los horarios
        // Esto requeriría saber la ruta y fecha de búsqueda actuales.
        // Por ahora, el main.js puede encargarse de volver a buscar si se desea.
        return true;
    }
    return false;
}

export async function viewMyTickets() {
    const result = await makeApiRequest('/tickets/user_tickets', 'GET');

    if (result && result.success && result.data.length > 0) {
        renderTickets(result.data);
        displayMessage(result.message, 'success');
    } else {
        renderTickets([]); // Limpiar y ocultar si no hay resultados
        displayMessage(result ? result.message : 'No se encontraron tickets o hubo un error.', 'error');
    }
    return result;
}

export async function cancelTicket(ticketId) {
    if (!confirm(`¿Estás seguro de que quieres cancelar el ticket ${ticketId}?`)) {
        return false;
    }

    const result = await makeApiRequest('/tickets/cancel', 'POST', { ticket_id: ticketId });
    if (result && result.success) {
        displayMessage(result.message, 'success');
        await viewMyTickets(); // Recargar la lista de tickets después de cancelar
        // Considerar también re-buscar horarios si la cancelación libera asientos en un horario visible.
        return true;
    }
    return false;
}