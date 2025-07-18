<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../utils/helpers.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['email', 'password'], 'POST');
$database = new Database();
$db = $database->getConnection();
if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
$userData = $user->findByEmail($data['email']);

if (!$userData) {
    sendError('No existe una cuenta con ese correo.', 404);
}

if (!password_verify($data['password'], $userData['Contraseña'])) {
    sendError('Contraseña incorrecta.', 401);
}

$_SESSION['user_id'] = $userData['IdUsuario'];
$_SESSION['user_name'] = $userData['Nombre'];
$_SESSION['user_email'] = $userData['Correo'];
$_SESSION['user_role'] = $userData['Rol'];

sendResponse([
    'user' => [
        'id' => $userData['IdUsuario'],
        'name' => $userData['Nombre'],
        'email' => $userData['Correo'],
        'role' => $userData['Rol']
    ]
], 'Login exitoso');
?>