<?php
// classes/Schedule.php
//clase para el horario/Viaje
class Schedule {
    private $conn;
    private $table_name = "Horario"; // Ahora coincide con la tabla real

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todos los horarios (sin filtro por ruta ni fecha).
     * @return array Lista de horarios.
     */
    public function getAll() {
        $query = "SELECT h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.IdBus, h.IdRuta, h.IdConductor FROM " . $this->table_name . " h ORDER BY h.FechaSalida DESC, h.HoraSalida DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los horarios para una ruta y fecha específicas.
     * @param int $route_id
     * @param string $date (Formato 'YYYY-MM-DD')
     * @return array Lista de horarios.
     */
    public function findByRouteAndDate($route_id, $date) {
        $query = "SELECT h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.IdBus, h.IdRuta, h.IdConductor FROM " . $this->table_name . " h WHERE h.IdRuta = :route_id AND h.FechaSalida = :date ORDER BY h.HoraSalida";
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
        $query = "SELECT IdHorario, FechaSalida, HoraSalida, HoraLlegada, IdBus, IdRuta, IdConductor FROM " . $this->table_name . " WHERE IdHorario = :id LIMIT 0,1";
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

    /**
     * Crea un nuevo horario.
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $query = "INSERT INTO Horario (FechaSalida, HoraSalida, HoraLlegada, IdBus, IdRuta, IdConductor) VALUES (:FechaSalida, :HoraSalida, :HoraLlegada, :IdBus, :IdRuta, :IdConductor)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':FechaSalida', $data['FechaSalida']);
        $stmt->bindParam(':HoraSalida', $data['HoraSalida']);
        $stmt->bindParam(':HoraLlegada', $data['HoraLlegada']);
        $stmt->bindParam(':IdBus', $data['IdBus'], PDO::PARAM_INT);
        $stmt->bindParam(':IdRuta', $data['IdRuta'], PDO::PARAM_INT);
        $stmt->bindParam(':IdConductor', $data['IdConductor'], PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al crear horario: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza un horario existente.
     * @param array $data
     * @return bool
     */
    public function update($data) {
        $query = "UPDATE Horario SET FechaSalida = :FechaSalida, HoraSalida = :HoraSalida, HoraLlegada = :HoraLlegada, IdBus = :IdBus, IdRuta = :IdRuta, IdConductor = :IdConductor WHERE IdHorario = :IdHorario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':FechaSalida', $data['FechaSalida']);
        $stmt->bindParam(':HoraSalida', $data['HoraSalida']);
        $stmt->bindParam(':HoraLlegada', $data['HoraLlegada']);
        $stmt->bindParam(':IdBus', $data['IdBus'], PDO::PARAM_INT);
        $stmt->bindParam(':IdRuta', $data['IdRuta'], PDO::PARAM_INT);
        $stmt->bindParam(':IdConductor', $data['IdConductor'], PDO::PARAM_INT);
        $stmt->bindParam(':IdHorario', $data['IdHorario'], PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al actualizar horario: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un horario por su ID.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $query = "DELETE FROM Horario WHERE IdHorario = :IdHorario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':IdHorario', $id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al eliminar horario: ' . $e->getMessage());
            return false;
        }
    }
}
?>