<?php

// Recibir los tokens ingresados y formar el token completo
$token1 = $_GET['token1'] ?? $_POST['token1'] ?? '';
$token2 = $_GET['token2'] ?? $_POST['token2'] ?? '';
$token3 = $_GET['token3'] ?? $_POST['token3'] ?? '';
$token4 = $_GET['token4'] ?? $_POST['token4'] ?? '';
$token5 = $_GET['token5'] ?? $_POST['token5'] ?? '';
$token6 = $_GET['token6'] ?? $_POST['token6'] ?? '';

$token = $_GET['token'] ?? $_POST['token'] ?? $token1 . $token2 . $token3 . $token4 . $token5 . $token6;

// Recibir el id del usuario
$id = $_GET['id'] ?? $_POST['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='style.css' as='style'>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <title>Ingrese la clave nueva | Julio Verne</title>
</head>
<body>

<header>
    <div class="logo">
        <img src="img/logo.png" alt="">
    </div>
    <h1 class="nombre-empresa">Libreria Julio Verne</h1>
    <div class="logo"></div>
</header>
    
<main id="resetp">
<?php
require "conexion.php";
$conn = conectar();

if(isset($_POST['password']) && isset($_POST['repassword'])) {
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Verificar si las contraseñas coinciden
    if($password == $repassword) {
        // Traer la clave actual de la base de datos
        $select = "SELECT usu_clave FROM usuarios WHERE usu_id=$id AND usu_token='$token'";
        $resulset = mysqli_query($conn, $select);
        $clave_antigua = mysqli_fetch_assoc($resulset);

        // Verificar si la nueva clave es diferente de la clave antigua
        if($password !== $clave_antigua['usu_clave']) {
            // Cambiar la clave y borrar el token en la BD
            $update = "UPDATE usuarios SET usu_clave='$password', usu_token='' WHERE usu_id=$id";
            mysqli_query($conn, $update);

            if(mysqli_affected_rows($conn) > 0) {
                header("location:index.php?passCambiado");
                exit;
            }
        } else {
            // Redireccionar si la nueva clave es igual a la clave antigua
            //header("location:reset_password.php?igualClave&id=$id&token=$token");
            header("location:reset_password.php?igualClave&id=$id&token=" . urlencode($token));
            exit;
        }
    } else {
        // Redireccionar si las contraseñas no coinciden
        //header("location:reset_password.php?noIgual&id=$id&token=$token");
        header("location:reset_password.php?noIgual&id=$id&token=" . urlencode($token));
        exit;
    }
}

// Verificar si el token es correcto
$select = "SELECT usu_id, usu_token FROM usuarios WHERE usu_id=$id AND usu_token='$token';";
$resultado = mysqli_query($conn, $select);

// Si el token es válido
if (mysqli_affected_rows($conn) > 0) {
    ?>
    <div class="rp_contenedor">
        <form class="rp_formulario" method="post" autocomplete="off">
            <label for="password"><h4>Cambiar contraseña</h4></label>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="rp_input-contenedor gradient_text">
                <label for="password"><p>Ingrese Clave nueva: </p></label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="rp_input-contenedor gradient_text">
                <label for="repassword"><p>Confirmar Clave: </p></label>
                <input type="password" name="repassword" id="repassword" required>
            </div>
            <div class="rp_botones">
                <div class="rp_input-contenedor">
                    <a href="index.php" formnovalidate="">Cancelar</a>
                </div>
                <div class="rp_input-contenedor">
                    <input type="submit" value="Cambiar">
                </div>
            </div>
        </form>

        <?php
        // Mostrar mensajes de error si las contraseñas no coinciden
        if (isset($_GET['noIgual'])) {
            echo "<p>Las Claves ingresadas no Coinciden!</p>";
        }

        if (isset($_GET['igualClave'])) {
            echo "<p>Crea una contraseña nueva que no sea igual a la actual</p>";
        }
        ?>

    </div>
    <?php
} else {
    ?>
    <div class="mensaje-error">
        <h4>El token que ingresaste es inválido. Por favor, inténtalo de nuevo.</h4>
    </div>

    <div class="enviar__contenedor">
        <form class="enviar__formulario" method="post" autocomplete="off">
            <h2><label for="token">Ingrese el Token:</label></h2>
            <h3>Le enviamos el token a su correo electrónico.</h3>
            <div class="row">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input class="token" type="text" name="token1" id="token1" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token2')">
                <input class="token" type="text" name="token2" id="token2" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token3')">
                <input class="token" type="text" name="token3" id="token3" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token4')">
                <input class="token" type="text" name="token4" id="token4" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token5')">
                <input class="token" type="text" name="token5" id="token5" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token6')">
                <input class="token" type="text" name="token6" id="token6" minlength="1" maxlength="1" required oninput="moveToNext(this, '')">
            </div>
            <input type="submit" value="Siguiente" formaction="reset_password.php">
        </form>
    </div>

    <script>
        function moveToNext(current, nextFieldID) {
            if (current.value.length >= 1) {
                if (nextFieldID !== '') {
                    document.getElementById(nextFieldID).focus();
                }
            }
        }
    </script>
    <?php
}
?>
</main>
</body>
</html>

