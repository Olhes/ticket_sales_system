<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Reserva - PakaBussines</title>
    <link rel="stylesheet" href="./css/boleta.css">
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

    <main class="boleta-container">
        <h1>¡Reserva Confirmada! 🎉</h1>
        <p class="subtitle">Aquí está el detalle de tu boleta.</p>

        <?php
        // --- Datos del Viaje (desde reservar.php y seat_selection.php) ---
        $from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : 'N/A';
        $destination = isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'N/A';
        // Ajustamos para recibir 'fecha_salida' y 'hora_salida'
        $fecha_salida = isset($_GET['fecha_salida']) ? htmlspecialchars($_GET['fecha_salida']) : 'N/A';
        $hora_salida = isset($_GET['hora_salida']) ? htmlspecialchars($_GET['hora_salida']) : 'N/A';
        $empresa = isset($_GET['empresa']) ? htmlspecialchars($_GET['empresa']) : 'N/A';
        $tipo_bus = isset($_GET['tipo_bus']) ? htmlspecialchars($_GET['tipo_bus']) : 'N/A';
        $travelers = isset($_GET['travelers']) ? (int)htmlspecialchars($_GET['travelers']) : 1;
        $selected_seats_str = isset($_GET['selected_seats']) ? htmlspecialchars($_GET['selected_seats']) : '';
        $selected_seats_array = explode(',', $selected_seats_str);

        // --- Datos de los Pasajeros (desde passenger_details.php) ---
        $passengers_data = [];
        for ($i = 1; $i <= $travelers; $i++) {
            $passengers_data[] = [
                'nombres' => isset($_GET['nombres_' . $i]) ? htmlspecialchars($_GET['nombres_' . $i]) : 'N/A',
                'apellidos' => isset($_GET['apellidos_' . $i]) ? htmlspecialchars($_GET['apellidos_' . $i]) : 'N/A',
                'dni' => isset($_GET['dni_' . $i]) ? htmlspecialchars($_GET['dni_' . $i]) : 'N/A',
                'edad' => isset($_GET['edad_' . $i]) ? htmlspecialchars($_GET['edad_' . $i]) : 'N/A',
                'telefono' => isset($_GET['telefono_' . $i]) ? htmlspecialchars($_GET['telefono_' . $i]) : 'N/A',
                'correo' => isset($_GET['correo_' . $i]) ? htmlspecialchars($_GET['correo_' . $i]) : 'N/A',
                'asiento' => $selected_seats_array[$i-1] ?? 'N/A' // Asignar asiento al pasajero correspondiente
            ];
        }

        // Simulación de costo (puedes calcularlo basado en tipo de bus, ruta, etc. en un sistema real)
        $precio_unitario = 35.00; // Ejemplo de precio
        $costo_total = $precio_unitario * $travelers;
        ?>

        <div class="boleta-section trip-details">
            <h2>Detalles del Viaje</h2>
            <p><strong>Ruta:</strong> <?php echo $from; ?> a <?php echo $destination; ?></p>
            <p><strong>Fecha y Hora de Salida:</strong> <?php echo $fecha_salida; ?> a las <?php echo $hora_salida; ?></p>
            <p><strong>Empresa:</strong> <?php echo $empresa; ?></p>
            <p><strong>Tipo de Bus:</strong> <?php echo $tipo_bus; ?></p>
            <p><strong>Cantidad de Pasajeros:</strong> <?php echo $travelers; ?></p>
            <p><strong>Asientos Seleccionados:</strong> <?php echo $selected_seats_str ?: 'Ninguno'; ?></p>
        </div>

        <div class="boleta-section passenger-details">
            <h2>Datos de los Pasajeros</h2>
            <?php foreach ($passengers_data as $index => $passenger): ?>
                <div class="passenger-item">
                    <h3>Pasajero <?php echo $index + 1; ?> (Asiento: <?php echo $passenger['asiento']; ?>)</h3>
                    <p><strong>Nombres:</strong> <?php echo $passenger['nombres']; ?></p>
                    <p><strong>Apellidos:</strong> <?php echo $passenger['apellidos']; ?></p>
                    <p><strong>DNI:</strong> <?php echo $passenger['dni']; ?></p>
                    <p><strong>Edad:</strong> <?php echo $passenger['edad']; ?></p>
                    <p><strong>Teléfono:</strong> <?php echo $passenger['telefono']; ?></p>
                    <p><strong>Correo:</strong> <?php echo $passenger['correo']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="boleta-section payment-summary">
            <h2>Resumen del Pago</h2>
            <p><strong>Precio por asiento:</strong> S/ <?php echo number_format($precio_unitario, 2); ?></p>
            <p><strong>Total de Asientos:</strong> <?php echo $travelers; ?></p>
            <p class="total-amount"><strong>Costo Total:</strong> S/ <?php echo number_format($costo_total, 2); ?></p>
            <p class="payment-info">Estado: Pagado con éxito (Simulación)</p>
            </div>

        <div class="boleta-actions">
            <a href="#" onclick="window.print()" class="print-button"><i class="fas fa-print"></i> Imprimir Boleta</a>
            <a href="index.php" class="new-search-button"><i class="fas fa-home"></i> Nueva Búsqueda</a>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> PakaBussines. Todos los derechos reservados.</p>
    </footer>
</body>
</html>