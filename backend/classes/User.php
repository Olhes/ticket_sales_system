<?php
// classes/User.php
//Clase para entidad Usuario
class User {
    private $conn;
    private $table_name = "Usuario"; // Asegúrate que coincida con tu tabla SQL

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Crea un nuevo usuario.
     * @param string $name
     * @param string $email
     * @param string $password_hash (ya hasheada)
     * @return bool True si la creación fue exitosa.
     */
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

    /**
     * Busca un usuario por su email.
     * @param string $email
     * @return array|false Los datos del usuario o false si no se encuentra.
     */
    public function findByEmail($email) {
        $query = "SELECT IdUsuario, Nombre, Correo, Contraseña, Rol FROM " . $this->table_name . " WHERE Correo = :email LIMIT 0,1";
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
        $query = "SELECT IdUsuario, Nombre, Correo, Rol FROM " . $this->table_name . " WHERE IdUsuario = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca un usuario por Google ID.
     * @param string $google_id
     * @return array|false Los datos del usuario o false si no se encuentra.
     */
    public function findByGoogleId($google_id) {
        $query = "SELECT IdUsuario, Nombre, Correo, Rol FROM " . $this->table_name . " WHERE GoogleId = :google_id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':google_id', $google_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca un usuario por GitHub ID.
     * @param string $github_id
     * @return array|false Los datos del usuario o false si no se encuentra.
     */
    public function findByGithubId($github_id) {
        $query = "SELECT IdUsuario, Nombre, Correo, Rol FROM " . $this->table_name . " WHERE GithubId = :github_id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':github_id', $github_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un usuario con login social.
     * @param string $name
     * @param string $email
     * @param string $provider ('google' o 'github')
     * @param string $provider_id
     * @return bool True si la creación fue exitosa.
     */
    public function createSocialUser($name, $email, $provider, $provider_id) {
        $field = $provider === 'google' ? 'GoogleId' : 'GithubId';
        $query = "INSERT INTO " . $this->table_name . " (Nombre, Correo, Contraseña, $field) VALUES (:name, :email, '', :provider_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':provider_id', $provider_id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear usuario social: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los usuarios (solo para admin).
     * @return array Lista de usuarios.
     */
    public function getAll() {
        $query = "SELECT IdUsuario, Nombre, Correo, Rol, FechaCreacion FROM " . $this->table_name . " ORDER BY FechaCreacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si un usuario es admin.
     * @param int $user_id
     * @return bool
     */
    public function isAdmin($user_id) {
        $query = "SELECT Rol FROM " . $this->table_name . " WHERE IdUsuario = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['Rol'] === 'admin';
    }
}
?>