<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

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
    <link rel="stylesheet" href="estilo_gestionar_libros.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gestionar Libros | Julio Verne</title>
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
<a href="empleado.php">
    <button class="volver">
        <label for="">Volver</label>
    </button>
</a>
    
<main>   
    <div class="main">
        <div class="buscador">
            <h4>Buscar Libro</h4>
            <form action="load.php">
                <input type="text" name="buscador" id="buscador" placeholder="Nombre de Libro o Autor" autocomplete="off">
                <button type="submit" disabled hidden aria-hidden="true"></button>
            </form>
        </div>
        <div class="agregarLibro">
            <button type="button" class="btn btn-success" id="agregar" data-bs-toggle="modal" data-bs-target="#agregarLibro"><p><br>Agregar<br>Libro +</p></button>
            <?php include("modal_agregar_libro.php"); ?>
        </div>
    </div>
    <div>
        <table class="table table-dark table-hover">
            <tr>
                <th>Nombre Libro</th>
                <th>Autor</th>
                <th>Genero</th>
                <th>Editorial</th>
                <th></th>
                <th></th>
            </tr>
            <tbody id="content">
                
            </tbody>
        </table>
    </div>

<!-- Contenedor del modal LE FALTA EL data-bs-backdrop="static" -->
<div class="modal fade" id="modalContainer" tabindex="-1" role="dialog" aria-labelledby="modalContainerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalContent">
            <!-- Aquí se cargará el contenido del modal -->
        </div>
    </div>
</div>


<?php
if(isset($_GET['insertExitoso'])){
?>
    <script>
        window.alert("Se Ingreso el Libro de forma Exitosa!");
    </script>
<?php
}

if(isset($_GET['editLibro'])){
?>
    <script>
        window.alert("Se Modificaron los Datos del Libro de Forma Exitosa!");
    </script>

<?php
}

if(isset($_GET['deleteExitoso'])){
?>
    <script>
        window.alert("Se Elimino el Libro de Forma Exitosa!");
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


</main>


<script>
    /*document.addEventListener('DOMContentLoaded', (event) => {
        getData()

        function getData(){

        
        let input = document.getElementById("buscador").value;
        let content = document.getElementById("content");
        let url = "load.php";
        let formaData = new formData();
        formaData.append('buscador', input);

        fetch(url, {
            method : "POST",
            body : formaData
        }).then(response => response.json())
        .then(data => {
            content.innerHTML = data;
        }).catch(error => console.log(error));

        }
    
    });*/

    function loadModal(lib_id, isDelete = false) { //esto sirve para mostrar tanto la ventana modal para modificar o eliminar un libro
        let url = isDelete ? 'modal_Eliminar_Libro.php' : 'modal_EditarLibro.php';
        $.ajax({
            url: url,
            type: 'GET',
            data: { id: lib_id },
            success: function(data) {
                $('#modalContent').html(data);
                $('#modalContainer').modal('show');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
    getData();

    document.getElementById("buscador").addEventListener("keyup", getData);

    function getData() {
        let inputElement = document.getElementById("buscador");
        let contentElement = document.getElementById("content");

        if (inputElement && contentElement) { //aca muestro la tabla con los datos de load.php
            let input = inputElement.value;
            let url = "load.php";
            let formaData = new FormData();
            formaData.append('buscador', input);

            fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
            .then(data => {
                contentElement.innerHTML = data;
            }).catch(error => console.log(error));
        } else {
            console.error("Elementos no encontrados en el DOM.");
        }
    }
});


</script>


<!-- jQuery y Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>