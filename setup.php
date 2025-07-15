<?php
// Simple setup script to initialize the database
require_once 'backend/config/databases.php';

try {
    // Connect to MySQL server (without database)
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Configurando Base de Datos...</h2>";
    
    // Drop database if exists and recreate
    $pdo->exec("DROP DATABASE IF EXISTS " . DB_NAME);
    echo "<p>✓ Base de datos anterior eliminada (si existía)</p>";
    
    // Read and execute database schema
    $schema = file_get_contents('backend/db/database.sql');
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                // Ignore errors for statements that might already exist
                if (strpos($e->getMessage(), 'already exists') === false) {
                    echo "<p>Warning: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
    
    echo "<p>✓ Esquema de base de datos creado</p>";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read and execute sample data
    $sampleData = file_get_contents('backend/db/sample_data.sql');
    $statements = explode(';', $sampleData);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^(USE|--)/i', $statement)) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                echo "<p>Warning inserting data: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    echo "<p>✓ Datos de ejemplo insertados</p>";
    
    // Verify data was inserted
    $result = $pdo->query("SELECT COUNT(*) as count FROM Usuario");
    $userCount = $result->fetch()['count'];
    
    $result = $pdo->query("SELECT COUNT(*) as count FROM Ruta");
    $routeCount = $result->fetch()['count'];
    
    echo "<p>✓ Usuarios creados: $userCount</p>";
    echo "<p>✓ Rutas creadas: $routeCount</p>";
    
    echo "<h3>¡Configuración completada!</h3>";
    echo "<p>Ahora puedes acceder a la aplicación:</p>";
    echo "<ul>";
    echo "<li><a href='frontend/index.php'>Página Principal</a></li>";
    echo "<li><a href='frontend/form.php'>Login/Registro</a></li>";
    echo "<li><a href='frontend/dashboard.php'>Dashboard</a> (requiere login)</li>";
    echo "</ul>";
    
    echo "<h4>Usuarios de prueba:</h4>";
    echo "<h5>👤 Usuario Normal:</h5>";
    echo "<p>Email: <strong>juan@example.com</strong> | Password: <strong>password</strong></p>";
    echo "<p>Email: <strong>maria@example.com</strong> | Password: <strong>password</strong></p>";
    echo "<h5>🔧 Administrador:</h5>";
    echo "<p>Email: <strong>admin@example.com</strong> | Password: <strong>password</strong></p>";
    echo "<p>O puedes registrar nuevos usuarios o usar login social (Google/GitHub).</p>";
    
} catch (PDOException $e) {
    echo "<h3>Error en la configuración:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Asegúrate de que:</p>";
    echo "<ul>";
    echo "<li>MySQL esté ejecutándose</li>";
    echo "<li>Las credenciales en backend/config/databases.php sean correctas</li>";
    echo "<li>El usuario tenga permisos para crear bases de datos</li>";
    echo "</ul>";
}
?>