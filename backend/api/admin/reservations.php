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
    $query = "SELECT 
                r.IdReserva, r.Estado, r.FechaCreacion,
                u.Nombre as usuario,
                CONCAT(p.Nombres, ' ', p.Apellidos) as pasajero,
                CONCAT(to.Nombre, ' → ', td.Nombre) as ruta,
                h.FechaSalida, h.HoraSalida,
                b.NumAsiento, b.PrecioFinal
              FROM Reserva r
              JOIN Usuario u ON r.IdUsuario = u.IdUsuario
              JOIN Boleto b ON r.IdReserva = b.IdReserva
              JOIN Pasajero p ON b.IdPasajero = p.IdPasajero
              JOIN Horario h ON b.IdHorario = h.IdHorario
              JOIN Ruta rt ON h.IdRuta = rt.IdRuta
              JOIN Terminal to ON rt.IdTerminalOrigen = to.IdTerminal
              JOIN Terminal td ON rt.IdTerminalDestino = td.IdTerminal
              ORDER BY r.FechaCreacion DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    sendResponse($reservations, 'Reservas obtenidas exitosamente');
} catch (PDOException $e) {
    error_log("Error al obtener reservas: " . $e->getMessage());
    sendError('Error al obtener reservas', 500);
}
?>