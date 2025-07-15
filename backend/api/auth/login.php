<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['email', 'password']);

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
$userData = $user->findByEmail($data['email']);

if (!$userData || !password_verify($data['password'], $userData['Contraseña'])) {
    sendError('Credenciales inválidas', 401);
}

// Iniciar sesión
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