<?php
// classes/Route.php
//Clase para la entidad Ruta
class Route {
    private $conn;
    private $table_name = "Ruta";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todas las rutas con información de terminales.
     * @return array Lista de rutas.
     */
    public function getAll() {
        $query = "SELECT r.IdRuta, r.DistanciaKM, 
                         tor.Nombre as origen, td.Nombre as destino
                  FROM " . $this->table_name . " r
                  JOIN Terminal tor ON r.IdTerminalOrigen = tor.IdTerminal
                  JOIN Terminal td ON r.IdTerminalDestino = td.IdTerminal
                  ORDER BY tor.Nombre, td.Nombre";
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
        $query = "SELECT r.IdRuta, r.IdTerminalOrigen, r.IdTerminalDestino, r.DistanciaKM,
                         tor.Nombre as origen, td.Nombre as destino
                  FROM " . $this->table_name . " r
                  JOIN Terminal tor ON r.IdTerminalOrigen = tor.IdTerminal
                  JOIN Terminal td ON r.IdTerminalDestino = td.IdTerminal
                  WHERE r.IdRuta = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva ruta.
     */
    public function create($origen_id, $destino_id, $distancia) {
        $query = "INSERT INTO " . $this->table_name . " (IdTerminalOrigen, IdTerminalDestino, DistanciaKM) VALUES (:origen, :destino, :distancia)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':origen', $origen_id);
        $stmt->bindParam(':destino', $destino_id);
        $stmt->bindParam(':distancia', $distancia);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear ruta: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los terminales.
     */
    public function getTerminals() {
        $query = "SELECT IdTerminal, Nombre, Direccion FROM Terminal ORDER BY Nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>