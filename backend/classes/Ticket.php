<?php
// classes/Ticket.php
//clase para entidad ticket
class Ticket {
    private $conn;
    private $reserva_table = "Reserva";
    private $boleto_table = "Boleto";
    private $pasajero_table = "Pasajero";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Crea un nuevo ticket (reserva completa).
     * @param int $user_id
     * @param int $schedule_id
     * @param string $passenger_name
     * @param string $passenger_dni
     * @param string $seat_number
     * @return bool True si la creación fue exitosa.
     */
    public function create($user_id, $schedule_id, $passenger_name, $passenger_dni, $seat_number) {
        try {
            $this->conn->beginTransaction();

            // 1. Crear reserva
            $query = "INSERT INTO " . $this->reserva_table . " (FechaCreacion, Estado, IdUsuario) VALUES (NOW(), 'Confirmada', :user_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $reserva_id = $this->conn->lastInsertId();

            // 2. Crear pasajero
            $names = explode(' ', $passenger_name, 2);
            $nombres = $names[0];
            $apellidos = isset($names[1]) ? $names[1] : '';
            
            $query = "INSERT INTO " . $this->pasajero_table . " (Nombres, Apellidos, DNI, IdReserva) VALUES (:nombres, :apellidos, :dni, :reserva_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':dni', $passenger_dni);
            $stmt->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
            $stmt->execute();
            $pasajero_id = $this->conn->lastInsertId();

            // 3. Obtener precio del horario
            $query = "SELECT PrecioBase FROM Horario WHERE IdHorario = :schedule_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            $stmt->execute();
            $horario = $stmt->fetch(PDO::FETCH_ASSOC);
            $precio = $horario['PrecioBase'];

            // 4. Crear boleto
            $query = "INSERT INTO " . $this->boleto_table . " (NumAsiento, PrecioFinal, IdReserva, IdHorario, IdPasajero) VALUES (:seat, :precio, :reserva_id, :schedule_id, :pasajero_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':seat', $seat_number);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            $stmt->bindParam(':pasajero_id', $pasajero_id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error al crear ticket: " . $e->getMessage());
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
                    b.IdBoleto, b.NumAsiento, b.PrecioFinal,
                    h.FechaSalida, h.HoraSalida, h.HoraLlegada,
                    CONCAT(tor.Nombre, ' → ', td.Nombre) as ruta,
                    CONCAT(p.Nombres, ' ', p.Apellidos) as pasajero,
                    r.Estado, r.FechaCreacion
                  FROM " . $this->boleto_table . " b
                  JOIN " . $this->reserva_table . " r ON b.IdReserva = r.IdReserva
                  JOIN " . $this->pasajero_table . " p ON b.IdPasajero = p.IdPasajero
                  JOIN Horario h ON b.IdHorario = h.IdHorario
                  JOIN Ruta rt ON h.IdRuta = rt.IdRuta
                  JOIN Terminal tor ON rt.IdTerminalOrigen = tor.IdTerminal
                  JOIN Terminal td ON rt.IdTerminalDestino = td.IdTerminal
                  WHERE r.IdUsuario = :user_id
                  ORDER BY r.FechaCreacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cancela una reserva.
     * @param int $reserva_id
     * @param int $user_id
     * @return bool
     */
    public function cancelReservation($reserva_id, $user_id) {
        $query = "UPDATE " . $this->reserva_table . " SET Estado = 'Cancelada' WHERE IdReserva = :reserva_id AND IdUsuario = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al cancelar reserva: " . $e->getMessage());
            return false;
        }
    }
}
?>