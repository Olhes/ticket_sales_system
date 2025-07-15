<?php
require_once '../../../utils/helpers.php';
require_once '../../../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    sendError('Acceso denegado', 403);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['id'])) {
    sendError('ID de reserva requerido', 400);
}

$reservationId = $input['id'];

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

try {
    // Actualizar estado de la reserva
    $query = "UPDATE Reserva SET Estado = 'Cancelada' WHERE IdReserva = :reservation_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        sendResponse([], 'Reserva cancelada exitosamente');
    } else {
        sendError('Error al cancelar reserva', 500);
    }
} catch (PDOException $e) {
    error_log("Error al cancelar reserva: " . $e->getMessage());
    sendError('Error al cancelar reserva', 500);
}
?>