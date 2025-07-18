<?php
header('Content-Type: application/json');

function sendResponse($data = [], $message = "Operación exitosa", $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

function sendError($message = "Error en la operación", $statusCode = 400) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit();
}

function validateRequiredFields(array $requiredFields, string $method = 'POST') {
    $inputData = ($method === 'POST') ? $_POST : $_GET;
    $missingFields = [];
    $data = [];

    foreach ($requiredFields as $field) {
        if (!isset($inputData[$field]) || (is_string($inputData[$field]) && empty(trim($inputData[$field])))) {
            $missingFields[] = $field;
        } else {
            $data[$field] = is_string($inputData[$field]) ? htmlspecialchars(strip_tags(trim($inputData[$field]))) : $inputData[$field];
        }
    }

    if (!empty($missingFields)) {
        sendError("Faltan campos requeridos: " . implode(', ', $missingFields), 400);
    }
    return $data;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>