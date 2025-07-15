<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['code']);

// Intercambiar código por token de acceso
$github_user = getGithubUser($data['code']);
if (!$github_user) {
    sendError('Error al autenticar con GitHub', 401);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);

// Buscar usuario por GitHub ID
$userData = $user->findByGithubId($github_user['id']);

if (!$userData) {
    // Buscar por email
    $userData = $user->findByEmail($github_user['email']);
    
    if (!$userData) {
        // Crear nuevo usuario
        if ($user->createSocialUser($github_user['name'], $github_user['email'], 'github', $github_user['id'])) {
            $userData = $user->findByEmail($github_user['email']);
        } else {
            sendError('Error al crear usuario', 500);
        }
    }
}

// Iniciar sesión
$_SESSION['user_id'] = $userData['IdUsuario'];
$_SESSION['user_name'] = $userData['Nombre'];
$_SESSION['user_email'] = $userData['Correo'];
$_SESSION['user_role'] = $userData['Rol'];

sendResponse([
    'user' => [
        'id' => $userData['IdUsuario'],
        'name' => $userData['Nombre'],
        'email' => $userData['Correo'],
        'role' => $userData['Rol']
    ]
], 'Login con GitHub exitoso');

/**
 * Obtiene información del usuario de GitHub
 */
function getGithubUser($code) {
    // En producción, deberías hacer las llamadas reales a GitHub API
    // Por ahora, simulamos la respuesta para desarrollo
    
    // Simular datos de GitHub para desarrollo
    return [
        'id' => 'github_' . time(),
        'email' => 'test@github.com',
        'name' => 'Usuario GitHub'
    ];
}
?>