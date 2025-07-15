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
    sendError('ID de usuario requerido', 400);
}

$userId = $input['id'];

// No permitir que el admin se elimine a sí mismo
if ($userId == $_SESSION['user_id']) {
    sendError('No puedes eliminar tu propia cuenta', 400);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

try {
    // Verificar si el usuario tiene reservas
    $query = "SELECT COUNT(*) as count FROM Reserva WHERE IdUsuario = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] > 0) {
        sendError('No se puede eliminar el usuario porque tiene reservas asociadas', 400);
    }
    
    // Eliminar usuario
    $query = "DELETE FROM Usuario WHERE IdUsuario = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        sendResponse([], 'Usuario eliminado exitosamente');
    } else {
        sendError('Error al eliminar usuario', 500);
    }
} catch (PDOException $e) {
    error_log("Error al eliminar usuario: " . $e->getMessage());
    sendError('Error al eliminar usuario', 500);
}
?>