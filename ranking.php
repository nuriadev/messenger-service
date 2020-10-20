<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ranking usuarios</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            ?> 
            <h1>Ranking de usuarios con más mensajes enviados</h1>
            <table class="taula espacio">
                <tr>
                    <th>Username</th>
                    <th>Número de mensajes enviados</th>
                </tr>
            <?php
            $usuarios = selectRanking(); //se selecciona el ranking de usuarios
            while ($fila = mysqli_fetch_assoc($usuarios)) { //se recorre el ranking y se muestran los valores
                echo "<tr>";                                //en una tabla
                echo "<td>".$fila["username"]."</td>";
                echo "<td>".$fila["count(sender)"]."</td>";
                echo "</tr>";
            }
            ?>
            </table>
            <a href="principal.php">Volver a la página principal</a>
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