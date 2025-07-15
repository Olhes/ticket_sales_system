<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Buses</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>BUSES PAKA</h2>
                <span class="user-name" id="userName">Usuario</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" data-section="home" class="active"><i class='bx bx-home'></i> Inicio</a></li>
                <li><a href="#" data-section="routes"><i class='bx bx-map'></i> Rutas</a></li>
                <li><a href="#" data-section="schedules"><i class='bx bx-time'></i> Horarios</a></li>
                <li><a href="#" data-section="tickets"><i class='bx bx-ticket'></i> Mis Boletos</a></li>
                <li><a href="#" data-section="booking"><i class='bx bx-plus-circle'></i> Reservar</a></li>
                <li id="adminLink" style="display: none;"><a href="admin-dashboard.php"><i class='bx bx-cog'></i> Panel Admin</a></li>
                <li><a href="#" id="logoutBtn"><i class='bx bx-log-out'></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Home Section -->
            <section id="home" class="content-section active">
                <div class="section-header">
                    <h1>Bienvenido al Sistema de Buses</h1>
                    <p>Gestiona tus reservas y explora nuestras rutas disponibles</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class='bx bx-map'></i>
                        <div class="stat-info">
                            <h3 id="totalRoutes">0</h3>
                            <p>Rutas Disponibles</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-time'></i>
                        <div class="stat-info">
                            <h3 id="totalSchedules">0</h3>
                            <p>Horarios Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-ticket'></i>
                        <div class="stat-info">
                            <h3 id="myTickets">0</h3>
                            <p>Mis Boletos</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Routes Section -->
            <section id="routes" class="content-section">
                <div class="section-header">
                    <h1>Rutas Disponibles</h1>
                    <button class="btn-primary" id="addRouteBtn">Agregar Ruta</button>
                </div>
                <div class="table-container">
                    <table id="routesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Distancia (KM)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Schedules Section -->
            <section id="schedules" class="content-section">
                <div class="section-header">
                    <h1>Horarios</h1>
                    <button class="btn-primary" id="addScheduleBtn">Agregar Horario</button>
                </div>
                <div class="table-container">
                    <table id="schedulesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ruta</th>
                                <th>Fecha</th>
                                <th>Hora Salida</th>
                                <th>Precio</th>
                                <th>Bus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Tickets Section -->
            <section id="tickets" class="content-section">
                <div class="section-header">
                    <h1>Mis Boletos</h1>
                </div>
                <div class="tickets-grid" id="ticketsGrid">
                    <!-- Tickets will be loaded here -->
                </div>
            </section>

            <!-- Booking Section -->
            <section id="booking" class="content-section">
                <div class="section-header">
                    <h1>Reservar Boleto</h1>
                </div>
                <div class="booking-form">
                    <form id="bookingForm">
                        <div class="form-group">
                            <label for="routeSelect">Ruta:</label>
                            <select id="routeSelect" required>
                                <option value="">Seleccionar ruta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="scheduleSelect">Horario:</label>
                            <select id="scheduleSelect" required>
                                <option value="">Seleccionar horario</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="passengerName">Nombre del Pasajero:</label>
                            <input type="text" id="passengerName" required>
                        </div>
                        <div class="form-group">
                            <label for="passengerDNI">DNI:</label>
                            <input type="text" id="passengerDNI" required>
                        </div>
                        <div class="form-group">
                            <label for="seatNumber">Número de Asiento:</label>
                            <input type="text" id="seatNumber" required>
                        </div>
                        <button type="submit" class="btn-primary">Reservar Boleto</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Modals -->
    <div id="routeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar/Editar Ruta</h2>
            <form id="routeForm">
                <input type="hidden" id="routeId">
                <div class="form-group">
                    <label for="originTerminal">Terminal Origen:</label>
                    <select id="originTerminal" required></select>
                </div>
                <div class="form-group">
                    <label for="destinationTerminal">Terminal Destino:</label>
                    <select id="destinationTerminal" required></select>
                </div>
                <div class="form-group">
                    <label for="distance">Distancia (KM):</label>
                    <input type="number" id="distance" step="0.01" required>
                </div>
                <button type="submit" class="btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <script type="module" src="js/dashboard.js"></script>
</body>
</html>