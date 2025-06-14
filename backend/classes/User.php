<?php
// classes/User.php

class User {
    private $conn;
    private $table_name = "users"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Crea un nuevo usuario.
     * @param string $name
     * @param string $email
     * @param string $password_hash (ya hasheada)
     * @param string $role
     * @return bool True si la creación fue exitosa.
     */
    public function create($name, $email, $password_hash, $role = 'student') {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':role', $role);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca un usuario por su email.
     * @param string $email
     * @return array|false Los datos del usuario o false si no se encuentra.
     */
    public function findByEmail($email) {
        $query = "SELECT id, name, email, password, role FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca un usuario por su ID.
     * @param int $id
     * @return array|false Los datos del usuario o false si no se encuentra.
     */
    public function getById($id) {
        $query = "SELECT id, name, email, role FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>