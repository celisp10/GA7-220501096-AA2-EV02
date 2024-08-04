<?php

include_once 'configs/db.php';

date_default_timezone_set("America/Bogota");

$errores = [];

// Usar el metodo GET

// En esta ocación lo usamos para recoger el mensaje que provenga de la url
// identificado como "m". Este llega luego de el registro de un núevo usuario
// en la base de datos.

if($_GET) {
    $m = isset($_GET["m"]) ? $_GET["m"] : NULL;
}

// Usar el metodo post

// El metodo POST lo usamos para recoger todos los datos que nos envie el usuario
// de manera segura, para luego ser validados y poder ejecutar el comando sql.

if($_POST) {

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
    $cargo = isset($_POST["cargo"]) ? $_POST["cargo"] : "";
    $contrasenia = isset($_POST["contrasenia"]) ? $_POST["contrasenia"] : "";
    $repetirContrasenia = isset($_POST["repetirContrasenia"]) ? $_POST["repetirContrasenia"] : "";
    $creacion = date("Y/m/d");

    if(!$nombre) {
        $errores[] = 'El nombre es obligatorio';
    }

    if(!$apellido) {
        $errores[] = 'El apellido es obligatorio';
    }

    if(!$cargo) {
        $errores[] = 'El cargo es obligatorio';
    }

    if(!$contrasenia) {
        $errores[] = 'La contraseña es obligatoria';
    }

    if(!$repetirContrasenia) {
        $errores[] = 'Repetir la contraseña es obligatorio';
    } elseif($contrasenia != $repetirContrasenia) {
        $errores[] = 'Las contraseñas deben ser iguales';
    }

    // Guardar en la base de datos

    // Luego de validar todos los datos se ejecuta la sentencia sql con cada uno
    // de los datos recogidos.

    if(empty($errores)) {

        // Encriptar contraseña

        // Esto nos ayuda a generar más seguridad a la hora de guardar la contraseña en una base de datos.

        $contraseñaEncriptada = password_hash($contrasenia, PASSWORD_DEFAULT);

        // Ejecución de sentencia SQL.
        
        $stmt = $pdo->prepare("INSERT INTO `users` (nombre, apellido, cargo, contraseña, creacion) VALUES ('$nombre', '$apellido', '$cargo', '$contraseñaEncriptada', '$creacion')");
        $stmt->execute();
        header("location:signup.php?m=Usuario creado exitosamente");
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>

        <!-- Mostrar mensajes -->

        <!-- Si se encuentra un mensaje de tipo get este será recogido y mostrado con los estilos definidos -->

        <?php if(isset($m)) { ?>
            <?php echo "<p style='background:green;padding:10px;text-align:center;font-size:25px;width: 400px;color:white;'>".$m."</p>" ?>
        <?php } ?>

        <!-- Estos mensajes se mostrarán solo si al momento de que el usuario envien el formulario este venga incompleto -->

        <?php foreach($errores as $error) { ?>
            <?php echo "<p style='background:red;padding:10px;text-align:center;font-size:25px;width: 400px;color:white;'>".$error."</p>" ?>
        <?php } ?>

        <h2>Sign up</h2>

        <!-- Formulario HTML -->

        <!-- En este formulario se recogen los datos para luego ser enviados por metodo post -->

        <form method="POST">

            <input name="nombre" type="text" placeholder="Nombre">
            <input name="apellido" type="text" placeholder="Apellido">
            <input name="cargo" type="text" placeholder="Cargo">
            <input name="contrasenia" type="text" placeholder="Contraseña">
            <input name="repetirContrasenia" type="text" placeholder="Repetir contraseña">

            <input class="btn" type="submit" value="Registrar usuario">

        </form>
    </main>
</body>
</html>