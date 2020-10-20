<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de usuarios</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
        ?>
            <h1>Listado de los usuarios registrados:</h1>
            <table class="taula">
                <tr>
                    <th>Username</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                </tr>
                    <?php
                    $usuarios = selectAllUsers(); //se seleccionan todos los usuarios
                    while ($fila = mysqli_fetch_assoc($usuarios)) { //con un bucle se recorren los usuarios y se muestran los datos
                        echo "<tr>";
                        echo "<td>".$fila["username"]."</td>";
                        echo "<td>".$fila["name"]."</td>";
                        echo "<td>".$fila["surname"]."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table><br>
                <a href="principal.php">Volver a tu bandeja entrada</a>
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