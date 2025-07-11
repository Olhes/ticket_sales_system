<?php
// api/auth/login.php
//Endpint para inicio de sesion
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/User.php'; // Auth necesita User
require_once __DIR__ . '/../../utils/helpers.php';
require_ONCE __DIR__.   '/../../../frontend/form.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError("Método no permitido.", 405);
}

$database = new Database();
$db = $database->getConnection();
if ($db === null) {
    sendError("Error al conectar con la base de datos.", 500);
}

$data = validateRequiredFields(['email', 'password'], 'POST');

$auth = new Auth($db);

if ($user_data = $auth->login($data['email'], $data['password'])) {
    sendResponse($user_data, "Inicio de sesión exitoso.");
} else {
    sendError("Email o contraseña incorrectos.", 401);
}
?>