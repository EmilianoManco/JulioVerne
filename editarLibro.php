<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

    require "conexion.php";
    $conn=conectar();
    
}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}


    $id=$_POST['id'];
    $nombre=$_POST['nombre'];
    $precio=$_POST['precio'];
    $sinopsis=$_POST['sinopsis'];
    $autor=$_POST['autor'];
    $genero=$_POST['genero'];
    $editorial=$_POST['editorial'];
    $nombreImg=$_FILES['portada']['name'];
    $tamanoImg=$_FILES['portada']['size'];
    $isbn=$_POST['isbn'];

    //echo $id." ".$nombre." ".$precio." ".$sinopsis." "." Nombre de la imagen :".$nombreImg."  tamano :".$tamanoImg." ".$isbn;
    //echo $isbn." ".$genero." ".$editorial." ".$autor;
 
   
    if($tamanoImg == 0){ //Hago una validacion por si el usuario NO ingreso una nueva foto de portada

        $update1="UPDATE libros SET lib_nombre='$nombre', lib_precio='$precio', lib_sinopsis='$sinopsis', lib_isbn='$isbn', gen_id='$genero', edi_id='$editorial'
        WHERE lib_id='$id';";

        mysqli_query($conn, $update1);

        // Ahora Update para agregar el nuevo Autor a la tabla autor x libro
        $update2="UPDATE aut_x_libr SET aut_id=$autor WHERE lib_id=$id;";

        if(mysqli_query($conn, $update2)){
            if (mysqli_affected_rows($conn) >= 0){
                //header("location:gestionarLibros.php?editLibros");
                echo "<script>";
                echo "alert('Se Modificaron los Datos del Libro de Forma Exitosa!');";
                echo "window.location.href = 'http://localhost/julioVerne/gestionarLibros.php';";
                echo "</script>";
            }else {
                echo "No se realizaron cambios en los datos del Libro1.";
            }
        } else {
            echo "Error al intentar modificar los datos del Libro: " . mysqli_error($conn);
        }
    } else{ 
        // Si el usuario ingresó una nueva foto de portada, manejar la actualización de la imagen
        $imageData = file_get_contents($_FILES['portada']['tmp_name']);
        $imageData = mysqli_real_escape_string($conn, $imageData);
    
        $update3 = "UPDATE libros SET lib_nombre='$nombre', lib_precio='$precio', lib_sinopsis='$sinopsis', lib_foto_portada='$imageData', lib_isbn='$isbn', gen_id='$genero', edi_id='$editorial' 
        WHERE lib_id='$id'";
       
        // Ahora Update para agregar el nuevo Autor a la tabla autor x libro
        $update4="UPDATE aut_x_libr SET aut_id='$autor' WHERE lib_id='$id';";

        if (mysqli_query($conn, $update4)){
            if (mysqli_affected_rows($conn) >= 0) {
                //header("location:gestionarLibros.php?editLibros");
                echo "<script>";
                echo "alert('Se Modificaron los Datos del Libro de Forma Exitosa!');";
                echo "window.location.href = 'http://localhost/julioVerne/gestionarLibros.php';";
                echo "</script>";



            } else {
                echo "No se realizaron cambios en los datos del Libro.";
            }
        } else {
            echo "Error al intentar modificar los datos del Libro con nueva portada: " . mysqli_error($conn);
        }
    } 