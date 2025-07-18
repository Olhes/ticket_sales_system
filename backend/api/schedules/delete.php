<?php
// api/schedules/delete.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Schedule.php';
require_once __DIR__ . '/../../utils/helpers.php';
require_once __DIR__ . '/../../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    sendError("Método no permitido.", 405);
}

$database = new Database();
$db = $database->getConnection();
if ($db === null) {
    sendError("Error al conectar con la base de datos.", 500);
}

$auth = new Auth($db);
if (!$auth->isAuthenticated()) {
    sendError("Acceso no autorizado. Inicia sesión.", 401);
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['IdHorario'])) {
    sendError("Datos JSON inválidos o falta IdHorario.", 400);
}

$schedule = new Schedule($db);
$success = $schedule->delete($data['IdHorario']);
if ($success) {
    sendResponse(["success" => true], "Horario eliminado correctamente.");
} else {
    sendError("No se pudo eliminar el horario.", 500);
}
