<?php
// classes/Schedule.php
//clase para el horario/Viaje
class Schedule {
    private $conn;
    private $table_name = "Horario"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene los horarios para una ruta y fecha específicas.
     * @param int $route_id
     * @param string $date (Formato 'YYYY-MM-DD')
     * @return array Lista de horarios.
     */
    public function findByRouteAndDate($route_id, $date) {
        $query = "SELECT
                    s.id, s.route_id, s.bus_id, s.departure_time, s.arrival_time, s.date, s.price, s.available_seats,
                    r.origin, r.destination, b.plate_number, b.capacity, b.model
                  FROM " . $this->table_name . " s
                  JOIN routes r ON s.route_id = r.id
                  JOIN buses b ON s.bus_id = b.id
                  WHERE s.route_id = :route_id AND s.date = :date AND s.available_seats > 0
                  ORDER BY s.departure_time";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':route_id', $route_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un horario por su ID.
     * @param int $id
     * @return array|false Datos del horario o false si no se encuentra.
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un horario por su ID.
     * @param string $origen
     * @param string $destino
     * @param string $fecha
     * @return array|false Datos del horario o false si no se encuentra.
     */

    public function getASchedule($origen, $destino, $fecha) {
        $query = "SELECT h.* FROM " . $this->table_name . " as h 
        INNER JOIN Ruta ON Ruta.IdRuta = h.IdRuta 
        INNER JOIN Bus ON Bus.IdBus = h.IdBus
        INNER JOIN Terminal as E ON E.IdTerminal = Ruta.IdTerminalOrigen AND E.Direccion LIKE :origen
        INNER JOIN Terminal as A ON A.IdTerminal = Ruta.IdTerminalDestino AND A.Direccion LIKE :destino
        WHERE h.FechaSalida LIKE :fecha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':origen', $origen);
        $stmt->bindParam(':destino', $destino);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Decrementa el número de asientos disponibles para un horario.
     * @param int $schedule_id
     * @return bool True si la actualización fue exitosa.
     */
    public function decrementAvailableSeats($schedule_id) {
        $query = "UPDATE " . $this->table_name . " SET available_seats = available_seats - 1 WHERE id = :id AND available_seats > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $schedule_id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al decrementar asientos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Incrementa el número de asientos disponibles para un horario (ej. al cancelar un ticket).
     * @param int $schedule_id
     * @return bool True si la actualización fue exitosa.
     */
    public function incrementAvailableSeats($schedule_id) {
        $query = "UPDATE " . $this->table_name . " SET available_seats = available_seats + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $schedule_id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al incrementar asientos: " . $e->getMessage());
            return false;
        }
    }
}
?>