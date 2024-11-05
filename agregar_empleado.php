<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01){

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
    <title>Agregar Usuarios y Listar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="administrador.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

    <main id="ag_emp">
    <div class="btn_volver">
        <a href="administrador.php">
            <button class="volver">Volver</button>
        </a>
    </div>

    <div class="ag_subtitulo">
        <h2 class="">Listado de Empleados</h2>
    </div>
    <div class="ag_contenedor">
        <button class="btn btn-success mb-2" data-toggle="modal" data-target="#addUserModal">Agregar Usuario</button>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>DNI</th>
                <th>Estado</th>
                <th>Sucursal</th>
                <th>Rol</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include 'conexion.php';
            $conn = conectar();
            $sql = "SELECT u.*, r.rol_desc, s.suc_nombre FROM usuarios u 
                    LEFT JOIN roles r ON u.rol_id = r.rol_id 
                    LEFT JOIN sucursales s ON u.suc_id = s.suc_id
                    WHERE u.rol_id != 1";

                    
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["usu_id"]. "</td>
                            <td>" . $row["usu_nombre"]. "</td>
                            <td>" . $row["usu_apellido"]. "</td>
                            <td>" . $row["usu_correo"]. "</td>
                            <td>" . $row["usu_telefono"]. "</td>
                            <td>" . $row["usu_dni"]. "</td>
                            <td>" . ($row["usu_estado"] ? 'Activo' : 'Inactivo') . "</td>
                            <td>" . $row["suc_nombre"]. "</td>
                            <td>" . $row["rol_desc"]. "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='text-center'>No hay usuarios registrados</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="modal_crear.php" method="POST" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-Z\s]{1,30}" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" pattern="[a-zA-Z\s]{1,30}" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI:</label>
                            <input type="number" class="form-control" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="dni" name="dni" required>
                        </div>
                        <div class="form-group">
                            <label for="sucursal">Sucursal:</label>
                            <select class="form-control" id="sucursal" name="sucursal" required>
                                <?php
                                $conn = conectar();
                                $suc_query = "SELECT * FROM sucursales";
                                $suc_result = $conn->query($suc_query);
                                while($suc_row = $suc_result->fetch_assoc()) {
                                    echo "<option value='" . $suc_row['suc_id'] . "'>" . $suc_row['suc_nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol:</label>
                            <select class="form-control" id="rol" name="rol" required>
                                <?php
                                $rol_query = "SELECT * FROM roles WHERE rol_id>1;";
                                $rol_result = $conn->query($rol_query);
                                while($rol_row = $rol_result->fetch_assoc()) {
                                    echo "<option value='" . $rol_row['rol_id'] . "'>" . $rol_row['rol_desc'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Agregar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Script para limpiar el formulario al cerrar el modal -->
<script type="text/javascript">
$(document).ready(function(){
    
    $('#addUserModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });
});
</script>

<?php
if(isset($_GET['insertExitoso'])){
?>
    <script>
        window.alert("Se Registro el usuario de forma exitosa!");
    </script>
<?php
}

if(isset($_GET['error'])){
?>
<script>
    window.alert("<?php echo htmlspecialchars($_GET['error']); ?>");
</script>
<?php
}

?>

</body>
</html>