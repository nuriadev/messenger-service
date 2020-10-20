<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enviar mensaje</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
?>
            <h1>Envía un mensaje</h1>
            <form method="POST" >
            Receptor: <select name="receptor">
                <?php
                    $usuarios = selectUsers(); //se seleccionan todos los usuarios
                    while ($fila = mysqli_fetch_assoc($usuarios)) { //recorremos todos los usuarios
                        echo "<option value='".$fila["username"]."'>"; //y se printa su username
                        echo $fila["username"];
                        echo "</option>";
                    }
                ?>
            </select><br>
            <textarea placeholder="Asunto" style="width:90%; margin-top: 20px;" name="subject"></textarea>
            <textarea placeholder="Escribe aquí tu mensaje" name="email" style="width:90%;height:300px;margin-bottom:20px;"></textarea><br>
            <input type="submit" name="botonmsg" style="margin-left: 0px;margin-bottom: 20px;" required>
            </form>
            
            <?php
                if(isset($_POST["botonmsg"])) { //si se ha apretado el botón de enviar
                    $mensaje = $_POST["email"]; //guardamos las variables
                    $receptor = $_POST["receptor"];
                    $subject = $_POST["subject"];
                    $hora = date("Y-m-d H:i:s");
                    //función que envía el mensaje
                    $resultado = sendEmail(0, $_SESSION["username"], $receptor, $hora, 0, $subject, $mensaje);
                    
                    if ($resultado == "ok") {//si se ha enviado correctamente
                        echo "Se ha enviado correctamente tu mensaje!<br>";
                        $login = addEvent($_SESSION["username"], "R"); //se registra el evento
                    } else {
                        echo "ERROR: $resultado"; //si no se muestra un error
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