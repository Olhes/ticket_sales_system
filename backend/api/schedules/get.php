<?php
// api/schedules/get.php
//endpoint para obtener horario de viajes
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Schedule.php';
require_once __DIR__ . '/../../classes/Route.php'; // Para mostrar info de la ruta
require_once __DIR__ . '/../../classes/Bus.php';    // Para mostrar info del bus
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
if (!$auth->isAuthenticated()) {
    sendError("Acceso no autorizado. Inicia sesión.", 401);
}

$data = validateRequiredFields(['origen', 'destino', 'fecha'], 'GET');

$schedule = new Schedule($db);
$schedules = $schedule->getASchedule($data['origen'], $data['destino'], $data['fecha']);

if (empty($schedules)) {
    sendError("No se encontraron horarios para la ruta y fecha especificadas.", 404);
}

?>