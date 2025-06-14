<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Venta de Tickets de Bus</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Venta de Tickets de Bus - Frontend Demo</h1>
        <p>Este es un frontend básico para probar la API PHP.</p>

        <div id="messageArea" class="message" style="display:none;"></div>

        <h2>Autenticación</h2>
        <form id="registerForm">
            <h3>Registrar</h3>
            <label for="regName">Nombre:</label>
            <input type="text" id="regName" name="name" required><br>
            <label for="regEmail">Email:</label>
            <input type="email" id="regEmail" name="email" required><br>
            <label for="regPassword">Contraseña:</label>
            <input type="password" id="regPassword" name="password" required><br>
            <button type="submit">Registrar</button>
        </form>

        <form id="loginForm">
            <h3>Iniciar Sesión</h3>
            <label for="loginEmail">Email:</label>
            <input type="email" id="loginEmail" name="email" required><br>
            <label for="loginPassword">Contraseña:</label>
            <input type="password" id="loginPassword" name="password" required><br>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <button id="logoutBtn" style="display: none;">Cerrar Sesión</button>
        <p id="loggedInUser" style="display: none;">Sesión de: <span id="userEmailDisplay"></span> (<span id="userRoleDisplay"></span>)</p>

        <hr>

        <h2>Buscar Horarios y Reservar</h2>
        <form id="searchScheduleForm" style="display: none;">
            <h3>Buscar Horarios</h3>
            <label for="searchRoute">ID de Ruta (ej. 1):</label>
            <input type="number" id="searchRoute" name="route_id" required><br>
            <label for="searchDate">Fecha (YYYY-MM-DD):</label>
            <input type="date" id="searchDate" name="date" required><br>
            <button type="submit">Buscar Horarios</button>
        </form>

        <div id="schedulesResult" class="data-display" style="display: none;">
            <h4>Horarios Disponibles:</h4>
            <ul id="schedulesList">
                </ul>
        </div>

        <form id="bookTicketForm" style="display: none;">
            <h3>Reservar Ticket</h3>
            <label for="bookScheduleId">ID de Horario:</label>
            <input type="number" id="bookScheduleId" name="schedule_id" required><br>
            <label for="bookSeatNumber">Número de Asiento:</label>
            <input type="number" id="bookSeatNumber" name="seat_number" required><br>
            <button type="submit">Reservar Ticket</button>
        </form>

        <hr>

        <h2>Mis Tickets</h2>
        <button id="viewMyTicketsBtn" style="display: none;">Ver Mis Tickets</button>
        <div id="ticketsResult" class="data-display" style="display: none;">
            <h4>Mis Reservas:</h4>
            <ul id="ticketsList">
                </ul>
        </div>

    </div>

    <script type="module" src="js/config.js"></script>
    <script type="module" src="js/ui.js"></script>
    <script type="module" src="js/api.js"></script>
    <script type="module" src="js/auth.js"></script>
    <script type="module" src="js/schedules.js"></script>
    <script type="module" src="js/tickets.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>