<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

      require "conexion.php";
      $conn = conectar();     

}else{
      echo "<h4>ACCESO NO AUTORIZADO!</h4>";
      exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $id = $_POST['id'];
      $nombre = $_POST['nombre'];
  
      /*
      echo "ID recibido: " . $id . "<br>";
      echo "Nombre recibido: " . $nombre . "<br>";*/

      $update="UPDATE libros SET lib_estado=0 WHERE lib_id=$id;";

      mysqli_query($conn, $update);

      if(mysqli_affected_rows($conn) > 0){

            header("location:gestionarLibros.php?deleteExitoso");

      }else{
            echo "Error al Eliminar el Libro, Por Favor Vuelva atras y Reintente";
?>
            <a href="empleado.php"><button>Volver</button></a>
<?php
      }

}else{
      echo "Error al recibir los datos";
?>
      <a href="empleado.php"><Button>Volver</Button></a>
<?php
}

?>