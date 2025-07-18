<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Ticket.php';
require_once __DIR__ . '/../../utils/helpers.php';
require_once __DIR__ . '/../../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError("Método no permitido.", 405);
}

$database = new Database();
$db = $database->getConnection();
if ($db === null) {
    sendError("Error al conectar con la base de datos.", 500);
}

$auth = new Auth($db);
$user_data = $auth->getAuthenticatedUser();
if (!$user_data) {
    sendError("Acceso no autorizado. Inicia sesión para ver tus tickets.", 401);
}

$ticket = new Ticket($db);
$user_tickets = $ticket->getByUserId($user_id = $user_data['id']);

if ($user_tickets) {
    sendResponse($user_tickets, "Tickets del usuario obtenidos exitosamente.");
} else {
    sendError("No se encontraron tickets para este usuario.", 404);
}
?>