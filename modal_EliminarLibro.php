<?php

require "conexion.php";
$conn = conectar();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$select="SELECT lib_nombre FROM libros WHERE lib_id=$id;";

$resulset=mysqli_query($conn, $select);
$registro=mysqli_fetch_assoc($resulset);

?>
<div class="modal fade" id="eliminarLibro<?php echo $registro['lib_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header" style="background-color: #DB7035 !important;">
    <h4 class="modal-title fs-5" id="exampleModalLabel">¿Eliminar este Libro?</h4>
</div>

    <form action="eliminar_libro.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $registro['lib_id']; ?>">

      <div class="modal-body">
        
      <strong style="text-align: center !important"> 
            <?php echo $registro['lib_nombre']; ?>
      </strong>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit" value="Eliminar">
      </div>
      </form>


</div>
</div>
</div>