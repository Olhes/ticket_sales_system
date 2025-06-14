// frontend/js/schedules.js
//Logica para buscar y mostrar horarios
import { makeApiRequest } from './api.js';
import { displayMessage, renderSchedules } from './ui.js';

export async function searchSchedules(routeId, date) {
    const queryString = new URLSearchParams({ route_id: routeId, date: date }).toString();
    const result = await makeApiRequest(`/schedules/get?${queryString}`, 'GET');

    if (result && result.success && result.data.length > 0) {
        renderSchedules(result.data);
        displayMessage(result.message, 'success');
    } else {
        renderSchedules([]); // Limpiar y ocultar si no hay resultados
        displayMessage(result ? result.message : 'No se encontraron horarios o hubo un error.', 'error');
    }
    return result;
}