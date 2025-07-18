<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../utils/helpers.php';

$database = new Database();
$db = $database->getConnection();
if ($db === null) {
    sendError("Error al conectar con la base de datos.", 500);
}

$buses = $db->query('SELECT IdBus, Placa FROM Bus')->fetchAll(PDO::FETCH_ASSOC);
$rutas = $db->query('SELECT IdRuta FROM Ruta')->fetchAll(PDO::FETCH_ASSOC);
$conductores = $db->query('SELECT IdConductor, Nombres, Apellidos FROM Conductor')->fetchAll(PDO::FETCH_ASSOC);

sendResponse([
    'buses' => $buses,
    'rutas' => $rutas,
    'conductores' => $conductores
]);
