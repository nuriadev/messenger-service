<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eliminar usuario</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            ?>
            <h1>Eliminar usuario</h1>
            <p>Qué usuario quieres eliminar?</p>
            <form method="POST">
            <select name="usuarios">
                <?php
                $usuarios = selectAllUsers(); //se seleccionan todos los usuarios
                while ($fila = mysqli_fetch_assoc($usuarios)){ //se recorren los valores para ponerlos en el select
                    echo "<option value='".$fila["username"]."'>";
                    echo $fila["username"];
                    echo "</option>";
                }
                ?>
            </select>
            <input type="submit" name="boton" required>
            </form>
            <?php
                if (isset($_POST["boton"])) { //si se ha apretado el botón de enviar
                    $usuario = $_POST["usuarios"]; //guardamos el usuario seleccionado
                    $borrar = deleteUser($usuario); //llamamos a la función que lo borra y lo printamos por pantalla
                    echo "Has borrado a $usuario correctamente!<br>";
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