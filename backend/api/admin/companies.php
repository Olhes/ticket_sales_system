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
    $query = "SELECT e.IdEmpresa, e.Nombre, e.RUC, 
                     COUNT(b.IdBus) as buses_count
              FROM Empresa e
              LEFT JOIN Bus b ON e.IdEmpresa = b.IdEmpresa
              GROUP BY e.IdEmpresa, e.Nombre, e.RUC
              ORDER BY e.Nombre";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    sendResponse($companies, 'Empresas obtenidas exitosamente');
} catch (PDOException $e) {
    error_log("Error al obtener empresas: " . $e->getMessage());
    sendError('Error al obtener empresas', 500);
}
?>