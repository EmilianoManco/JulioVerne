<?php

    require "conexion.php";
    $conn=conectar();

    $id=$_GET['id'];

    $select="SELECT lib_nombre, lib_stock_disponible FROM libros WHERE lib_id=$id;";

    $resulset=$conn->query($select);

    $registro=mysqli_fetch_assoc($resulset);

?>

<div class="modal-header" style="background-color: #DB7035 !important;">
    <h4 class="modal-title fs-5" id="exampleModalLabel"><?php echo $registro['lib_nombre']; ?></h4>
</div>

            <form action="actualizar_stock.php" method="POST">
            <div class="modal-body">

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label class="col-form-label">Stock Actual:</label>
                    <input type="number" name="stock" readonly value="<?php echo $registro['lib_stock_disponible']; ?>"> 
                </div>

                <div class="form-group">
                    <label class="col-form-label">Agregar:</label>
                    <input type="number" name="ingreso" min="1" max="1000" required> 
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>   

            </form>   