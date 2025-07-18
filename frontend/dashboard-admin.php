<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CRUD Horario</title>
    <link rel="stylesheet" href="./css/dashboard-admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,600,800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp&display=swap">
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/lbus.webp" alt="Logo">
                    <h2>PAKA <span class="danger">BUSSINES</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>
                <div id="user-info" class="session-info"></div>

            <div class="sidebar">
                <a href="dashboard-admin.php" class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Admin Dashboard</h3>
                </a>
                <a href="dashboard.php">
                    <span class="material-icons-sharp">person</span>
                    <h3>Dashboard Usuario</h3>
                </a>
                <a href="form.php" id="logoutBtn">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1>CRUD de Horarios</h1>
            <div id="crud-form-container"></div>
            <div class="table-responsive">
                <table class="crud-table" id="horario-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Salida</th>
                            <th>Hora Salida</th>
                            <th>Hora Llegada</th>
                            <th>Bus</th>
                            <th>Ruta</th>
                            <th>Conductor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="horario-tbody">
                        <!-- JS llenará los datos -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script type="module">
        import { renderUserInfo, renderForm, loadHorarios } from './js/dashboard-admin.js';
        renderUserInfo();
        renderForm();
        loadHorarios();
    </script>
</body>
</html>
