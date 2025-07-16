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
            <div clas="top">
                <div class="logo">
                <img src="./images/lbus.webp" alt="">
                <h2>PAKA <pan class="danger">BUSSINES</pan></h2>

            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div>

            </div>
            
            <div class="sidebar">
                <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>

                 <a href="#">
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

                  <a href="#">
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
                    <span class="material-icons-sharp">
                        analytics
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Bus Comun</h3>
                            <h1>$5,024</h1>

                        </div>
                        <div class="Progress">
                            <svg>
                                 
                            </svg>
                            <div>
                                   
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 1</small>
                </div>
                
                <div class="sales">
                    <span class="material-icons-sharp">
                        analytics
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Bus Comodo</h3>
                            <h1>$12,4</h1>

                        </div>
                        <div class="Progress">
                            <svg>
                                 
                            </svg>
                            <div>
                                   
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 2</small>
                </div>

                <div class="sales">
                    <span class="material-icons-sharp">
                        analytics
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Bus de Lujo</h3>
                            <h1>$30,20</h1>

                        </div>
                        <div class="Progress">
                            <svg>
                                 
                            </svg>
                            <div>
                                   
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Tipo 3</small>
                </div>
            </div> 
            
            <div class="recent-order">
                <h2>Recent</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Number</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Foldable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                        </tr>
                    </tbody>
                </table>
                <a href="">Show All</a>
            </div>
        </main>
    </div>    
</body>
</html>