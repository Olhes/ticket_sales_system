<?php
session_start();
require_once 'backend/config/databases.php';

echo "<h2>Debug Information</h2>";

// Database connection test
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>✅ Database connection: OK</p>";
    
    // Check users in database
    $result = $pdo->query("SELECT IdUsuario, Nombre, Correo FROM Usuario LIMIT 5");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Users in database:</h3>";
    if (empty($users)) {
        echo "<p>❌ No users found in database. Run setup.php first.</p>";
    } else {
        echo "<ul>";
        foreach ($users as $user) {
            echo "<li>ID: {$user['IdUsuario']}, Name: {$user['Nombre']}, Email: {$user['Correo']}</li>";
        }
        echo "</ul>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

// Session information
echo "<h3>Session Information:</h3>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

if (empty($_SESSION)) {
    echo "<p>❌ No session data found</p>";
} else {
    echo "<p>✅ Session data:</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
}

// Test authentication endpoints
echo "<h3>Test Links:</h3>";
echo "<ul>";
echo "<li><a href='setup.php'>Run Setup</a></li>";
echo "<li><a href='frontend/form.php'>Login/Register Form</a></li>";
echo "<li><a href='backend/api/auth/check.php'>Check Auth Status</a></li>";
echo "<li><a href='frontend/dashboard.php'>Dashboard</a></li>";
echo "</ul>";
?>