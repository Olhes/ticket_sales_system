<?php
require_once '../../../utils/helpers.php';
require_once '../../../classes/Database.php';
require_once '../../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    sendError('Acceso denegado', 403);
}

$data = validateRequiredFields(['name', 'email', 'password', 'role']);

// Validar email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    sendError('Email inválido', 400);
}

// Validar contraseña
if (strlen($data['password']) < 6) {
    sendError('La contraseña debe tener al menos 6 caracteres', 400);
}

// Validar rol
if (!in_array($data['role'], ['usuario', 'admin'])) {
    sendError('Rol inválido', 400);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);

// Verificar si el usuario ya existe
if ($user->findByEmail($data['email'])) {
    sendError('El email ya está registrado', 409);
}

// Hash de la contraseña
$password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

// Crear usuario con rol específico
try {
    $query = "INSERT INTO Usuario (Nombre, Correo, Contraseña, Rol) VALUES (:name, :email, :password, :role)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':role', $data['role']);
    
    if ($stmt->execute()) {
        sendResponse([], 'Usuario creado exitosamente');
    } else {
        sendError('Error al crear usuario', 500);
    }
} catch (PDOException $e) {
    error_log("Error al crear usuario: " . $e->getMessage());
    sendError('Error al crear usuario', 500);
}
?>