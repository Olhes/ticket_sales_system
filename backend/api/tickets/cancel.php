<?php
// api/tickets/cancel.php
//Endpoint para cancelar un ticket
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Ticket.php';
require_once __DIR__ . '/../../classes/Schedule.php';
require_once __DIR__ . '/../../utils/helpers.php';
require_once __DIR__ . '/../../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Usamos POST para acciones que cambian el estado
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
    sendError("Acceso no autorizado. Inicia sesión para cancelar.", 401);
}

$data = validateRequiredFields(['ticket_id'], 'POST');
$user_id = $user_data['id'];

$ticket = new Ticket($db);
$schedule = new Schedule($db);

try {
    $db->beginTransaction(); // Inicia una transacción

    // 1. Obtener el ticket para verificar propietario y estado
    $ticket_info = $ticket->getById($data['ticket_id']);
    if (!$ticket_info) {
        $db->rollBack();
        sendError("Ticket no encontrado.", 404);
    }

    // Asegurarse de que el usuario autenticado sea el dueño del ticket
    if ($ticket_info['user_id'] != $user_id) {
        $db->rollBack();
        sendError("No tienes permiso para cancelar este ticket.", 403); // 403 Forbidden
    }

    // Asegurarse de que el ticket no esté ya cancelado
    if ($ticket_info['status'] == 'cancelled') {
        $db->rollBack();
        sendError("El ticket ya ha sido cancelado.", 409);
    }

    // 2. Actualizar el estado del ticket a 'cancelled'
    if (!$ticket->updateStatus($data['ticket_id'], 'cancelled')) {
        $db->rollBack();
        sendError("Error al actualizar el estado del ticket.", 500);
    }

    // 3. Incrementar asientos disponibles en el horario
    if (!$schedule->incrementAvailableSeats($ticket_info['schedule_id'])) {
        $db->rollBack();
        sendError("Error al actualizar la disponibilidad de asientos después de la cancelación.", 500);
    }

    $db->commit(); // Confirma la transacción
    sendResponse([], "Ticket cancelado exitosamente.");

} catch (PDOException $e) {
    $db->rollBack(); // Deshace la transacción en caso de error
    error_log("Error de cancelación de ticket: " . $e->getMessage());
    sendError("Error interno del servidor al procesar la cancelación.", 500);
}
?>