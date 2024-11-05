<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol']==02){

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
    <title>actualizar Stock</title>
</head>
<body>
    
<?php

    $id=$_POST['id'];
    $stock_viejo=$_POST['stock'];
    $nuevo_ingreso=$_POST['ingreso'];

    //echo $id." ".$stock_viejo." ".$nuevo_ingreso;

    //convierto estas variables a numeros enteros para luego poder sumarlas
    $stock_viejo=intval($stock_viejo); 
    $nuevo_ingreso=intval($nuevo_ingreso);

    /* Verifico si se cambiaron a integer ambas
    echo gettype($stock_viejo);
    echo "<br>";
    echo gettype($nuevo_ingreso); */

    $nuevo_ingreso = $nuevo_ingreso + $stock_viejo;

    $update = "UPDATE libros SET lib_stock_disponible='$nuevo_ingreso' WHERE lib_id='$id';";

    $conn->query($update);

    if(mysqli_affected_rows($conn) > 0){

        header("location:controlarStock.php?updateExitoso");

    }else{
        echo "<h3>Error al actualizar el stock!</h3>";
?>
        <a href="empleado.php"><button>Volver</button></a>
<?php
    }

?>



</body>
</html>