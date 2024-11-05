<!DOCTYPE html>
<html lang="en">

    <!-- HEAD -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='style.css' as='style'>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <title>Cambiar Contraseña | Julio Verne</title>
</head>

    <!-- BODY -->

<body>

    <!-- HEADER -->

    <header>
        <div class="logo">
            <img src="img/logo.png" alt="">
        </div>
        <h1 class="nombre-empresa">Libreria Julio Verne</h1>
        <div class="logo"></div>
    </header>

    <!-- MAIN -->

    <main id="enviar">

    <?php
        $correo=$_GET['correo'];

        //echo $correo;

        require "conexion.php";
        $conn=conectar();
        require "PHPMailer/PHPMailer.php";
        require "PHPMailer/Exception.php";
        require "PHPMailer/SMTP.php";

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;

        $email = new PHPMailer(true); 
        $email->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //LO QUE ESTA ARRIBA NO COMENTAR O BORRAR

        $select="SELECT usu_id, usu_correo, usu_nombre, rol_id FROM usuarios WHERE usu_correo='$correo';";

        $resulset=mysqli_query($conn, $select);

        if(mysqli_affected_rows($conn) > 0){

            $fila=mysqli_fetch_assoc($resulset);

            //GENERAR TOKEN Y MANDAR EMAIL

            if($fila['rol_id'] == 02 or $fila['rol_id'] == 03){
                //SI ES USUARIO TIENE EL ROL EMPLEADO O CONTADURIA VA A INGRESAR

                $token = bin2hex(random_bytes(3)); //GENERO UN TOKEN DE LONGITUD 6 (LETRAS Y NUMEROS)

                $insert="UPDATE usuarios SET usu_token='$token' WHERE usu_id='{$fila['usu_id']}';";

                mysqli_query($conn, $insert);

                if(mysqli_affected_rows($conn) > 0){

                    try{
                        //ACA GENERO EL LINK PARA ENVIAR EN EL CORREO
                        //$reset_link = "localhost/julioverne/reset_password.php?id='.{$fila['usu_id']}.'&token='.$token"; ESTE FUNCIONA TAMBIEN
                        //$reset_link = "localhost/julioverne/reset_password.php?id={$fila['usu_id']}&token=$token";
                    
                        $email->SMTPDebug = 0; 
                        $email->IsSMTP();
                        $email->SMTPAuth = true;
                        $email->SMTPSecure = 'tls';
                        $email->Host = 'smtp.gmail.com';
                        $email->Port = 587;// TCP port to connect to
                        $email->CharSet = 'UTF-8';
                        $email->Username ='libreria.julioverne.arg@gmail.com'; //Email
                        $email->Password = 'qkodtsdkoibjrplc'; //CONTRASEÑA DE APLICACION
                        //Agregar destinatario
                        $email->setFrom('libreria.julioverne.arg@gmail.com', 'Libreria Julio Verne');
                        $email->AddAddress($correo);//A quien mandar email
                        $email->SMTPKeepAlive = true;  
                        $email->Mailer = "smtp"; 
                    
                    
                        //Content
                        $email->isHTML(true); // Set email format to HTML
                    
                    
                        $email->Subject = 'Reseteo de la contraseña';
                        $email->Body    = 'Usted inicio los pasos para recuperar su contraseña, el token para continuar con el tramite es :'.$token.'';
                        //$email->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    
                                    if($email->send()) {
                                    ?>
                                    <div class="enviar__contenedor">
                                        <form class="enviar__formulario" autocomplete="off">
                                            <h2><label for="token">Ingrese el Token:</label></h2>
                                            <h3>Le enviamos el token a su correo electronico <?php echo $correo; ?></h3>
                                            <div class="row">
                                                <input type="hidden" name="id" value="<?php echo $fila['usu_id']; ?>">  
                                                <input class="token" type="text" name="token1" id="token1" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token2')">
                                                <input class="token" type="text" name="token2" id="token2" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token3')">
                                                <input class="token" type="text" name="token3" id="token3" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token4')">
                                                <input class="token" type="text" name="token4" id="token4" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token5')">
                                                <input class="token" type="text" name="token5" id="token5" minlength="1" maxlength="1" required oninput="moveToNext(this, 'token6')">
                                                <input class="token" type="text" name="token6" id="token6" minlength="1" maxlength="1" required oninput="moveToNext(this, '')">
                                            </div>
                                            <input type="submit" value="Siguiente" formaction="reset_password.php" formmethod="post">
                                        </form>
                                    </div>
                                    <!--javascript del onput-->
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
                    }catch(Exception $e){
                        echo 'Error al enviar el correo :', $email->ErrorInfo;
                    }

                }else{
                    echo "ERROR al generar el token";
                }

            }else{
                ?>
                <div class="mensaje">
                    <?php
                        //DUDA ACA CON EL MENSAJE QUE SE MUESTRA!
                        echo "<h4>No se puede realizar esta accion ahora, Por Favor vuelva atras y reintente!</h4>";
                        echo "<br>";
                    ?>
                    <a href="index.php">Volver</a>
                </div>
                <?php
            }

        }else{
            header("location:index.php?noCorreo");
        }

    ?>
    </main>

</body>
</html>