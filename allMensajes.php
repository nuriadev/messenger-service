<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todos los mensajes</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            $mensajes = selectAllMsg(); //seleccionamos todos los mensajes
            ?>
            <h1>Lista de todos los mensajes:</h1>
            <table class="taula espacio">
                <tr>
                    <th>Emisor</th>
                    <th>Receptor</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Leído</th>
                </tr>
                <?php
                    while ($fila = mysqli_fetch_assoc($mensajes)) { //recorremos los valores
                        if ($fila["read"] == 0) { //indicamos que si el campo contiene un 0 
                            $read = "No leído";   //se muestre no leído
                        } else {
                            $read = "Leído";      //si contiene un 1 se muestra leído
                        }
                        echo "<tr>";
                        echo "<td>".$fila["sender"]."</td>"; //mostramos los valores en la tabla
                        echo "<td>".$fila["receiver"]."</td>";
                        echo "<td>".$fila["date"]."</td>";
                        echo "<td>".$fila["subject"]."</td>";
                        echo "<td>".$read."</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
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