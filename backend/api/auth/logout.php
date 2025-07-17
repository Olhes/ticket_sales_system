<?php
// api/auth/logout.php
require_once __DIR__ . '/../../utils/helpers.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_unset();
session_destroy();
sendResponse([], "Logout exitoso.");
