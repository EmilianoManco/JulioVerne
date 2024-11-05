<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

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
    <title>Controlar Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estiloControlStock.css">
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
    <button class="volver">Volver</button>
</a>


<main>

    <div class="gestionar">
        <div class="buscador">
            <h4>Controlar Stock</h4>
            <form action="buscador.php">
                <input type="text" name="buscar" id="buscar" placeholder="Nombre del Libro" autocomplete="off">
                <button type="submit" disabled hidden aria-hidden="true"></button>
            </form>
        </div>
        <div class="tabla">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nombre del Libro</th>
                        <th scope="col">Stock Disponible</th>
                        <th scope="col">Agregar</th>
                    </tr>
                </thead>
                <tbody id="content">

                </tbody>
            </table>
        </div>
    </div>


</main>

<div class="modal fade" id="modalContainer" tabindex="-1" role="dialog" aria-labelledby="modalContainerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalContent">
            <!-- Aquí se cargará el contenido del modal_stock.php -->
        </div>
    </div>
</div>

<?php
if(isset($_GET['updateExitoso'])){
?>
    <script>
      window.alert("Se Actualizo el stock del Libro de forma Exitosa!");
   </script>
<?php
}

?>

<script>

    function loadModal(lib_id) { //esto sirve para mostrar la ventana modal_stock.php
        let url = 'modal_stock.php';
        $.ajax({
            url: url,
            type: 'GET',
            data: { id: lib_id },
            success: function(data) {
                $('#modalContent').html(data);
                $('#modalContainer').modal('show');
                //let modalInstance = new bootstrap.Modal(document.getElementById('modalContainer'));
                //modalInstance.show();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
    getData();

    document.getElementById("buscar").addEventListener("keyup", getData);

    function getData() {
        let inputElement = document.getElementById("buscar");
        let contentElement = document.getElementById("content");

        if (inputElement && contentElement) { //aca muestro la tabla con los datos de buscador.php
            let input = inputElement.value;
            let url = "buscador.php";
            let formaData = new FormData();
            formaData.append('buscar', input);

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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    
</body>
</html>