<?php
// api/auth/login.php
//Endpint para inicio de sesion
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../utils/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log('Intento de login con método no permitido: ' . $_SERVER['REQUEST_METHOD']);
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['email', 'password'], 'POST');
error_log('Intento de login para: ' . $data['email']);
$database = new Database();
$db = $database->getConnection();
if (!$db) {
    error_log('Error de conexión a la base de datos en login.php');
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
$userData = $user->findByEmail($data['email']);

if (!$userData) {
    error_log('Login fallido: usuario no existe para ' . $data['email']);
    sendError('No existe una cuenta con ese correo.', 404);
}


if (!password_verify($data['password'], $userData['Contraseña'])) {
    error_log('Login fallido: contraseña incorrecta para ' . $data['email'] .
        ' | Hash esperado: ' . $userData['Contraseña'] .
        ' | Hash generado: ' . password_hash($data['password'], PASSWORD_DEFAULT));
    sendError('Contraseña incorrecta.', 401);
}

$_SESSION['user_id'] = $userData['IdUsuario'];
$_SESSION['user_name'] = $userData['Nombre'];
$_SESSION['user_email'] = $userData['Correo'];
$_SESSION['user_role'] = $userData['Rol'];

error_log('Login exitoso para ' . $data['email']);
sendResponse([
    'user' => [
        'id' => $userData['IdUsuario'],
        'name' => $userData['Nombre'],
        'email' => $userData['Correo'],
        'role' => $userData['Rol']
    ]
], 'Login exitoso');
?>