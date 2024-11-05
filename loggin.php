<?php

$correo=$_POST['correo'];
$clave=$_POST['clave'];

//echo $correo." ".$clave;

require "conexion.php";
$conn=conectar();

$select="SELECT * FROM usuarios WHERE usu_correo='$correo' AND usu_estado=1;";

$resulset=mysqli_query($conn, $select);

$registro=mysqli_fetch_assoc($resulset);

    if(mysqli_affected_rows($conn) > 0){

        if($registro['usu_clave']==$clave){

            session_start();
            $_SESSION['id']=$registro['usu_id'];
            $_SESSION['nombre']=$registro['usu_nombre'];
            $_SESSION['correo']=$registro['usu_correo'];
            $_SESSION['pass']=$registro['usu_clave'];
            $_SESSION['rol']=$registro['rol_id'];
            $_SESSION['sucursal']=$registro['suc_id'];
            $_SESSION['clave']=$registro['usu_clave'];
            $_SESSION['dni']=$registro['usu_dni'];

            switch($_SESSION['rol']){
                case 1:
                    header("location:administrador.php?");
                    break;
                case 2:
                    header("location:empleado.php?");
                    break;
                case 3:
                    header("location:contaduria.php?");
                    break;
            }

        }else{
            header("location:index.php?badPass");
        }

    }else{
        header("location:index.php?noCorreo");
    }

?>