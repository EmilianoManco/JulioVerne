<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol']=="02"){

    require "conexion.php";
    $conn=conectar();
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha=date("Y-m-d");
    $id_usuario=$_SESSION['id'];
    $sucursal=$_SESSION['sucursal'];

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
    <title>Venta</title>
</head>
<body>
    
<?php

    // Verificar si se recibieron los datos correctamente
    if (isset($_POST['nombre']) && isset($_POST['cantidad']) && isset($_POST['precio'])) {
    $nombres = $_POST['nombre'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];
    $libro_ids = $_POST['id'];
    $totalLibros= $_POST['totalLibros'];
    $precioTotal= $_POST['precioTotal'];

    /* PROBANDO SI ME LLEGAN TODOS LOS DATOS, DESDE ACA -->
// Verificar si se han recibido datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Imprimir todos los datos recibidos
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    // Puedes imprimir de manera individual si lo prefieres
    //$id_venta = $_POST['id_venta'] ?? '';
    $libros = $_POST['id_libro'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];
    $precios = $_POST['precio'] ?? [];
    
    //echo "ID Venta: $id_venta<br>";
    
    foreach ($libros as $index => $id_libro) {
        $cantidad = $cantidades[$index];
        $precio = $precios[$index];
        
        echo "Libro ID: $id_libro, Cantidad: $cantidad, Precio: $precio<br>";
    }

    echo "TOTAL LIBROS :".$totalLibros;
    echo "<br>";
    echo "PRECIO TOTAL :".$precioTotal;
    
    // Detener la ejecución del script para ver los resultados
    exit;

    HASTA ACA <-- */
    

    /*LO NUEVO 

         unset($_SESSION['libros_ids']);
        $libros_ids=$_SESSION['libros_ids'];

        for($i = 0; $i<count($precios); $i++){
        $libros_ids[]=$_POST['id'][$i];
        echo "ID de los libros seleccionados :".$libros_ids[$i];
        echo "<br>";
        }

    HASTA ACA */

    //echo "precio total".$precioTotal." total de libros ".$totalLibros." Fecha hoy".$fecha;
    
    //Cargo los primeros datos en la tabla ventas_cabecera
    $insert1="INSERT INTO ventas_cabecera(usu_id, suc_id, cab_cantidad_total, cab_fecha, cab_precio_total)
    VALUES($id_usuario, $sucursal, $totalLibros, '$fecha', $precioTotal);";

    if($conn->query($insert1) === true){

        //Con esto obtengo el ultimo ID que acabo se ingresar
        $id_venta = $conn->insert_id; 


        for ($i = 0; $i<count($libro_ids); $i++){
            $id_libro = $libro_ids[$i]; 
            $cantidad = $cantidades[$i];
            $precio = $precios[$i];

            //Preparo un select para traer la cantidad de libros que se esta iterando
            $select = "SELECT lib_stock_disponible FROM libros WHERE lib_id='$id_libro';";

            $resultado=mysqli_query($conn, $select);
            

            if ($resultado) {
                $registro = mysqli_fetch_assoc($resultado);
                $stock_disponible = intval($registro['lib_stock_disponible']); // Obtengo el stock disponible como entero
    
                // Calculo el nuevo stock del libro
                $stock_actualizado = $stock_disponible - $cantidad;
    
                if ($stock_actualizado >= 0) { // Verifico que el stock no sea negativo
                    
                    $update = "UPDATE libros SET lib_stock_disponible='$stock_actualizado' WHERE lib_id='$id_libro';";

                    if (mysqli_query($conn, $update)) {

                         //Preparo el segundo insert a la tabla ventas_detalle
                        $insert2 = "INSERT INTO ventas_detalle(cab_id, lib_id, det_cantidad, det_precio) VALUES(?, ?, ?, ?);";

                        $stmt = $conn->prepare($insert2);

                         //con esta funcion se sustituye al simbolo ? en la sentencia SQL, antes cada letra describe el tipo de dato que se va a ingresar : i = INTEGER, d = DECIMAL
                        $stmt->bind_param("iiid", $id_venta, $id_libro, $cantidad, $precio);
                        $stmt->execute();
                    }else{
                        echo "Error al actualizar el stock del libro con ID $id_libro: " . $conn->error;
                    }
                }else{
                    echo "No hay suficiente stock disponible para el libro con ID $id_libro.";
                }
            }else{
                echo "Error al obtener el stock del libro con ID $id_libro: " . $conn->error;
            }
        }
    
        unset($_SESSION['libros']); // Elimino los datos de la sesión libros
        header("location: cargar_ventas.php?ventaExitosa");
    ?>
        <a href="empleado.php"><button>Volver</button></a>
    <?php
    } else {
        echo "Error al registrar la venta: " . $conn->error;
    }


    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    }else{
        echo "error al recibir los datos";
?>
    <a href="empleado.php">Volver</a>
<?php
    }


?>



</body>
</html>