<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema de Buses</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar admin-sidebar">
            <div class="sidebar-header">
                <h2>ADMIN PANEL</h2>
                <span class="user-name" id="userName">Administrador</span>
                <span class="user-role">Admin</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" data-section="dashboard" class="active"><i class='bx bx-home'></i> Dashboard</a></li>
                <li><a href="#" data-section="users"><i class='bx bx-user'></i> Usuarios</a></li>
                <li><a href="#" data-section="companies"><i class='bx bx-building'></i> Empresas</a></li>
                <li><a href="#" data-section="terminals"><i class='bx bx-map-pin'></i> Terminales</a></li>
                <li><a href="#" data-section="buses"><i class='bx bx-bus'></i> Buses</a></li>
                <li><a href="#" data-section="drivers"><i class='bx bx-user-circle'></i> Conductores</a></li>
                <li><a href="#" data-section="routes"><i class='bx bx-map'></i> Rutas</a></li>
                <li><a href="#" data-section="schedules"><i class='bx bx-time'></i> Horarios</a></li>
                <li><a href="#" data-section="reservations"><i class='bx bx-ticket'></i> Reservas</a></li>
                <li><a href="#" data-section="reports"><i class='bx bx-chart'></i> Reportes</a></li>
                <li><a href="dashboard.php"><i class='bx bx-user-check'></i> Vista Usuario</a></li>
                <li><a href="#" id="logoutBtn"><i class='bx bx-log-out'></i> Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <div class="section-header">
                    <h1>Panel de Administración</h1>
                    <p>Gestiona todo el sistema de buses desde aquí</p>
                </div>
                
                <div class="admin-stats-grid">
                    <div class="stat-card">
                        <i class='bx bx-user'></i>
                        <div class="stat-info">
                            <h3 id="totalUsers">0</h3>
                            <p>Usuarios Registrados</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-bus'></i>
                        <div class="stat-info">
                            <h3 id="totalBuses">0</h3>
                            <p>Buses Activos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-map'></i>
                        <div class="stat-info">
                            <h3 id="totalRoutes">0</h3>
                            <p>Rutas Disponibles</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-ticket'></i>
                        <div class="stat-info">
                            <h3 id="totalReservations">0</h3>
                            <p>Reservas Totales</p>
                        </div>
                    </div>
                </div>

                <div class="recent-activity">
                    <h3>Actividad Reciente</h3>
                    <div class="activity-list" id="recentActivity">
                        <!-- Activity items will be loaded here -->
                    </div>
                </div>
            </section>

            <!-- Users Section -->
            <section id="users" class="content-section">
                <div class="section-header">
                    <h1>Gestión de Usuarios</h1>
                    <button class="btn-primary" id="addUserBtn">Agregar Usuario</button>
                </div>
                <div class="table-container">
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Companies Section -->
            <section id="companies" class="content-section">
                <div class="section-header">
                    <h1>Empresas de Transporte</h1>
                    <button class="btn-primary" id="addCompanyBtn">Agregar Empresa</button>
                </div>
                <div class="table-container">
                    <table id="companiesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>RUC</th>
                                <th>Buses</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Terminals Section -->
            <section id="terminals" class="content-section">
                <div class="section-header">
                    <h1>Terminales</h1>
                    <button class="btn-primary" id="addTerminalBtn">Agregar Terminal</button>
                </div>
                <div class="table-container">
                    <table id="terminalsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Buses Section -->
            <section id="buses" class="content-section">
                <div class="section-header">
                    <h1>Gestión de Buses</h1>
                    <button class="btn-primary" id="addBusBtn">Agregar Bus</button>
                </div>
                <div class="table-container">
                    <table id="busesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Placa</th>
                                <th>Tipo</th>
                                <th>Capacidad</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Drivers Section -->
            <section id="drivers" class="content-section">
                <div class="section-header">
                    <h1>Conductores</h1>
                    <button class="btn-primary" id="addDriverBtn">Agregar Conductor</button>
                </div>
                <div class="table-container">
                    <table id="driversTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Licencia</th>
                                <th>Vencimiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Routes Section -->
            <section id="routes" class="content-section">
                <div class="section-header">
                    <h1>Rutas</h1>
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
                                <th>Conductor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Reservations Section -->
            <section id="reservations" class="content-section">
                <div class="section-header">
                    <h1>Reservas</h1>
                    <div class="filter-controls">
                        <select id="statusFilter">
                            <option value="">Todos los estados</option>
                            <option value="Confirmada">Confirmada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                        <input type="date" id="dateFilter">
                    </div>
                </div>
                <div class="table-container">
                    <table id="reservationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Pasajero</th>
                                <th>Ruta</th>
                                <th>Fecha Viaje</th>
                                <th>Asiento</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <!-- Reports Section -->
            <section id="reports" class="content-section">
                <div class="section-header">
                    <h1>Reportes</h1>
                </div>
                <div class="reports-grid">
                    <div class="report-card">
                        <h3>Ventas por Mes</h3>
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="report-card">
                        <h3>Rutas Más Populares</h3>
                        <canvas id="routesChart"></canvas>
                    </div>
                    <div class="report-card">
                        <h3>Ocupación de Buses</h3>
                        <div class="occupancy-stats" id="occupancyStats"></div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modals -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar/Editar Usuario</h2>
            <form id="userForm">
                <input type="hidden" id="userId">
                <div class="form-group">
                    <label for="userName">Nombre:</label>
                    <input type="text" id="userName" required>
                </div>
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="email" id="userEmail" required>
                </div>
                <div class="form-group">
                    <label for="userRole">Rol:</label>
                    <select id="userRole" required>
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="userPassword">Contraseña:</label>
                    <input type="password" id="userPassword">
                    <small>Dejar vacío para mantener la contraseña actual</small>
                </div>
                <button type="submit" class="btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <script type="module" src="js/admin-dashboard.js"></script>
</body>
</html>