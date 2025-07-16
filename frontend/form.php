<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
     <div class="overlay"></div>
   <div class="container " >
        <div class="form-box login">
            <form action="../backend/api/auth/login.php" method="POST">
                <div>
                    <h1>LOGIN</h1>
                    <div class="input-box">
                        <input  type="email" placeholder="correo" required name="email"> 
                        <i class="bx bxs-user"></i>
                    </div>
                    
                    <div class="input-box">
                        <input  type="password" placeholder="contraseña" required name="password">
                        <i class="bx bxs-lock-alt"></i>
                    </div>

                    <div class="forgot-link">
                        <a href="#">Olvidaste Contraseña?</a>
                    </div>
                    <button class="btn">LOGIN</button>
                    <p>o login con otras plataformas</p>        
                    
                    <div class="social-icons">
                        <a href=""><i class="bx bxl-google"></i></a>
                        <a href=""><i class="bx bxl-facebook"></i></a>
                        <a href=""><i class="bx bxl-linkedin"></i></a>
                        <a href=""><i class="bx bxl-github"></i></a>
                    </div>
                        
                </div>
            </form>
        </div>
        
        <div class="form-box register">
            <form action="../backend/api/auth/register.php" method="POST">
                <div>
                    <h1>REGISTRATE</h1>
                    <div class="input-box">
                        <input  type="text" placeholder="usuario" name="name" required> 
                        <i class="bx bxs-user"></i>
                    </div>

                    <div class="input-box">
                        <input  type="email" placeholder="correo" name="email" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>


                    <div class="input-box">
                        <input  type="password" placeholder="contraseña" name="password" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    

                  
                    <button class="btn">REGISTRATE</button>
                    <p>O registrate con otras plataformas</p>        
                    
                    <div class="social-icons">
                        <a href=""><i class="bx bxl-google"></i></a>
                        <a href=""><i class="bx bxl-facebook"></i></a>
                        <a href=""><i class="bx bxl-linkedin"></i></a>
                        <a href=""><i class="bx bxl-github"></i></a>
                    </div>
                        
                </div>
            </form>
        </div>
        

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hola, Bievenido!</h1>
                <p>No tienes una cuenta?</p>
                <button class="btn register-btn">Registrar</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Bienvenido de Nuevo!</h1>
                <p>Ya tienes una cuenta?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>

         

   </div>  

   <script src="js/form.js"></script>
</body>
</html>