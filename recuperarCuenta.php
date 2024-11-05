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
        <title>Recuperar Cuenta | Julio Verne</title>
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

        <main id="rc">
            <div class="rc__contenedor">
                <form action="enviar.php" method="GET" autocomplete="off">
                    <h2>Recuperar tu Cuenta</h2>
                    <div class="rc__input-contenedor">
                        <label for="email">
                            <p>Email:</p>
                        </label>
                        <input type="email" class="input" id="email" name="correo" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required><br>
                    </div>
                        <div class="rc__input-botones">
                            <div>
                                <!-- Dentro del button no cambiar el type=button por type=submit porq no funciona -->
                                <a href="index.php"><button class="volver" type="button">Volver</button></a>
                            </div>
                          <input type="submit" value="Enviar">
                        </div>
                </form>
            </div>
        </main>

    </body>
</html>