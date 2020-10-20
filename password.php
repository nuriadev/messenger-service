<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cambio de contraseña</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            ?>
            <h1>Cambiar contraseña</h1>
            <form method="POST">
                <p>Contraseña actual <input type="password" name="contraActu"></p>
                <p>Introduce la nueva contraseña <input type="password" name="nuevaPass1"></p>
                <p>Vuelve a introducir la nueva contraseña <input type="password" name="nuevaPass2"></p>
                <input type="submit" name="enviar" class="espacio" required>
            </form>
        <?php
            if (isset($_POST["enviar"])) { //si se le ha dado al botón de enviar
                $passwordActual = $_POST["contraActu"]; //guardamos las variables del formulario
                $newPass1 = $_POST["nuevaPass1"];
                $newPass2 = $_POST["nuevaPass2"];
                $passCorrecta = mismaPass($_SESSION["username"], $passwordActual); //comprobamos si la contraseña 
                if (!$passCorrecta) {                                              //introducida es la suya
                    echo "Los datos no son correctos<br>";
                } else {
                   if ($newPass1 != $newPass2) { //si la nueva contraseña y su comprobación no son la misma
                    echo "Las contraseñas no coinciden";
                } else { //si no
                    $passcifrada = password_hash($newPass2, PASSWORD_DEFAULT); //se cifra la contraseña
                    $resultado = updatePass($_SESSION["username"], $passcifrada); //se cambia la contraseña en la bbdd
                    echo "Cambio de contraseña satisfactorio"; 
                    } 
                }    
            }
        } else { //si no se ha iniciado sesión
            echo "Sesión no iniciada, vuelve a la página principal.<br>";
            ?>
            <a href="index.php">Página principal</a>
            <?php
        }
    ?>
    <a href="principal.php">Volver a tu bandeja de entrada</a>   
</body>
</html>