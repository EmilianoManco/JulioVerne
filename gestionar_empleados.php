<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01){

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='administrador.css' as='style'>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="administrador.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Gestionar Empleados | Julio Verne</title>
</head>
<body>
  
  <header>
        <div class="logo">
            <img src="img/logo.png" alt="Julio Verne Logo">
        </div>
        <h1 class="nombre-empresa">Libreria Julio Verne</h1>
        <div class="nameandclose">
            <form class="logout" action="index.php" method="POST">
                <p class="nomb">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                    </svg>
                    <?php echo "".$_SESSION['nombre'];?>
                </p>
                <input class="logout__btn" type="submit" value="Cerrar Sesión">
            </form>
        </div>
  </header>

  <main id="gest_emp">
    <div class="btn_volver">
        <a href="administrador.php">
            <button class="volver">Volver</button>
        </a>
    </div>
    <div class="ge_subtitulo">
      <h2>Gestionar Empleados</h2>
    </div>
    <div class="ge_contenedor">

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Correo</th>
          <th scope="col">DNI</th>
          <th scope="col">Telefono</th>
          <th scope="col"></th>
        </tr>
      </thead>
<?php

    $select="SELECT * FROM usuarios WHERE rol_id=02 AND usu_estado=01;";

    $resulset=mysqli_query($conn, $select);

    while($fila=mysqli_fetch_assoc($resulset)){

?>
  <tbody>
    <tr>
      <td><?php echo $fila['usu_nombre']; ?></td>
      <td><?php echo $fila['usu_apellido']; ?></td>
      <td><?php echo $fila['usu_correo']; ?></td>
      <td><?php echo $fila['usu_dni']; ?></td>
      <td><?php echo $fila['usu_telefono']; ?></td>
      <td>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarEmpleado<?php echo $fila['usu_id']; ?>">Modificar</button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eliminarEmpleado<?php echo $fila['usu_id']; ?>">Eliminar</button>
      </td>

      <!-- Ventana Modal para actualizar datos -->
      <?php include('modal_editar.php'); ?>

      <!-- Ventana Modal para eliminar -->
      <?php include('modal_eliminar.php'); ?>

    </tr>
  </tbody>
<?php
    }
?>
</table>


<?php
if(isset($_GET['editExitoso'])){ //Si se modifico los datos del empleado ingresa y muestra un mensaje
?>
  <script>
      window.alert("Se Modificaron los datos de forma Exitosa!");
  </script>
<?php

}

if(isset($_GET['deleteExitoso'])){ //si se elimino un empleado ingresa y muestra un mensaje
?>
  <script>
      window.alert("Se Elimino al empleado de forma Exitosa!");
  </script>
<?php
}

?>
    </div>

  </main>   
</body>
</html>