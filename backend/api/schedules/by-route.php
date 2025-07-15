<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/Schedule.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['route_id'], 'GET');

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$schedule = new Schedule($db);
$schedules = $schedule->findByRoute($data['route_id']);

sendResponse($schedules, 'Horarios obtenidos exitosamente');
?>