<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

    require "conexion.php";
    $conn=conectar();
    $sucursal=$_SESSION['sucursal'];
    
}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}

    $nombre=$_POST['nombre'];
    $precio=$_POST['precio'];
    $sinopsis=$_POST['sinopsis'];
    $fecha=$_POST['fecha'];
    $isbn=$_POST['isbn'];
    $autor=$_POST['autor'];
    $stock=$_POST['stock'];
    $genero=$_POST['genero'];
    $editorial=$_POST['editorial'];
    $nombreImg=$_FILES['portada']['name'];
    $tamanoImg=$_FILES['portada']['size'];
    
    //echo "nombre del libro :".$nombre." precio :".$precio." descripcion :".$sinopsis." fecha de publicacion :".$fecha." ISBN :".$isbn." Nro Autor :".$autor." Nro genero :".$genero." Nro editorial :".$editorial." nombre de la Imagen :".$nombreImg." tamano de la imagen :".$tamanoImg;

    $imagenSubida=fopen($_FILES['portada']['tmp_name'], 'r');
    $binariosImagen=fread($imagenSubida, $tamanoImg);

    $binariosImagen=mysqli_escape_string($conn, $binariosImagen);

    //Comprobar si el ISBN que se ingreso no este en la BD

    $select="SELECT lib_id FROM libros WHERE lib_isbn = '$isbn';";

    mysqli_query($conn, $select);

    //Si hubo filas afectadas es porque ya hay un libro con ese ISBN en la BD
    if(mysqli_affected_rows($conn) > 0){

        $mensaje = "El ISBN que usted ingreso ya esta registrado :".$isbn;

        header("location: gestionarLibros.php?error=". urldecode($mensaje));

    }else{

        $insert="INSERT INTO libros (lib_nombre, lib_sinopsis, lib_stock_disponible, lib_precio, lib_foto_portada, lib_anio_publicacion, lib_estado, lib_isbn, gen_id, edi_id, suc_id)
        VALUES ('$nombre', '$sinopsis', '$stock', '$precio', '$binariosImagen', '$fecha', 1, '$isbn', $genero, $editorial, '$sucursal');";
    
        mysqli_query($conn, $insert);
    
        if(mysqli_affected_rows($conn) > 0){
    
            //aca voy a Buscar el id del libro que acabo de ingresar 
            $select="SELECT lib_id FROM libros WHERE lib_precio='$precio' AND lib_nombre='$nombre';";
    
            $resulset=mysqli_query($conn, $select);
    
            if($resulset){
                $fila = mysqli_fetch_row($resulset);
                if ($fila) {
                    //echo "ID del libro insertado: " . $fila[0];
    
                    $insert2="INSERT INTO aut_x_libr (lib_id, aut_id) VALUES ('{$fila[0]}', '$autor');";
    
                    mysqli_query($conn, $insert2);
    
                    header("location:gestionarLibros.php?insertExitoso");
    
                } else {
                    echo "Error: No se encontró el libro insertado.";
                }
            } else {
                echo "Error en la consulta de selección: " . mysqli_error($conn);
            }
    
            
    
        }else{
            echo "Error al ingresar el nuevo libro, Por Favor vuelva atras y reintente";
    ?>
            <a href="empleado.php"><button>Volver</button></a>
    <?php
        }

    }