<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de admins</title>
    <link href="css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_SESSION["username"])) { //comprobamos que haya una sesión abierta
            ?>
            <h1>Regístra un usuario o administrador</h1>
            <form method="POST">
                <p>Nombre de usuario:<input type="text" name="username"></p>
                <p>Contraseña:<input type="password" name="password"></p>
                <p>Nombre:<input type="text" name="name"></p>
                <p>Apellido:<input type="text" name="surname"></p>
                <p>Administrador <input type="checkbox" name="tipo"></p>
                <input type="submit" name="registro" required>
            </form>
            <?php
                if (isset($_POST["registro"])) { //si se ha apretado al botón de registro
                    $username = $_POST["username"]; //guardamos las variables del form
                    $password = $_POST["password"];
                    $existe = exists($username); //comprobamos si el username introducido ya existe
                    if ($existe) { //si existe
                        echo "Usuario en uso, indica otro";
                    } else { //si no existe
                        if (!empty($_POST["tipo"])) { //si el checkbox está seleccionado
                            $admin = 1; //ponemos la variable a 1
                        } else { //si no está seleccionado
                            $admin = 0; //ponemos la variable a 0
                        }
                        $_SESSION["username"] = $username; //guardamos el username en una variable de sesión
                        $password = $_POST["password"]; //guardamos las variables del form
                        $name = $_POST["name"];
                        $surname = $_POST["surname"];
                        $passcifrada = password_hash($password, PASSWORD_DEFAULT); //ciframos la contraseña

                        //se registra al usuario o admin
                        $resultado = registrar($username, $passcifrada, $name, $surname, $admin);

                        if ($resultado == "ok") { //si se ha registrado
                            echo "$username se te ha registrado correctamente en la base de datos<br>";
                        } else { //si no
                            echo "$resultado<br>";
                        }    
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