<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php  
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
            if (isset($_POST["login"])) { //si se ha apretado el botón de logearse
                    $username = $_POST["username"]; //guardamos las variables del form
                    $password = $_POST["password"];
                    $_SESSION["username"] = $username; //guardamos el username como variable de sesión
                    $passCorrecta = mismaPass($username, $password); //comprobamos si la contraseña introducida es la misma en la bbdd
                    if (!$passCorrecta) { //si no es la misma contraseña
                        echo "Datos incorrectos, vuelve a intentarlo<br>";
                    ?>
                    <a href="index.php">Volver a la página principal</a> 
                    <?php   
                    } else { //si no
                        menu(); //mostramos el menú
                        $login = addEvent($_SESSION["username"], "I"); //registramos el evento correspondiente
                    }
                } else if (isset($_SESSION["username"])) { //si se está logeado
                    menu(); //se muestra también el menú
            } else { //en cualquier otro caso
                echo "Inicia sesión otra vez";
                ?>
                <a href="index.php">Volver a la página principal</a>
                <?php
            }
?>    
</body>
</html>


