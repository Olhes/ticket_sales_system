<?php
// api/tickets/book.php
//endpoint para reservar un ticket
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Ticket.php';
require_once __DIR__ . '/../../classes/Schedule.php';
require_once __DIR__ . '/../../utils/helpers.php';
require_once __DIR__ . '/../../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
    sendError("Acceso no autorizado. Inicia sesión para reservar.", 401);
}

$data = validateRequiredFields(['schedule_id', 'seat_number'], 'POST');
$user_id = $user_data['id'];

$ticket = new Ticket($db);
$schedule = new Schedule($db);

// --- Lógica de Reserva (requiere transacciones para ser robusta) ---
try {
    $db->beginTransaction(); // Inicia una transacción

    // 1. Verificar si el horario existe y hay asientos disponibles
    $schedule_info = $schedule->getById($data['schedule_id']);
    if (!$schedule_info || $schedule_info['available_seats'] <= 0) {
        $db->rollBack();
        sendError("No hay asientos disponibles para este horario o el horario no existe.", 409);
    }

    // Opcional: Verificar si el asiento específico ya está ocupado (más complejo, requeriría una tabla de asientos por bus o logic)
    // Por simplicidad, este ejemplo solo maneja el conteo total de asientos disponibles.

    // 2. Crear el ticket
    if (!$ticket->create($user_id, $data['schedule_id'], $data['seat_number'])) {
        $db->rollBack();
        sendError("Error al crear el ticket. Es posible que el asiento ya esté ocupado (aunque no se valida explícitamente aquí).", 500);
    }

    // 3. Decrementar asientos disponibles en el horario
    if (!$schedule->decrementAvailableSeats($data['schedule_id'])) {
        $db->rollBack();
        sendError("Error al actualizar la disponibilidad de asientos después de la reserva.", 500);
    }

    $db->commit(); // Confirma la transacción
    sendResponse([], "Ticket reservado exitosamente.");

} catch (PDOException $e) {
    $db->rollBack(); // Deshace la transacción en caso de error
    error_log("Error de reserva de ticket: " . $e->getMessage());
    sendError("Error interno del servidor al procesar la reserva.", 500);
}
?>