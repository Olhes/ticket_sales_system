<?php
// classes/Route.php
//Clase para la entidad Ruta
class Route {
    private $conn;
    private $table_name = "routes"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todas las rutas.
     * @return array Lista de rutas.
     */
    public function getAll() {
        $query = "SELECT id, origin, destination, distance, estimated_time FROM " . $this->table_name . " ORDER BY origin, destination";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una ruta por su ID.
     * @param int $id
     * @return array|false Datos de la ruta o false si no se encuentra.
     */
    public function getById($id) {
        $query = "SELECT id, origin, destination, distance, estimated_time FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Métodos CRUD adicionales (create, update, delete) irían aquí si los necesitas para administración.
}
?>