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
    $activities = [];
    
    // Últimos usuarios registrados
    $query = "SELECT Nombre, FechaCreacion FROM Usuario ORDER BY FechaCreacion DESC LIMIT 5";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        $activities[] = [
            'type' => 'user',
            'title' => "Nuevo usuario registrado: {$user['Nombre']}",
            'time' => date('d/m/Y H:i', strtotime($user['FechaCreacion']))
        ];
    }
    
    // Últimas reservas
    $query = "SELECT 
                CONCAT(p.Nombres, ' ', p.Apellidos) as pasajero,
                CONCAT(to.Nombre, ' → ', td.Nombre) as ruta,
                r.FechaCreacion
              FROM Reserva r
              JOIN Boleto b ON r.IdReserva = b.IdReserva
              JOIN Pasajero p ON b.IdPasajero = p.IdPasajero
              JOIN Horario h ON b.IdHorario = h.IdHorario
              JOIN Ruta rt ON h.IdRuta = rt.IdRuta
              JOIN Terminal to ON rt.IdTerminalOrigen = to.IdTerminal
              JOIN Terminal td ON rt.IdTerminalDestino = td.IdTerminal
              ORDER BY r.FechaCreacion DESC LIMIT 5";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($reservations as $reservation) {
        $activities[] = [
            'type' => 'reservation',
            'title' => "Nueva reserva: {$reservation['pasajero']} - {$reservation['ruta']}",
            'time' => date('d/m/Y H:i', strtotime($reservation['FechaCreacion']))
        ];
    }
    
    // Ordenar por fecha
    usort($activities, function($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });
    
    // Limitar a 10 actividades
    $activities = array_slice($activities, 0, 10);
    
    sendResponse($activities, 'Actividad reciente obtenida exitosamente');
} catch (PDOException $e) {
    error_log("Error al obtener actividad: " . $e->getMessage());
    sendError('Error al obtener actividad reciente', 500);
}
?>