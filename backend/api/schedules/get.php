<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Schedule.php';
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

$schedule = new Schedule($db);

if (isset($_GET['route_id']) && isset($_GET['date'])) {
    $route_id = $_GET['route_id'];
    $date = $_GET['date'];
    $schedules = $schedule->findByRouteAndDate($route_id, $date);
} else {
    $schedules = $schedule->getAll();
}

sendResponse($schedules, "Horarios obtenidos exitosamente.");
?>