<?php
// api/auth/register.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../utils/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['name', 'email', 'password'], 'POST');

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    sendError('Email inválido', 400);
}
if (strlen($data['password']) < 6) {
    sendError('La contraseña debe tener al menos 6 caracteres', 400);
}

$database = new Database();
$db = $database->getConnection();
if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
if ($user->findByEmail($data['email'])) {
    sendError('El email ya está registrado', 409);
}

$password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
if ($user->create($data['name'], $data['email'], $password_hash)) {
    sendResponse([], 'Usuario registrado exitosamente');
} else {
    sendError('Error al registrar usuario', 500);
}
?>