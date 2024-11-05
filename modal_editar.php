<!-- Modal Editar -->
<div class="modal fade" id="editarEmpleado<?php echo $fila['usu_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #DB7035 !important;">
        <h4 class="modal-title fs-5" id="exampleModalLabel">Modificar Empleado</h4>
      </div>
      <form action="editar_empleado.php" method="POST" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $fila['usu_id']; ?>">
        <div class="modal-body">
        
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nuevo Nombre :</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $fila['usu_nombre']; ?>" required>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nuevo Apellido :</label>
                <input type="text" name="apellido" class="form-control" value="<?php echo $fila['usu_apellido']; ?>" required>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nuevo Correo :</label>
                <input type="text" name="correo" class="form-control" value="<?php echo $fila['usu_correo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nuevo Telefono :</label>
                <input type="number" name="telefono" class="form-control" value="<?php echo $fila['usu_telefono']; ?>" required>
            </div>
        
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nuevo DNI :</label>
                <input type="number" name="dni" class="form-control" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="dni" name="dni" value="<?php echo $fila['usu_dni']; ?>" required>
            </div>
        
        </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" value="Confirmar">
            </div>
        </form>


    </div>
  </div>
</div>