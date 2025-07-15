<?php
// utils/helpers.php
//deinimos funciones de ayuda(para respuestas json)

/**
 * Envía una respuesta JSON de éxito.
 * @param array $data Los datos a incluir en la respuesta.
 * @param string $message Mensaje opcional.
 * @param int $statusCode Código de estado HTTP.
 */
function sendResponse($data = [], $message = "Operación exitosa", $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
    exit(); // Termina la ejecución del script
}

/**
 * Envía una respuesta JSON de error.
 * @param string $message Mensaje de error.
 * @param int $statusCode Código de estado HTTP.
 */
function sendError($message = "Error en la operación", $statusCode = 400) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit(); // Termina la ejecución del script
}

/**
 * Valida que los datos POST/GET estén presentes.
 * @param array $requiredFields Un array de nombres de campos que son requeridos.
 * @param string $method 'POST' o 'GET'.
 * @return array Los datos validados y limpiados.
 */
function validateRequiredFields(array $requiredFields, string $method = 'POST') {
    $inputData = ($method === 'POST') ? $_POST : $_GET;
    $missingFields = [];
    $data = [];

    foreach ($requiredFields as $field) {
        if (!isset($inputData[$field]) || (is_string($inputData[$field]) && empty(trim($inputData[$field])))) {
            $missingFields[] = $field;
        } else {
            // Limpiar y sanear el input. Puedes expandir esto con filtros más específicos.
            $data[$field] = is_string($inputData[$field]) ? htmlspecialchars(strip_tags(trim($inputData[$field]))) : $inputData[$field];
        }
    }

    if (!empty($missingFields)) {
        sendError("Faltan campos requeridos: " . implode(', ', $missingFields), 400);
    }
    return $data;
}

// Inicia la sesión PHP si aún no está iniciada (necesario para la autenticación basada en sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si el usuario está autenticado
 * @return bool
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Obtiene el ID del usuario actual
 * @return int|null
 */
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}
?>