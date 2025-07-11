<?php
// classes/Database.php
//Clase para la conexion a la base de datos
require_once __DIR__ . '/../config/database.php';

class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    /**
     * Obtiene la conexión a la base de datos.
     * @return PDO|null La conexión PDO o null si falla.
     */
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            error_log("Error de conexión a la base de datos: " . $exception->getMessage());
           
            return null;
        }
        return $this->conn;
    }
}
?>