<!-- Modal -->
<div class="modal fade" id="eliminarEmpleado<?php echo $fila['usu_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #DB7035 !important;">
        <h4 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Empleado</h4>
      </div>

       <form action="eliminar_empleado.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $fila['usu_id']; ?>">

      <div class="modal-body">
        
      <strong style="text-align: center !important"> 
            <?php echo $fila['usu_nombre']; ?>
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