<?php
require "conexion.php";
$conn = conectar();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT 
    libros.lib_id, 
    libros.lib_nombre, 
    libros.lib_precio,
    libros.lib_sinopsis,
    libros.lib_foto_portada,
    libros.lib_anio_publicacion, 
    libros.lib_isbn, 
    libros.gen_id, 
    generos.gen_desc, 
    libros.edi_id, 
    editoriales.edi_desc, 
    autores.aut_id, 
    autores.aut_desc
FROM 
    julioVerne.libros
INNER JOIN 
    julioVerne.generos ON libros.gen_id = generos.gen_id
INNER JOIN 
    julioVerne.editoriales ON libros.edi_id = editoriales.edi_id
LEFT JOIN 
    julioVerne.aut_x_libr ON libros.lib_id = aut_x_libr.lib_id
LEFT JOIN 
    julioVerne.autores ON aut_x_libr.aut_id = autores.aut_id WHERE libros.lib_id='$id';";

$result = mysqli_query($conn, $query);
$registro = mysqli_fetch_assoc($result);
?>

<div class="modal-header" style="background-color: #DB7035 !important;">
    <h4 class="modal-title fs-5" id="exampleModalLabel">Modificar Datos Libro</h4>
</div>
<form action="editarLibro.php" method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $registro['lib_id']; ?>">
    <div class="modal-body">

        <div class="form-group">
            <label for="lib_nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="lib_nombre" name="nombre" value="<?php echo $registro['lib_nombre']; ?>">
        </div>

        <div class="form-group">
            <label for="aut_desc" class="form-label">Precio</label>
            <input type="number" class="form-control" id="aut_desc" name="precio" value="<?php echo $registro['lib_precio']; ?>">
        </div>

        <div class="form-group">
            <label for="sinopsis">Sinopsis</label><br>
            <textarea name="sinopsis" id="sinopsis"><?php echo $registro['lib_sinopsis']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="">Foto Portada</label>
            <br>
            <?php echo '<img width="100" src="data:image/png;base64,'.base64_encode($registro['lib_foto_portada']).'"/>'; ?><br>
            <input type="file" accept="image/png" name="portada">
        </div>
        <br>

        <div class="form-group">
            <label for="autor">Autor</label>
            <?php
                $select1="SELECT * FROM autores;";
                $result1=mysqli_query($conn, $select1);
            ?>
            <select name="autor">
                <option value="<?php echo $registro['aut_id']; ?>"><?php echo $registro['aut_desc']; ?></option>
            <?php
                while($fila=mysqli_fetch_assoc($result1)){
            ?>
                <option value="<?php echo $fila['aut_id']; ?>"><?php echo $fila['aut_desc']; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <br>

                
        <div class="form-group">
        <label for="autor">Genero</label>
            <?php
                $select3="SELECT * FROM generos;";
                $result3=mysqli_query($conn, $select3);
            ?>
            <select name="genero">
                <option value="<?php echo $registro['gen_id']; ?>"><?php echo $registro['gen_desc']; ?></option>
            <?php
                while($fila2=mysqli_fetch_assoc($result3)){
            ?>
                <option value="<?php echo $fila2['gen_id']; ?>"><?php echo $fila2['gen_desc']; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <br>

        <div class="form-group">
        <label for="autor">Editorial</label>
            <?php
                $select2="SELECT * FROM editoriales;";
                $result2=mysqli_query($conn, $select2);
            ?>
            <select name="editorial">
                <option value="<?php echo $registro['edi_id']; ?>"><?php echo $registro['edi_desc']; ?></option>
            <?php
                while($fila1=mysqli_fetch_assoc($result2)){
            ?>
                <option value="<?php echo $fila1['edi_id']; ?>"><?php echo $fila1['edi_desc']; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="number" class="form-control" name="isbn" id="isbn" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $registro['lib_isbn']; ?>">
        </div>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </div>
</form>
