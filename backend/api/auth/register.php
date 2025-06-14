<?php
// api/auth/register.php
//Enpoint para registro de usuarios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/User.php'; // Auth necesita User, pero también es buena práctica incluirla aquí si se manipula directamente
require_once __DIR__ . '/../../utils/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError("Método no permitido.", 405);
}

$database = new Database();
$db = $database->getConnection();
if ($db === null) {
    sendError("Error al conectar con la base de datos.", 500);
}

$data = validateRequiredFields(['name', 'email', 'password'], 'POST');

$auth = new Auth($db);

if ($auth->register($data['name'], $data['email'], $data['password'])) {
    sendResponse([], "Usuario registrado exitosamente.");
} else {
    sendError("Error al registrar usuario. El email podría ya estar en uso o hubo un error de DB.", 409);
}
?>