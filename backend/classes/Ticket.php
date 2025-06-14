<?php
// classes/Ticket.php
//clase para entidad ticket
class Ticket {
    private $conn;
    private $table_name = "tickets"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Crea un nuevo ticket (reserva).
     * @param int $user_id
     * @param int $schedule_id
     * @param int $seat_number
     * @param string $status (ej. 'booked', 'pending', 'cancelled')
     * @return bool True si la creación fue exitosa.
     */
    public function create($user_id, $schedule_id, $seat_number, $status = 'booked') {
        $query = "INSERT INTO " . $this->table_name . " (user_id, schedule_id, seat_number, booking_date, status) VALUES (:user_id, :schedule_id, :seat_number, NOW(), :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
        $stmt->bindParam(':seat_number', $seat_number, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear ticket: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza el estado de un ticket (ej. a 'cancelled').
     * @param int $ticket_id
     * @param string $status El nuevo estado.
     * @return bool True si la actualización fue exitosa.
     */
    public function updateStatus($ticket_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $ticket_id, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar estado del ticket: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los tickets de un usuario.
     * @param int $user_id
     * @return array Lista de tickets del usuario.
     */
    public function getByUserId($user_id) {
        $query = "SELECT
                    t.id AS ticket_id, t.seat_number, t.booking_date, t.status,
                    s.departure_time, s.arrival_time, s.date, s.price,
                    r.origin, r.destination,
                    b.plate_number, b.model
                  FROM " . $this->table_name . " t
                  JOIN schedules s ON t.schedule_id = s.id
                  JOIN routes r ON s.route_id = r.id
                  JOIN buses b ON s.bus_id = b.id
                  WHERE t.user_id = :user_id
                  ORDER BY t.booking_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un ticket por su ID.
     * @param int $ticket_id
     * @return array|false Datos del ticket o false si no se encuentra.
     */
    public function getById($ticket_id) {
        $query = "SELECT id, user_id, schedule_id, seat_number, status FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>