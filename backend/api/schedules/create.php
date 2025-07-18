<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
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
if (!$auth->isAuthenticated()) {
    sendError("Acceso no autorizado. Inicia sesión.", 401);
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    sendError("Datos JSON inválidos.", 400);
}

$required = ['FechaSalida', 'HoraSalida', 'HoraLlegada', 'IdBus', 'IdRuta', 'IdConductor'];
foreach ($required as $field) {
    if (!isset($data[$field])) {
        sendError("Falta el campo $field", 400);
    }
}

$schedule = new Schedule($db);
$success = $schedule->create($data);
if ($success) {
    sendResponse(["success" => true], "Horario creado correctamente.");
} else {
    sendError("No se pudo crear el horario.", 500);
}
