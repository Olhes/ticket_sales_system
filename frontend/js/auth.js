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
        sessionStorage.removeItem('user');
        sessionStorage.removeItem('currentUser');
        displayMessage(result.message, 'success');
        updateUIVisibility(false);
        window.location.href = 'form.php';
        return true;
    } else {
        displayMessage("Error al cerrar sesión. Puede que ya estuvieras desconectado.", 'error');
        updateUIVisibility(false);
        // No redirigir si hay error, solo mostrar mensaje
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