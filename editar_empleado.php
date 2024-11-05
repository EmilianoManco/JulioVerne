<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01){

    require "conexion.php";
    $conn=conectar();



}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}
    $id=$_POST['id'];
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $correo=$_POST['correo'];
    $dni=$_POST['dni'];
    $telefono=$_POST['telefono'];

    //echo $id." ".$nombre." ".$apellido." ".$correo." ".$dni." ".$telefono;

    $update="UPDATE usuarios SET usu_nombre='$nombre', usu_apellido='$apellido', usu_correo='$correo', usu_dni='$dni', usu_telefono='$telefono' 
    WHERE usu_id=$id;";

    mysqli_query($conn, $update);

    if(mysqli_affected_rows($conn) > 0){

        header("location:gestionar_empleados.php?editExitoso");




    }else{
        echo "Error al modificar los Datos, Por Favor vuelva atras y Reintente!";
?>
        <a href="administrador.php"><button>Volver</button></a>
<?php
    }

?>