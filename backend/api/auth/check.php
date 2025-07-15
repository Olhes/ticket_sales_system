<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Método no permitido', 405);
}

// Debug session information
$debug_info = [
    'session_id' => session_id(),
    'session_data' => $_SESSION,
    'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
    'is_authenticated' => isAuthenticated()
];

if (!isAuthenticated()) {
    sendResponse($debug_info, 'Usuario no autenticado');
    return;
}

// Check if user exists in database
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
$userData = $user->getById($_SESSION['user_id']);

$debug_info['user_exists_in_db'] = $userData ? true : false;
$debug_info['user_data'] = $userData;

sendResponse($debug_info, 'Información de sesión');
?>