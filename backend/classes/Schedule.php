<?php
// classes/Schedule.php
//clase para el horario/Viaje
class Schedule {
    private $conn;
    private $table_name = "Horario";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todos los horarios con información completa.
     * @return array Lista de horarios.
     */
    public function getAll() {
        $query = "SELECT 
                    h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.PrecioBase,
                    CONCAT(tor.Nombre, ' → ', td.Nombre) as ruta,
                    CONCAT(b.Placa, ' (', b.TipoBus, ')') as bus,
                    CONCAT(c.Nombres, ' ', c.Apellidos) as conductor
                  FROM " . $this->table_name . " h
                  JOIN Ruta r ON h.IdRuta = r.IdRuta
                  JOIN Terminal tor ON r.IdTerminalOrigen = tor.IdTerminal
                  JOIN Terminal td ON r.IdTerminalDestino = td.IdTerminal
                  JOIN Bus b ON h.IdBus = b.IdBus
                  JOIN Conductor c ON h.IdConductor = c.IdConductor
                  ORDER BY h.FechaSalida, h.HoraSalida";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los horarios para una ruta específica.
     * @param int $route_id
     * @return array Lista de horarios.
     */
    public function findByRoute($route_id) {
        $query = "SELECT 
                    h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.PrecioBase,
                    b.CapacidadBus,
                    (b.CapacidadBus - COALESCE(
                        (SELECT COUNT(*) FROM Boleto bo 
                         JOIN Reserva res ON bo.IdReserva = res.IdReserva 
                         WHERE bo.IdHorario = h.IdHorario AND res.Estado = 'Confirmada'), 0
                    )) as asientos_disponibles
                  FROM " . $this->table_name . " h
                  JOIN Bus b ON h.IdBus = b.IdBus
                  WHERE h.IdRuta = :route_id AND h.FechaSalida >= CURDATE()
                  ORDER BY h.FechaSalida, h.HoraSalida";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':route_id', $route_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un horario por su ID.
     * @param int $id
     * @return array|false Datos del horario o false si no se encuentra.
     */
    public function getById($id) {
        $query = "SELECT 
                    h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.PrecioBase,
                    h.IdRuta, h.IdBus, h.IdConductor,
                    b.CapacidadBus
                  FROM " . $this->table_name . " h
                  JOIN Bus b ON h.IdBus = b.IdBus
                  WHERE h.IdHorario = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si hay asientos disponibles para un horario.
     * @param int $schedule_id
     * @return bool
     */
    public function hasAvailableSeats($schedule_id) {
        $query = "SELECT 
                    (b.CapacidadBus - COALESCE(
                        (SELECT COUNT(*) FROM Boleto bo 
                         JOIN Reserva res ON bo.IdReserva = res.IdReserva 
                         WHERE bo.IdHorario = :schedule_id AND res.Estado = 'Confirmada'), 0
                    )) as asientos_disponibles
                  FROM Horario h
                  JOIN Bus b ON h.IdBus = b.IdBus
                  WHERE h.IdHorario = :schedule_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['asientos_disponibles'] > 0;
    }
}
?>