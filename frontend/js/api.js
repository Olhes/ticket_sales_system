// frontend/js/api.js
//funciones para hacer llamadas al a api
import { API_BASE_URL } from './config.js';
import { displayMessage } from './ui.js';

export async function makeApiRequest(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        credentials: 'include' // Para enviar cookies de sesión
    };

    if (data) {
        options.body = new URLSearchParams(data).toString();
    }

    try {
        const response = await fetch(`${API_BASE_URL}${endpoint}`, options);
        const result = await response.json();

        if (!response.ok) {
            displayMessage(result.message || `Error ${response.status}: ${response.statusText}`, 'error');
        }
        return result;
    } catch (error) {
        console.error("Error al realizar la solicitud:", error);
        displayMessage(`Error de red o servidor: ${error.message}`, 'error');
        return null;
    }
}