<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    sendError('Acceso denegado', 403);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

try {
    $query = "SELECT b.IdBus, b.Placa, b.CapacidadBus, b.TipoBus, 
                     b.Piso1Capacidad, b.Piso2Capacidad,
                     e.Nombre as empresa
              FROM Bus b
              JOIN Empresa e ON b.IdEmpresa = e.IdEmpresa
              ORDER BY b.Placa";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    sendResponse($buses, 'Buses obtenidos exitosamente');
} catch (PDOException $e) {
    error_log("Error al obtener buses: " . $e->getMessage());
    sendError('Error al obtener buses', 500);
}
?>