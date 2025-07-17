<?php var_dump($_POST); echo("<br>"); var_dump($_SERVER); echo("<br>"); var_dump($_GET)?>
<form action="./procesarfecha.php" method="GET">
    <input type="text" name="origen" id="origen">
    <input type="text" name="destino" id="destino">
    <input type="date" name="fecha" id="fecha-de-ida">
    <input type="submit" value="Buscar">
</form>