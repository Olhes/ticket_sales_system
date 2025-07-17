<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Asientos</title>
    <link rel="stylesheet" href="./css/seat.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <main class="seat-selection-container">
        <h1>Selecciona tus Asientos</h1>

        <?php
        // Recuperar parámetros de la URL desde reservar.php
        $from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : 'N/A';
        $destination = isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'N/A';
        $fecha_salida = isset($_GET['fecha_salida']) ? htmlspecialchars($_GET['fecha_salida']) : 'N/A';
        $hora_salida = isset($_GET['hora_salida']) ? htmlspecialchars($_GET['hora_salida']) : 'N/A';
        $empresa = isset($_GET['empresa']) ? htmlspecialchars($_GET['empresa']) : 'Cualquier Empresa';
        $tipo_bus = isset($_GET['tipo_bus']) ? htmlspecialchars($_GET['tipo_bus']) : 'Cualquier Tipo';
        $num_travelers = isset($_GET['num_travelers']) ? (int)htmlspecialchars($_GET['num_travelers']) : 1;

        echo "<div class='trip-summary'>";
        echo "<h3>Resumen del Viaje</h3>";
        echo "<p><strong>Ruta:</strong> $from a $destination</p>";
        echo "<p><strong>Fecha/Hora:</strong> $fecha_salida a las $hora_salida</p>";
        echo "<p><strong>Empresa:</strong> $empresa</p>";
        echo "<p><strong>Tipo de Bus:</strong> $tipo_bus</p>";
        echo "<p><strong>Pasajeros:</strong> $num_travelers</p>";
        echo "</div>";

        $total_capacity = 40;
        $floor1_capacity = 40;
        $floor2_capacity = 0;

        if ($tipo_bus == 'Cómodo' || $tipo_bus == 'Lujo') {
            $floor1_capacity = 12;
            $floor2_capacity = 48;
            $total_capacity = $floor1_capacity + $floor2_capacity;
        }

        ?>

        <form id="seatSelectionForm" action="pasajeros.php" method="GET">
            <input type="hidden" name="from" value="<?php echo $from; ?>">
            <input type="hidden" name="destination" value="<?php echo $destination; ?>">
            <input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida; ?>">
            <input type="hidden" name="hora_salida" value="<?php echo $hora_salida; ?>">
            <input type="hidden" name="empresa" value="<?php echo $empresa; ?>">
            <input type="hidden" name="tipo_bus" value="<?php echo $tipo_bus; ?>">
            <input type="hidden" name="num_travelers" value="<?php echo $num_travelers; ?>">
            
            <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">

            <div class="seat-map-container">
                <?php if ($floor1_capacity > 0): ?>
                    <div class="floor-section">
                        <h2>Piso 1</h2>
                        <div class="seat-grid">
                            <?php for ($i = 1; $i <= $floor1_capacity; $i++): ?>
                                <?php
                                    $is_occupied = false;
                                    if ($i == 5 || $i == 12 || $i == 20) {
                                        $is_occupied = true;
                                    }
                                ?>
                                <div class="seat <?php echo $is_occupied ? 'occupied' : 'available'; ?>" data-seat-number="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($floor2_capacity > 0): ?>
                    <div class="floor-section">
                        <h2>Piso 2</h2>
                        <div class="seat-grid">
                            <?php for ($i = $floor1_capacity + 1; $i <= $total_capacity; $i++): ?>
                                <?php
                                    $is_occupied = false;
                                    if ($i == 45 || $i == 50) {
                                        $is_occupied = true;
                                    }
                                ?>
                                <div class="seat <?php echo $is_occupied ? 'occupied' : 'available'; ?>" data-seat-number="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="seat-legend">
                <div class="legend-item"><span class="seat available"></span> Disponible</div>
                <div class="legend-item"><span class="seat selected"></span> Seleccionado</div>
                <div class="legend-item"><span class="seat occupied"></span> Ocupado</div>
            </div>

            <div class="summary-actions">
                <h3>Asientos Seleccionados (<span id="selected-seats-count">0</span> de <?php echo $num_travelers; ?>)</h3>
                <p>Números: <span id="selected-seats-numbers">Ninguno</span></p>
                
                <button type="submit" id="proceedToBuy" class="action-button" disabled>Continuar a Datos del Pasajero</button>
                <a href="reservar.php" class="back-button">Volver a Búsqueda</a>
            </div>
        </form>
        </main>

    <script>
        // Pasar la cantidad de pasajeros a JavaScript para validación
        const numTravelers = <?php echo json_encode($num_travelers); ?>;
    </script>
    <script src="./js/seat_selection.js"></script>
</body>
</html>