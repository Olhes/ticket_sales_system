<?php
// utils/helpers.php
//deinimos funciones de ayuda(para respuestas json)

// Define la cabecera para que el navegador sepa que es una respuesta JSON.
header('Content-Type: application/json');

/**
 * Envía una respuesta JSON de éxito.
 * @param array $data Los datos a incluir en la respuesta.
 * @param string $message Mensaje opcional.
 * @param int $statusCode Código de estado HTTP.
 */
function sendResponse($data = [], $message = "Operación exitosa", $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => true,
        'message' => $message,
    ]);
    var_dump($data);
}

/**
 * Envía una respuesta JSON de error.
 * @param string $message Mensaje de error.
 * @param int $statusCode Código de estado HTTP.
 */
function sendError($message = "Error en la operación", $statusCode = 400) {
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
?>