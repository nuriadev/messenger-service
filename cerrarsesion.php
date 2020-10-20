<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar sesión</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            session_destroy(); //se cierra la sesión y lo mostramos por pantalla
            echo "Sesión cerrada correctamente.<br>";
        } else { //si no se ha iniciado sesión
            echo "Sesión no iniciada, vuelve a la página principal.<br>";
            ?>
            <?php
        }
    ?>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>