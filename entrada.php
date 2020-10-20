<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bandeja de entrada</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
    session_start(); //indicamos que vamos a usar variables de sesión
    require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
    if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
    ?>
        <h1>Bandeja de entrada</h1>
        <form method="POST">
            <h3>Tus mensajes:</h3>
            <select name="mensajes" style="width:90%;">
                <?php
                $emails = getAllEmail($_SESSION["username"]); //seleccionamos todos los emails de un usuario
                $login = addEvent($_SESSION["username"], "C"); //guardamos en la tabla de eventos el login
                while ($fila = mysqli_fetch_assoc($emails)) { //recorremos con un bucle los valores y los mostramos en el select
                        echo "<option value='".$fila["idmessage"]."'>";
                        if ($fila["read"] == 0) { //indicamos que si el campo contiene un 0
                            $leido = "NO LEÍDO"; //se muestre no leído
                        } else {
                            $leido = "LEÍDO"; //si contiene un 1 se muestra leído
                        }
                        echo " SUBJECT: ".$fila["subject"]." - "."DE: ".$fila["sender"]." FECHA: ".$fila["date"]. " - ".$leido;
                        echo "</option>";    
                }
                ?>
            </select><br>
            <input type="submit" name="boton" value="Leer" style="margin-top: 15px;margin-bottom: 15px;" required>
        </form>
        
        <?php
            if(isset($_POST["boton"])){ //si se ha pulsado el botón de enviar
                $mensaje = $_POST["mensajes"]; //guardamos el mensaje seleccionado en el select
                $seleccionar = selectEmail($mensaje); //seleccionamos el email
                ?>
                    <table class="email">
                    <?php
                    $leido = readEmail($mensaje); //llamamos la función que cambia el estado a leído
                    while ($fila = mysqli_fetch_assoc($seleccionar)) { //recorremos el email y lo mostramos en una tabla
                        echo "<tr>";
                        echo "<th>De:";
                        echo "<td>".$fila["sender"]."</td>";
                        echo "</th>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Subject:";
                        echo "<td>".$fila["subject"]."</td>";
                        echo "</th>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Body:";
                        echo "<td>".$fila["body"]."</td>";
                        echo "</th>";
                        echo "</tr>";
                    }?>
                    </table>
                <?php
            }
    } else { //si no se ha iniciado sesión
        echo "Sesión no iniciada, vuelve a la página principal.<br>";
        ?>
        <a href="index.php">Página principal</a>
        <?php
    }
    ?><a href="principal.php">Volver a tu bandeja de entrada</a>
</body>
</html>