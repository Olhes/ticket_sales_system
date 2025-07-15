<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/Ticket.php';
require_once '../../classes/Schedule.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    sendError('Usuario no autenticado', 401);
}

$data = validateRequiredFields(['schedule_id', 'passenger_name', 'passenger_dni', 'seat_number']);

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

// Verificar que el usuario existe en la base de datos
$user = new User($db);
$userData = $user->getById($_SESSION['user_id']);
if (!$userData) {
    sendError('Usuario no encontrado en la base de datos', 404);
}

// Verificar que el horario existe y tiene asientos disponibles
$schedule = new Schedule($db);
if (!$schedule->hasAvailableSeats($data['schedule_id'])) {
    sendError('No hay asientos disponibles para este horario', 400);
}

// Crear el ticket
$ticket = new Ticket($db);
if ($ticket->create($_SESSION['user_id'], $data['schedule_id'], $data['passenger_name'], $data['passenger_dni'], $data['seat_number'])) {
    sendResponse([], 'Boleto creado exitosamente');
} else {
    sendError('Error al crear el boleto', 500);
}
?>