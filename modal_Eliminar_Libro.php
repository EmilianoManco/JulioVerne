<?php

require "conexion.php";
$conn = conectar();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query ="SELECT lib_id, lib_nombre FROM libros WHERE lib_id=$id;";

$result = mysqli_query($conn, $query);
$registro = mysqli_fetch_assoc($result);
?>

<!--<div class='modal fade' id="modal_EliminarLibro"$registro['lib_id']" data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>";
<div class='modal-dialog'>
<div class='modal-content'>-->
<div class='modal-header' style='background-color: #DB7035 !important;'>
<h4 class='modal-title fs-5' id='exampleModalLabel'>¿Eliminar este Libro?</h4>
</div>
<form action='eliminar_libro.php' method='POST'>
<div class='modal-body'>
<input type="hidden" name="id" value="<?php echo $registro['lib_id']; ?>">
<input type="text" name="nombre" readonly value="<?php echo $registro['lib_nombre']; ?>">
</div>
<div class='modal-footer'>
<!--<input type='submit' class='btn btn-danger' value='Eliminar'>-->
<button type="submit" class="btn btn-danger">Eliminar</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
</form>