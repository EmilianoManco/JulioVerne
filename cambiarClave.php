<?php
session_start();
if(isset($_GET['id']) or isset($_POST['id']) and isset($_GET['rol']) or isset($_POST['rol'])){

    $id=$_GET['id'] ?? $_POST['id'];
    $rol=$_GET['rol'] ?? $_POST['rol'];

    require "conexion.php";
    $conn=conectar();

}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cambiar Clave</title>
</head>
<body>
<header>
          <div class="logo">
              <img src="img/logo.png" alt="">
          </div>
          <h1 class="nombre-empresa">Libreria Julio Verne</h1>
          <div class="logo"></div>
      </header>
      <main id="cambcla">


      <?php
if(isset($_POST['password']) and isset($_POST['repassword'])){
    $password=$_POST['password'];
    $repassword=$_POST['repassword'];

    if($password == $repassword){

            //Cambio la clave y borro el token en la BD
            $update="UPDATE usuarios SET usu_clave='$password' WHERE usu_id=$id;";

            mysqli_query($conn, $update);

                if(mysqli_affected_rows($conn) > 0){
                    
                    header("location:index.php?passCambiado");

                }
        

    

    }else{
        header("location:cambiarClave.php?noIgual&id=$id&rol=$rol");
    }

}
?>
    


    <div class="rp_contenedor">
        <form class="rp_formulario" action="cambiarClave.php" method="POST" autocomplete="off">
        <h4>Cambiar contraseña</h4>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
            <div class="rp_input-contenedor">
            <label for="password"><p>Ingrese Clave nueva: </p></label>
            <input type="password" name="password" id="password" required><br>
            </div>
            <div class="rp_input-contenedor">
            <label for="repassword"><p>Confirmar Clave: </p></label>
            <input type="password" name="repassword" id="repassword" required><br>
            </div>
            
            <?php
            if(isset($_GET['noIgual'])){
                echo "<p class='respuesta'>Las Claves ingresadas no Coinciden!</p>";
            }
            ?>

            <input type="submit" value="Cambiar">
        </form>

    </div>





      </main>


</body>
</html>