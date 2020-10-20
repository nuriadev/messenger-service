<?php

//función que conecta con la base de datos
function conectar() {
    $conexion = mysqli_connect("localhost", "root", "", "msg");
    //si ha habido error, finalizo la aplicación
    if (!$conexion) {
        die("Error en la conexión");
    }
    //si todo ha ido bien, devolvemos la conexion
    //para poder utilizarla en el resto de funciones
    return $conexion;
}

//función que desconecta de la base de datos
function desconectar($conexion) {
    mysqli_close($conexion);
}

//función para hacer los selects
function selects($select) {
    $c = conectar();
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//función para hacer los inserts
function inserts($insert) {
    $c = conectar();
    if (mysqli_query($c, $insert) === false ) {
        $resultado = mysqli_error($c);
    } else {
        $resultado = "ok";
    }
    desconectar($c);
    return $resultado;
}

//función para comprobar las filas
function filas($fila) {
    $c = conectar();
    $resultado = mysqli_query($c, $fila);
    if (mysqli_num_rows($resultado) === 1) {
        $existe = true;
    } else {
        $existe = false;
    }
    desconectar($c);
    return $existe;
}

//función que registra a los usuarios
function registrar($username, $password, $name, $surname, $admin) {
    $insert = "insert into user values ('$username', '$password', '$name', '$surname', '$admin')";
    return inserts($insert);  
}

//función que comprueba si un usuario existe o no
function exists($username) {
    $select = "select * from user where username = '$username'";
    return filas($select);
}

//funcion que devuelve si la contraseña introducida es la misma que la de la bbdd
function mismaPass($username, $password) {
    $c = conectar();
    $select = "select * from user where username = '$username'";
    $result = mysqli_query($c, $select);
    while($fila = mysqli_fetch_assoc($result)){
        $resultado = $fila['password'];
    } 
    if (!password_verify($password, $resultado)) {
        $passCorrecta = false;
    } else {
        $passCorrecta = true;
    }
    desconectar($c);
    return $passCorrecta;
}

//función que actualiza la contraseña en la bbdd
function updatePass($username, $password) {
    $update = "update user set password='$password' where username='$username'";
    return selects($update);
}

//función que selecciona todos los usarios
function selectUsers() {
    $select = "select * from user";
    return selects($select);
}

//función que guarda el mensaje
function sendEmail($idmessage, $sender, $receiver, $date, $read, $subject, $mensaje) {
    $insert = "insert into message values ($idmessage, '$sender', '$receiver', '$date', $read, '$subject', '$mensaje')";
    return inserts($insert);
}

//función que devuelve todos los mensajes de una persona
function getAllEmail($username) {
    $select = "select * from message where receiver='$username' ORDER BY date DESC";
    return selects($select);
}

//función que selecciona un email
function selectEmail($idmessage) {
    $select = "select * from message where idmessage='$idmessage'";
    return selects($select);
}

//función que selecciona los emails enviados
function selectEmailSent($username) {
    $select = "select * from message where sender='$username' ORDER BY date DESC";
    return selects($select);
}

//función que selecciona todo de un usuario
function selectAllFromUser($username) {
    $select = "select * from user where username='$username'";
    return selects($select);
}

//función que selecciona todos los usuarios
function selectAllUsers() {
    $select = "select * from user";
    return selects($select);
}

//función para borrar un usuario
function deleteUser($username) {
    $delete = "delete from user where username = '$username'";
    return selects($delete);
}

//función que selecciona todos los mensajes
function selectAllMsg() {
    $select = "SELECT * FROM message ORDER BY date DESC";
    return selects($select);
}

//función que selecciona los usuarios con más mensajes
function selectRanking(){
    $select = "SELECT user.username, count(sender) FROM message RIGHT JOIN user ON message.sender=user.username GROUP BY username ORDER BY count(sender) DESC, sender LIMIT 10";
    return selects($select);
}

//función que hace el menú 
function menu() {
    ?>
    <h2>Bienvenido a tu bandeja de entrada</h2>
    <ul>
        <li> 
            <a href="password.php">Actualizar tu contraseña</a>
        </li>
        <li> 
            <a href="newmensaje.php">Enviar un mensaje</a>
        </li>
        <li> 
            <a href="entrada.php">Bandeja de entrada</a>
        </li>
        <li> 
            <a href="send.php">Mensajes enviados</a>
        </li>  
<?php
    //función que selecciona todo de los usuarios
    $tipo = selectAllFromUser($_SESSION["username"]);
    //seleccionamos el tipo
    $fila = mysqli_fetch_assoc($tipo);
    //si es un admin se despliega el resto del menú
    if ($fila["type"] == 1) {
        ?>
        <li>
            <a href="verUsuarios.php">Listado de todos los usuarios</a>
        </li>
        <li>
            <a href="registroAdmin.php">Registrar usuarios o administradores</a>
        </li>
        <li>
            <a href="eliminarUsuario.php">Eliminar usuario</a>
        </li>
        <li>
            <a href="allMensajes.php">Ver todos los mensajes</a>
        </li>
        <li>
            <a href="lastSesion.php">Último inicio de sesión</a>
        </li>
        <li>
            <a href="ranking.php">Ranking de usuarios</a>
        </li>
    </ul>
        <?php
    }
    ?>
    <a href="cerrarsesion.php">Cerrar sesión</a>
    <?php
}

//función para leer mensaje
function readEmail($idmessage) {
    $update = "update message set message.read=1 WHERE idmessage='$idmessage'";
    return selects($update);
}

//función para registrar un evento
function addEvent($user, $type) {
    $insert = "insert into event values('0', '$user', (SELECT now()), '$type')";
    return inserts($insert);
}

//función que comprueba si un usuario se ha logeado anteriormente
function login($username) {
    $select = "select * from event where type='I' and user='$username' ORDER BY date DESC LIMIT 1";
    return filas($select);
}

//función que devuelve la última sesión de un usuario
function selectLastSession($username) {
    $select = "select * from event where type='I' and user='$username' ORDER BY date DESC LIMIT 1";
    return selects($select);
}
?>