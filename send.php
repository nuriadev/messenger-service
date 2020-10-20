<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) {   //comprobamos que haya una sesión abierta
            ?>
            <h1>Mensajes enviados</h1>
            <form method="POST" class="espacio">
                <select name="mensaje">
                    <?php
                    $emails = selectEmailSent($_SESSION["username"]); //se seleccionan los emails enviados
                    while($fila = mysqli_fetch_assoc($emails)) { //bucle que recorre los emails y los muestra en el select
                        echo "<option value='".$fila["idmessage"]."'>";
                        echo "PARA: ".$fila["receiver"]." - ".$fila["subject"]." - ".$fila["date"];
                        echo "</option>";
                    }
                    ?>
                </select>
            </form>
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