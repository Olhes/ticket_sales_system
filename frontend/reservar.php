<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar y Reservar Pasajes</title>
    <link rel="stylesheet" href="./css/reservar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

    <section class="hero-section">
        <div class="hero-content">
            <h1>¡Encuentra tu Pasaje Ideal!</h1>
            <div class="search-form-container">
                <form class="search-form" action="seat.php" method="GET">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="from">Origen:</label>
                            <select id="from" name="from" required>
                                <option value="">Selecciona Origen</option>
                                <option value="Tacna">Tacna</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Lima">Lima</option>
                                <option value="Cusco">Cusco</option>
                                <option value="Puno">Puno</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="destination">Destino:</label>
                            <select id="destination" name="destination" required>
                                <option value="">Selecciona Destino</option>
                                <option value="Tacna">Tacna</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Lima">Lima</option>
                                <option value="Cusco">Cusco</option>
                                <option value="Puno">Puno</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="empresa">Empresa:</label>
                            <select id="empresa" name="empresa">
                                <option value="">Cualquier Empresa</option>
                                <option value="Cruz del Sur">Cruz del Sur</option>
                                <option value="Oltursa">Oltursa</option>
                                <option value="Civa">Civa</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="tipo_bus">Tipo de Bus:</label>
                            <select id="tipo_bus" name="tipo_bus">
                                <option value="">Cualquier Tipo</option>
                                <option value="Común">Común</option>
                                <option value="Cómodo">Cómodo</option>
                                <option value="Lujo">Lujo</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="fecha_salida">Fecha Salida:</label>
                            <input type="date" id="fecha_salida" name="fecha_salida" required>
                        </div>

                        <div class="input-group">
                            <label for="hora_salida">Hora Salida:</label>
                            <input type="time" id="hora_salida" name="hora_salida">
                        </div>

                        <button type="submit" class="search-button">Buscar Horarios</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Inicializar Flatpickr para el campo de fecha
        flatpickr("#fecha_salida", {
            dateFormat: "Y-m-d",
            minDate: "today" // No permite seleccionar fechas pasadas
        });
    </script>
</body>
</html>