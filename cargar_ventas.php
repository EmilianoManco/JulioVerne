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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estiloCargar_Ventas.css">
    <title>Cargar Ventas</title>
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

<main>
    <div class="btn_volver">
        <a href="empleado.php">
            <button class="volver">Volver</button>
        </a>
    </div>
    <div class="contenedor">
        <div class="buscador">
            <h4>Cargar Venta</h4>
            <button type="button" class="btn-cargar" id="agregar" data-bs-toggle="modal" data-bs-target="#agregarLibro">Agregar al Carrito</button>
            <?php  include('modal_agregarLibro_Ventas.php'); ?>
        </div>


<?php

// Detectar si se ha presionado el botón de cancelar
if (isset($_POST['cancelar'])) {
    // Borrar la variable de sesión 'libros'
    unset($_SESSION['libros']);
}

if (!isset($_SESSION['libros'])) {
    $_SESSION['libros'] = [];
}

if(isset($_POST['lib_id']) and isset($_POST['lib_nombre']) and isset($_POST['lib_precio']) and isset($_POST['lib_stock'])){
    $id=$_POST['lib_id'];
    $nombre=$_POST['lib_nombre'];
    $precio=$_POST['lib_precio'];
    $stock=$_POST['lib_stock'];

    // Verificar si el libro ya existe en la sesión
    $libro_existente = false;
    foreach($_SESSION['libros'] as $libro) {
        if($libro['id'] == $id) {
            $libro_existente = true;
            break;
        }
    }

    // Si el libro no existe, agregarlo a la sesión
    if (!$libro_existente) {
        $_SESSION['libros'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'stock' => $stock
        ];
    }


   
?>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <!--<th scope="col">#</th>-->
      <th scope="col">Nombre</th>
      <th scope="col">Precio</th>
      <th scope="col">Cantidad de Libros</th>
    </tr>
  </thead>
  <tbody>
    <form action="venta.php" method="POST">
<?php
    foreach($_SESSION['libros'] as $libro):?>
    <tr>
      <!--<td><?php //echo $libro['id']; ?></td> -->
      <input type="hidden" name="id[]" value="<?php echo $libro['id']; ?>"> 
      <!--<td><?php //echo $libro['nombre']; ?></td> -->
      <td><input type="text" name="nombre[]" readonly value="<?php echo $libro['nombre']; ?>"></td>
      <!--<td><?php //echo $libro['precio']; ?></td>-->
      <td><input type="number" name="precio[]" readonly value="<?php echo $libro['precio']; ?>"></td> 
      <!--<td><?php //echo $libro['stock']; ?></td> --> 
      <td><input type="number" name="cantidad[]" min="1" max="<?php echo $libro['stock']; ?>" required></td>
    </tr>
<?php endforeach;  ?> 
  </tbody>
</table>

<div class="totales">
    <div class="total">
        <h5>Total:</h5>
    </div>
    <div class="total_precio">
        <!--<h5>Precio Total: $<span id="precioTotal">0.00</span></h5>-->
        <h5>Precio: $</h5><input type="number" name="precioTotal" readonly id="precioTotal">
    </div>
    <div class="total_libros">
        <!--<h5>Cantidad Total de Libros :<span id="totalLibros">0</span></h5>--> 
        <h5>Libros:</h5><input type="number" name="totalLibros" readonly id="totalLibros">
    </div>
</div>

<button type="submit" class="btn-confirmar">Confirmar</button>
</form> 


<!-- cancelaar venta -->
<form class="btn-danger" action="" method="POST">
    <button type="submit" class="btn-danger" name="cancelar" value="1">Cancelar</button>
</form>
<?php
}


?>


    </div>

<?php
if(isset($_GET['ventaExitosa'])){
?>
<script>
    window.alert("¡Venta registrada correctamente!");
</script>
<?php
}

?>


</main>

<script>
/*PARA SABER SI SE RECARGO LA PAGINA
window.onbeforeunload = function(e) {
    //return "Se recargo la pagina";
    <?php //unset($_SESSION['libros']); ?>
};*/

document.addEventListener("DOMContentLoaded", function() {
    // Seleccionar todos los campos de cantidad
    const precioInputs = document.querySelectorAll('input[name="precio[]"]');
    const cantidadInputs = document.querySelectorAll('input[name="cantidad[]"]');
    const precioTotalElement = document.getElementById('precioTotal');

    function calcularPrecioTotal() {
        let precioTotal = 0;
        cantidadInputs.forEach((input, index) => {
            const cantidad = parseInt(input.value) || 0;
            const precio = parseFloat(precioInputs[index].value) || 0;
            //const precio = parseFloat(input.closest('tr').querySelector('input[name="precio"]').value);
            precioTotal += cantidad * precio;
        });
        precioTotalElement.value = precioTotal;
    }

    // Añadir un evento para recalcular el precio total cuando cambie la cantidad
    cantidadInputs.forEach(function(input) {
        input.addEventListener('input', calcularPrecioTotal);
    });

    // Calcular el precio total al cargar la página
    calcularPrecioTotal();

        //const cantidadInputs = document.querySelectorAll('input[name="cantidad"]');
        const totalLibrosElement = document.getElementById('totalLibros');

        function calcularTotalLibros(){
            let totalLibros = 0;
            cantidadInputs.forEach((input) =>{
                const cantidad = parseInt(input.value) || 0;
                totalLibros += cantidad;
            });
            totalLibrosElement.value = totalLibros;
        }

        // Añadir un evento para recalcular el total de libros cuando cambie la cantidad
        cantidadInputs.forEach(function(input) {
        input.addEventListener('input', calcularTotalLibros);
        });

        // Calcular el total de libros al cargar la página
        calcularTotalLibros();




});


</script>



</body>
</html>
