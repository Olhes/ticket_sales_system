<?php
// classes/Auth.php
//Clase para la utenticacion de usuarios
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php'; // Auth necesita User para buscar usuarios

class Auth {
    private $conn;
    private $user;

    public function __construct($db) {
        $this->conn = $db;
        $this->user = new User($db);
    }

    /**
     * Registra un nuevo usuario.
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool True si el registro fue exitoso, false en caso contrario.
     */
    public function register($name, $email, $password, $role = 'student') {
        if ($this->user->findByEmail($email)) {
            return false; // Usuario con ese email ya existe
        }
        return $this->user->create($name, $email, password_hash($password, PASSWORD_BCRYPT));
    }

    /**
     * Inicia sesión de un usuario.
     * @param string $email
     * @param string $password
     * @return array|false Datos del usuario (sin contraseña) si el inicio de sesión es exitoso, false en caso contrario.
     */
    public function login($email, $password) {
        $user_data = $this->user->findByEmail($email);

        if ($user_data && password_verify($password, $user_data['password'])) {
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_email'] = $user_data['email'];
            $_SESSION['user_role'] = $user_data['role'];

            unset($user_data['password']); // No enviar la contraseña al cliente
            return $user_data;
        }
        return false; // Credenciales inválidas
    }

    /**
     * Verifica si el usuario está autenticado.
     * @return bool True si está autenticado, false en caso contrario.
     */
    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Obtiene los datos básicos del usuario autenticado.
     * @return array|false Datos del usuario o false si no está autenticado.
     */
    public function getAuthenticatedUser() {
        if ($this->isAuthenticated()) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'],
                'role' => $_SESSION['user_role']
            ];
        }
        return false;
    }

    /**
     * Verifica si el usuario autenticado tiene un rol específico.
     * @param string $role El rol a verificar (ej. 'admin').
     * @return bool True si tiene el rol, false en caso contrario.
     */
    public function hasRole($role) {
        if ($this->isAuthenticated()) {
            return $_SESSION['user_role'] === $role;
        }
        return false;
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout() {
        session_unset();
        session_destroy();
    }
}
?>