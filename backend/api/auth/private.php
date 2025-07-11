<?php
    $auth=false;
    if(!$auth){
        header('Location: error.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <hr>
        <h2 class="white">Zona privada</h2>
        <section class="white">
            <p>Autenticacion con éxito</p>
        </section>
    </main>    
</body>
</html>