<?php
require_once '../../utils/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Método no permitido', 405);
}

// Destruir sesión
session_destroy();

sendResponse([], 'Logout exitoso');
?>