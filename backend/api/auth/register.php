<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['name', 'email', 'password']);

// Validar email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    sendError('Email inválido', 400);
}

// Validar contraseña
if (strlen($data['password']) < 6) {
    sendError('La contraseña debe tener al menos 6 caracteres', 400);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);

// Verificar si el usuario ya existe
if ($user->findByEmail($data['email'])) {
    sendError('El email ya está registrado', 409);
}

// Hash de la contraseña
$password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

// Crear usuario
if ($user->create($data['name'], $data['email'], $password_hash)) {
    sendResponse([], 'Usuario registrado exitosamente');
} else {
    sendError('Error al registrar usuario', 500);
}
?>