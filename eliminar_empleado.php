<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01){

    require "conexion.php";
    $conn=conectar();

}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}

// Eliminar empleado 

    $id=$_POST['id'];

    //echo $id;

    $update="UPDATE usuarios SET usu_estado=0 WHERE usu_id='$id';";

    mysqli_query($conn, $update);

    if(mysqli_affected_rows($conn) > 0){

        header("location:gestionar_empleados.php?deleteExitoso");


    }else{
        echo "<h4>Error al Eliminar el usuario, Por Favor regrese y reintente!</h4>";
?>
        <a href="administrador.php"><button>Volver</button></a>
<?php
    }
?>