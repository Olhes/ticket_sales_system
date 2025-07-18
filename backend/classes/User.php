<?php
class User {
    private $conn;
    private $table_name = "Usuario";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name, $email, $password_hash) {
        $query = "INSERT INTO " . $this->table_name . " (Nombre, Correo, Contraseña) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    public function findByEmail($email) {
        $query = "SELECT IdUsuario, Nombre, Correo, Contraseña, Rol FROM " . $this->table_name . " WHERE Correo = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && !isset($user['Rol'])) {
            $user['Rol'] = 'user';
        }
        return $user;
    }

    public function getById($id) {
        $query = "SELECT id, name, email, role FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>