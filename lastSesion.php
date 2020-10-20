<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Última sesión</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            ?>
            <h1>Última sesión</h1>
            <p>De qué usuario quieres ver la última sesión?</p>
            <?php
            $usuario = selectAllUsers(); //se seleccionan todos los usuarios
            ?>
            <form method="POST" class="espacio">
                <select name="usuario">
            <?php
                while($fila = mysqli_fetch_assoc($usuario)) { //recorremos al usuario
                    echo"<option value='".$fila["username"]."'>"; //mostramos los valores en el select
                    echo $fila["username"];
                    echo "</option>";
                }
            ?>
            </select>
            <input type="submit" name="boton" required><br>
            </form>
            <?php
            if (isset($_POST["boton"])) { //si se ha apretado
                $usuario = $_POST["usuario"]; //recogemos el usuario seleccionado en el select
                if (login($usuario)) { //se comprueba si el usuario se ha logeado anteriormente
                    $session = selectLastSession($usuario); //se selecciona el último log in en eventos
                    while($fila = mysqli_fetch_assoc($session)) { //se recorre el evento y se printa la fecha
                        echo "El último inicio de sesión de $usuario ha sido el ";
                        echo $fila["date"]; 
                        echo "<br>";
                    }    
                } else { //si el usuario no se ha logeado se imprime por pantalla un mensaje
                    echo "El usuario aún no ha inciado sesión<br>";
                }    
            }
            ?>
            <a href="principal.php">Volver a tu bandeja de entrada</a>
            <?php
        } else { //si no se ha iniciado sesión
            echo "Sesión no iniciada, vuelve a la página principal.<br>";
            ?>
            <a href="index.php">Página principal</a>
            <?php
        }
        ?>
</body>
</html>