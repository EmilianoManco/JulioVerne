
  <?php
    /* Destrucción de $_SESSION */
    
    session_start();
    session_destroy();
  ?>
<!DOCTYPE html>
<html lang="en">
  
              <!-- HEAD -->
               
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Iniciar Sesión | Julio Verne</title>
      <link rel='preload' href='normalize.css' as='style'>
      <link rel='preload' href='style.css' as='style'>
      <!-- Link Swiper's CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
      <link rel="stylesheet" href="normalize.css">
      <link rel="stylesheet" href="style.css">
      <title>Inicio Sesión | Julio Verne</title>
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

      <main id="index">

        <!-- SWIPER -->

        <div class="swiper mySwiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="img/imagen1.jpg" alt="" srcset="">
            </div>
            <div class="swiper-slide">
              <img src="img/imagen2.jpg" alt="">
            </div>
            <div class="swiper-slide">
              <img src="img/imagen3.jpg" alt="">
            </div>
            <div class="swiper-slide">
              <img src="img/imagen4.webp" alt="">
            </div>
            <div class="swiper-slide">
              <img src="img/imagen5.webp" alt="">
            </div>
            <div class="swiper-slide">
              <img src="img/imagen6.webp" alt="">
            </div>      
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>

          <!-- CONTENEDOR -->

        <div class="index__contenedor">
              <div>
                  <form class="index__formulario" action="loggin.php" method="POST">
                    <h2>Inicio de Sesión</h2>
                      <div class="index__input-contenedor">
                          <label for="correo">
                              <p>Email:</p>
                          </label>
                          <input type="email" name="correo" id="correo" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required><br>
                      </div>
                      <div class="index__input-contenedor <?php if (isset($_GET['noCorreo']) or isset($_GET['badPass'])) { echo 'm-p-cero';} ?>">
                          <label for="clave">
                              <p>Contraseña:</p>
                          </label>
                          <input type="password" name="clave" id="clave" required><br>
                          <?php
                          if (isset($_GET['noCorreo'])) {
                              echo "<label><p class='error'>El correo ingresado no esta registrado!</p></label>";
                          }
                        
                          if (isset($_GET['badPass'])) {
                              echo "<label><p class='error'>La contraseña ingresada es invalida!</p></label>";
                          }

                          if (isset($_GET['CambiarPass'])) {
                              echo "<label><p class='error'>Correo Enviado! Para continuar verifique su casilla de correo</p></label>";
                          }
            
                          if (isset($_GET['passCambiado'])) {
                              echo "<label><p class='error'>Se Modifico la Contraseña de forma exitosa!</p></label>";
                          }
                          ?>

                      </div>
                      <div class="">
                        <label for="a">
                              <p class="olvido<?php if (isset($_GET['noCorreo']) or isset($_GET['badPass'])) {echo ' p7-5';} ?>">Olvido su Clave? Oprima <a href="recuperarCuenta.php"><i>Aqui!</i></a></p>
                        </label>
                      </div>
                      <div class="index__input-contenedor">
                          <input type="submit" value="Ingresar">
                      </div>
                  </form>
              </div>

        </div>
      </main>

      <!-- SCRIPTS -->

      <!-- Swiper JS -->
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

      <!-- Initialize Swiper -->
      <script>
        const swiper = new Swiper(".mySwiper", {
          loop: true,
          centeredSlides: false,
          initialSlide: 0,
          slidesPerView: 3,
          spaceBetween: 15,
          autoplay: {
            delay: 2000,
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
        });
      </script>

  </body>

</html>