<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    sendError('Acceso denegado', 403);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);
$users = $user->getAll();

sendResponse($users, 'Usuarios obtenidos exitosamente');
?>