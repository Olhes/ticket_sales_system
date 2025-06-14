<?php
// index.php
// Este archivo puede ser un punto de entrada simple para tu API.
require_once __DIR__ . '/utils/helpers.php';

sendResponse(['status' => 'API de Venta de Tickets Activa', 'version' => '1.0'], 'Bienvenido a la API de la Universidad.');
?>