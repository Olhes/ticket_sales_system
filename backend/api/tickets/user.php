<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/Ticket.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    sendError('Usuario no autenticado', 401);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$ticket = new Ticket($db);
$tickets = $ticket->getByUserId($_SESSION['user_id']);

sendResponse($tickets, 'Tickets obtenidos exitosamente');
?>