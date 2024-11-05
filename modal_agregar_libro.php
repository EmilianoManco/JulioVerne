<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estiloModalAgregarLibro.css">
    <script type="text/javascript" src="jquery-3.7.1.js"></script>
</head>
<body>
<script type="text/javascript"> //codigo para mostrar el mini formulario para agregar un nuevo autor
$(document).ready(function(){
  $("#hide").click(function(){
    $("#element").hide();
  });
  $("#show").click(function(){
    $("#element").show();
  });

  $("#enviar-btn").click(function(e) {
    e.preventDefault();

    var nameop = $("input#name").val();
    var dataString = 'name=' + nameop;

    $.ajax({
        type: "POST",
        url: "agregar_autor.php",
        data: dataString,
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.error) {
                alert('Error: ' + response.error);
            } else {
                $("#campo_select_autor").append('<option value="'+response.aut_id+'" selected="selected">'+response.aut_desc+'</option>');
                $("#element").hide();
                $("#name").val("");
            }
        },
        error: function(xhr, status, error) {
            alert('Error: ' + error);
        }
    });
  });
});
</script>

<!-- Modal Agregar Libro -->
<div class="modal fade" id="agregarLibro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #DB7035 !important;">
        <h4 class="modal-title fs-5" id="exampleModalLabel">Agregar Libro</h4>
      </div>
      <form action="ingresar_libro.php" method="POST" enctype="multipart/form-data" autocomplete="off"><!-- el enctype sirve para enviar la imagen sino no se puede cargar -->
        <div class="modal-body">
        
            <div class="form-group">
                <label class="col-form-label">Nombre del Libro :</label>
                <input type="text" name="nombre" class="" required> 
            </div>

            <div class="form-group">
                <label class="col-form-label">Precio :</label>
                <input type="number" name="precio" class="" required>
            </div>

            <div class="form-group">
                <label  class="col-from-labeñ">Breve Sinopsis :</label><br>
                <textarea name="sinopsis" placeholder="Escriba Aqui....." required></textarea>
            </div>

            <div class="form-group">
                <label class="col-form-label">Fecha de Publicacion :</label>
                <input type="date" name="fecha" class="" required max="<?= date("Y-m-d"); ?>">
            </div>

            <div class="form-group">
                <label class="col-form-label">ISBN :</label>
                <input type="number" maxlength="13" name="isbn" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
            </div>
        
            <div class="form-group">
                <label class="col-form-label">Autor :</label>
                <?php  
                       $select="SELECT aut_id, aut_desc FROM autores;";
                       $resulset=mysqli_query($conn, $select);
                ?>
                <select name="autor" id="campo_select_autor" required>
                    <option value="" disabled selected>Seleccione un autor</option>
                    <?php
                        while($fila=mysqli_fetch_assoc($resulset)){
                    ?>
                        <option value="<?php echo $fila['aut_id']; ?>"><?php echo $fila['aut_desc']; ?></option>
                    <?php
                        }
                    ?>
                </select>&nbsp;&nbsp;<a href="#" id="show"><input type="button" value="Añadir autor"></a>
            </div>

            <div class="form-group">
                <label class="col-form-label">Genero :</label>
                <?php
                      $generos="SELECT gen_id, gen_desc FROM generos;";
                      $resulset2=mysqli_query($conn, $generos);
                ?>
                <select name="genero" required>
                    <option value="" disabled selected>Seleccione un genero</option>
                        <?php 
                            while($registro=mysqli_fetch_assoc($resulset2)){
                        ?>
                            <option value="<?php echo $registro['gen_id']; ?>"><?php echo $registro['gen_desc']; ?></option>

                        <?php
                            }
                        ?>
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label" for="stock">Stock Disponible :</label>
                <input type="number" name="stock" id="stock" required>
            </div>

            <div class="form-group">
            <label class="col-form-label">Editorial :</label>
                <?php
                      $generos="SELECT edi_id, edi_desc FROM editoriales;";
                      $resulset3=mysqli_query($conn, $generos);
                ?>
                <select name="editorial" required>
                    <option value="" disabled selected>Seleccione una Editorial</option>
                        <?php 
                            while($resultado=mysqli_fetch_assoc($resulset3)){
                        ?>
                            <option value="<?php echo $resultado['edi_id']; ?>"><?php echo $resultado['edi_desc']; ?></option>

                        <?php
                            }
                        ?>
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label">Imagen de Portada :</label>
                <input type="file" accept="image/png" name="portada" required>
            </div>
                
            <div class="modal-footer">
                <input type="submit" class='btn btn-primary' value="Confirmar">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

            <!-- FORMULARIO PARA AGREGAR UN NUEVO AUTOR -->

            <div id="newmessage"></div>
            <div id="element" style="display: none;">
            <div id="close"><a href="#" id="hide"><input type="button" value="Cerrar formulario"></a></div>
            <br>
            <form method="post" action="" name="nuevoitem" id="nuevoitem">
                    Nombre del Nuevo Autor:&nbsp;&nbsp;
                    <input type="text" id="name" name="name" size="40">&nbsp;&nbsp;&nbsp;&nbsp;
                    <div style="margin-left: 376px;"><input name="submit" type="submit" value="enviar" id="enviar-btn"></div>
            </form>
            </div>
        </div>


        </form>
        
    </div>
  </div>
</div>


</body>
</html>