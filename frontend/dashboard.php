<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp&display=swap">
    <link rel="stylesheet" href="./css/dashboard.css">
    <title>DASHBOARD</title>
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/lbus.webp" alt="">
                    <h2>PAKA <span class="danger">BUSSINES</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="dashboard.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="reservar.php">
                    <span class="material-icons-sharp">event_available</span>
                    <h3>Reservar</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Ver Boleta</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="form.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>
            <div class="insights">
                <div class="sales">
                    <img class="buses" src="./images/cbus.webp" alt="">
                    <div class="middle">
                        <div class="left">
                            <h3>Bus Comun</h3>
                            <h1>$5,024</h1>
                        </div>
                        <div class="Progress">
                            <svg></svg>
                            <div></div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 1</small>
                </div>
                <div class="sales">
                    <img class="buses" src="./images/medio.jpg" alt="">
                    <div class="middle">
                        <div class="left">
                            <h3>Bus Comodo</h3>
                            <h1>$12,4</h1>
                        </div>
                        <div class="Progress">
                            <svg></svg>
                            <div></div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 2</small>
                </div>
                <div class="sales">
                    <img class="buses" src="./images/lujo.jpg" alt="">
                    <div class="middle">
                        <div class="left">
                            <h3>Bus de Lujo</h3>
                            <h1>$30,20</h1>
                        </div>
                        <div class="Progress">
                            <svg></svg>
                            <div></div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 3</small>
                </div>
            </div> 
            <div class="recent-order">
                <iframe src="https://www.google.com/maps/embed?pb=!1m46!1m12!1m3!1d4630912.888226397!2d-77.23087960512662!3d-15.770344432364041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m31!3e0!4m5!1s0x915acf5e5e369a43%3A0x11f0aad4a80a8517!2sTacna!3m2!1d-18.0067602!2d-70.2460246!4m5!1s0x9105c5f619ee3ec7%3A0x14206cb9cc452e4a!2sLima!3m2!1d-12.0466888!2d-77.04308859999999!4m5!1s0x91424a487785b9b3%3A0xa3c4a612b9942036!2sArequipa!3m2!1d-16.4057001!2d-71.5400994!4m5!1s0x91449c6d2c3f5113%3A0x48cc99a8ae586b13!2sMoquegua!3m2!1d-17.1882694!2d-70.931795!4m5!1s0x915d6985f4e74135%3A0x1e341dd8f24d32cf!2sPuno!3m2!1d-15.8402218!2d-70.0218805!5e0!3m2!1ses-419!2spe!4v1752707479379!5m2!1ses-419!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </main>
        </div>    
</body>
</html>