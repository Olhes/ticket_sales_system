<?php
require_once '../../utils/helpers.php';
require_once '../../classes/Database.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

$data = validateRequiredFields(['token']);

// Verificar token de Google
$google_user = verifyGoogleToken($data['token']);
if (!$google_user) {
    sendError('Token de Google inválido', 401);
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendError('Error de conexión a la base de datos', 500);
}

$user = new User($db);

// Buscar usuario por Google ID
$userData = $user->findByGoogleId($google_user['id']);

if (!$userData) {
    // Buscar por email
    $userData = $user->findByEmail($google_user['email']);
    
    if (!$userData) {
        // Crear nuevo usuario
        if ($user->createSocialUser($google_user['name'], $google_user['email'], 'google', $google_user['id'])) {
            $userData = $user->findByEmail($google_user['email']);
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
], 'Login con Google exitoso');

/**
 * Verifica el token de Google
 */
function verifyGoogleToken($token) {
    // En producción, deberías verificar el token con Google API
    // Por ahora, simulamos la respuesta para desarrollo
    
    // Decodificar JWT básico (solo para desarrollo)
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return false;
    }
    
    try {
        $payload = json_decode(base64_decode($parts[1]), true);
        
        // Simular datos de Google para desarrollo
        return [
            'id' => $payload['sub'] ?? 'google_' . time(),
            'email' => $payload['email'] ?? 'test@gmail.com',
            'name' => $payload['name'] ?? 'Usuario Google'
        ];
    } catch (Exception $e) {
        return false;
    }
}
?>