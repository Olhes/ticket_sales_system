<?php
class Schedule {
    private $conn;
    private $table_name = "Horario";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.IdBus, h.IdRuta, h.IdConductor FROM " . $this->table_name . " h ORDER BY h.FechaSalida DESC, h.HoraSalida DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByRouteAndDate($route_id, $date) {
        $query = "SELECT h.IdHorario, h.FechaSalida, h.HoraSalida, h.HoraLlegada, h.IdBus, h.IdRuta, h.IdConductor FROM " . $this->table_name . " h WHERE h.IdRuta = :route_id AND h.FechaSalida = :date ORDER BY h.HoraSalida";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':route_id', $route_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT IdHorario, FechaSalida, HoraSalida, HoraLlegada, IdBus, IdRuta, IdConductor FROM " . $this->table_name . " WHERE IdHorario = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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