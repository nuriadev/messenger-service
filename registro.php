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
    <h1>Regístrate</h1>
    <form method="POST">
        <p>Nombre de usuario:<input type="text" name="username" maxlength="15" placeholder="Máximo 15 carácteres"></p>
        <p>Contraseña:<input type="password" name="password" minlength="8" maxlength="15" placeholder="8 carácteres hasta 15"></p>
        <p>Nombre:<input type="text" name="name" maxlength="20"></p>
        <p>Apellido:<input type="text" name="surname" maxlength="20"></p>
        <input type="submit" name="registro" required>
    </form>
    <?php
        session_start(); //indicamos que vamos a usar variables de sesión
        require_once 'bbdd.php'; //le pedimos el fichero de archivos donde están las funciones
        if (isset($_POST["registro"])) { //si se ha apretado el botón de registrarse
            $username = $_POST["username"]; //guardamos el usuario introducido
            $existe = exists($username); //función que comprueba si ya existe un username
            if ($existe) {
                echo "Usuario en uso, indica otro";
            } else {
                $_SESSION["username"] = $username; //guardamos username como variable de sesión
                $password = $_POST["password"]; //guardamos las otras variables
                $name = $_POST["name"];
                $surname = $_POST["surname"];
                $passcifrada = password_hash($password, PASSWORD_DEFAULT); //función que cifra la contraseña introducida
                $resultado = registrar($username, $passcifrada, $name, $surname, 0); //llamamos a la función que registra los usuarios

                if ($resultado == "ok") { //si ha salido bien
                    echo "$username se te ha registrado correctamente en la base de datos<br>";
                } else { //en cualquier otro caso
                    echo "$resultado<br>";
                }    
            }       
        }
    ?>
    <p><a href="index.php">Volver a la página inicial</a></p>
</body>
</html>