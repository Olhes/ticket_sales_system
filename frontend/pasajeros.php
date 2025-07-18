<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Datos del Pasajero</title>
    <link rel="stylesheet" href="./css/pasajeros.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="Logo">PakaBussines</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About us</a></li>
                <li><a href="form.php">Login</a></li>
                <li><a href="index.php">Info</a></li>
            </ul>
        </nav>
        <a href="form.php" class="get-started1">Get Started</a>
    </header>

    <main class="passenger-details-container">
        <h1>Datos del Pasajero</h1>
        <p class="subtitle">Por favor, ingresa los detalles para cada pasajero.</p>

        <?php
        // Recuperar datos de la URL (enviados desde seat_selection.php)
        $from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : 'N/A';
        $destination = isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'N/A';
        
        // *** CAMBIOS CLAVE AQUÍ: Recuperar nombres de variables correctos ***
        $fecha_salida = isset($_GET['fecha_salida']) ? htmlspecialchars($_GET['fecha_salida']) : 'N/A';
        $hora_salida = isset($_GET['hora_salida']) ? htmlspecialchars($_GET['hora_salida']) : 'N/A';
        $empresa = isset($_GET['empresa']) ? htmlspecialchars($_GET['empresa']) : 'N/A';
        $tipo_bus = isset($_GET['tipo_bus']) ? htmlspecialchars($_GET['tipo_bus']) : 'N/A';
        
        $travelers = isset($_GET['travelers']) ? (int)htmlspecialchars($_GET['travelers']) : 1;
        $selected_seats_str = isset($_GET['selected_seats']) ? htmlspecialchars($_GET['selected_seats']) : '';
        $selected_seats_array = explode(',', $selected_seats_str);

        // Mostrar un resumen de la reserva actual
        echo "<div class='booking-summary'>";
        echo "<h3>Resumen de la Reserva</h3>";
        echo "<p><strong>Ruta:</strong> $from a $destination</p>";
        // *** CAMBIO: Mostrar fecha y hora por separado ***
        echo "<p><strong>Fecha/Hora:</strong> $fecha_salida a las $hora_salida</p>";
        // *** CAMBIO: Mostrar Empresa y Tipo de Bus ***
        echo "<p><strong>Empresa:</strong> $empresa</p>";
        echo "<p><strong>Tipo de Bus:</strong> $tipo_bus</p>";

        echo "<p><strong>Cantidad de Pasajeros:</strong> $travelers</p>";
        echo "<p><strong>Asientos Seleccionados:</strong> " . ($selected_seats_str ?: 'Ninguno') . "</p>";
        echo "</div>";
        ?>

        <form class="passenger-form" action="boleta.php" method="GET">
            <input type="hidden" name="from" value="<?php echo $from; ?>">
            <input type="hidden" name="destination" value="<?php echo $destination; ?>">
            
            <input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida; ?>">
            <input type="hidden" name="hora_salida" value="<?php echo $hora_salida; ?>">
            <input type="hidden" name="empresa" value="<?php echo $empresa; ?>">
            <input type="hidden" name="tipo_bus" value="<?php echo $tipo_bus; ?>">

            <input type="hidden" name="travelers" value="<?php echo $travelers; ?>">
            <input type="hidden" name="selected_seats" value="<?php echo $selected_seats_str; ?>">

            <?php for ($i = 1; $i <= $travelers; $i++): ?>
                <div class="passenger-card">
                    <h2>Pasajero <?php echo $i; ?> (Asiento: <?php echo htmlspecialchars($selected_seats_array[$i-1] ?? 'N/A'); ?>)</h2>
                    <div class="form-group">
                        <label for="nombres_<?php echo $i; ?>">Nombres:</label>
                        <input type="text" id="nombres_<?php echo $i; ?>" name="nombres_<?php echo $i; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos_<?php echo $i; ?>">Apellidos:</label>
                        <input type="text" id="apellidos_<?php echo $i; ?>" name="apellidos_<?php echo $i; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni_<?php echo $i; ?>">DNI:</label>
                        <input type="text" id="dni_<?php echo $i; ?>" name="dni_<?php echo $i; ?>" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="edad_<?php echo $i; ?>">Edad:</label>
                        <input type="number" id="edad_<?php echo $i; ?>" name="edad_<?php echo $i; ?>" min="0" max="120">
                    </div>
                    <div class="form-group">
                        <label for="telefono_<?php echo $i; ?>">Teléfono:</label>
                        <input type="tel" id="telefono_<?php echo $i; ?>" name="telefono_<?php echo $i; ?>" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label for="correo_<?php echo $i; ?>">Correo Electrónico:</label>
                        <input type="email" id="correo_<?php echo $i; ?>" name="correo_<?php echo $i; ?>">
                    </div>
                </div>
            <?php endfor; ?>

            <button type="submit" class="confirm-button">Confirmar Reserva y Pagar</button>
            <a href="seat_selection.php?<?php echo http_build_query($_GET); ?>" class="back-button">Volver a Asientos</a>
        </form>
    </main>
</body>
</html>