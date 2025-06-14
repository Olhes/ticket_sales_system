<?php
// classes/Bus.php
//Modelo para la entidad de bus
class Bus {
    private $conn;
    private $table_name = "buses"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene un bus por su ID.
     * @param int $id
     * @return array|false Datos del bus o false si no se encuentra.
     */
    public function getById($id) {
        $query = "SELECT id, plate_number, capacity, model FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los buses (útil para administradores).
     * @return array Lista de buses.
     */
    public function getAll() {
        $query = "SELECT id, plate_number, capacity, model FROM " . $this->table_name . " ORDER BY plate_number";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Métodos CRUD adicionales (create, update, delete) irían aquí si los necesitas para administración.
}
?>