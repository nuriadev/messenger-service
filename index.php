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
    <h1>Stumessenger</h1>
        <h3>Inicia sesión</h3>
        <form method="POST" action="principal.php">
            <input type="text" name="username" placeholder="usuario">
            <input type="password" name="password" placeholder="contraseña">
            <input type="submit" name="login" value="Log in" required>
            <input type="hidden" name="tipo" value="0">
        </form>
        <p>No estás registrado? Dale click <a href="registro.php">aquí</a></p>
</body>
</html>