// frontend/js/auth.js
//Logica de autenticación(registro,login,logout)
import { makeApiRequest } from './api.js';
import { displayMessage, updateUIVisibility } from './ui.js';

export async function registerUser(name, email, password) {
    const result = await makeApiRequest('/auth/register', 'POST', { name, email, password });
    if (result && result.success) {
        displayMessage(result.message, 'success');
        return true;
    }
    return false;
}

export async function loginUser(email, password) {
    const result = await makeApiRequest('/auth/login', 'POST', { email, password });
    if (result && result.success) {
        displayMessage(result.message, 'success');
        sessionStorage.setItem('currentUser', JSON.stringify(result.data));
        updateUIVisibility(true, result.data.email, result.data.role);
        return true;
    }
    return false;
}

export async function logoutUser() {
    const result = await makeApiRequest('/auth/logout', 'POST');
    if (result && result.success) {
        displayMessage(result.message, 'success');
        sessionStorage.removeItem('currentUser');
        updateUIVisibility(false); // Oculta todos los elementos de usuario logueado
        return true;
    } else {
        displayMessage("Error al cerrar sesión. Puede que ya estuvieras desconectado.", 'error');
        sessionStorage.removeItem('currentUser'); // Forzar limpieza
        updateUIVisibility(false);
    }
    return false;
}

export function getCurrentUser() {
    const user = sessionStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
}

export function checkLoginStatusOnLoad() {
    const currentUser = getCurrentUser();
    if (currentUser) {
        updateUIVisibility(true, currentUser.email, currentUser.role);
    } else {
        updateUIVisibility(false);
    }
}