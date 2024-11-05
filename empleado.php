<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

    $id=$_SESSION['id'];
    $rol=$_SESSION['rol'];

    $passControl=substr($_SESSION['dni'], -4);

    if($_SESSION['clave'] == $passControl){
        header("location:cambiarClave.php?id=$id&rol=$rol");
    }

}else{
echo "ACCESO NO AUTORIZADO";
exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado | Julio Verne</title>
    <link rel="stylesheet" href="empleado.css">
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
    <div class="padre">
        <div class="contenedor">
            <h4>Cargar Venta</h4>
                <p class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17h-11v-14h-2" />
                        <path d="M6 5l14 1l-1 7h-13" />
                    </svg>
                </p>
            <!--<img src="icono/carrito.png" alt="carrito">-->
            <a href="cargar_ventas.php"><button>Continuar</button></a>
        </div>
        <div class="contenedor">
            <h4>Gestionar Libros</h4>
            <p class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-books" width="300" height="300" viewBox="0 0 24 24" stroke-width="1" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                    <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                    <path d="M5 8h4" />
                    <path d="M9 16h4" />
                    <path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                    <path d="M14 9l4 -1" />
                    <path d="M16 16l3.923 -.98" />
                </svg>
            </p>
            <!--<img src="icono/libros.png" alt="libros">-->
            <a href="gestionarLibros.php"><button>Continuar</button></a>
        </div>
        <div class="contenedor">
            <h4>Stock</h4>
            <p class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-search" width="300" height="300" viewBox="0 0 24 24" stroke-width="1" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                    <path d="M18 12v-5a2 2 0 0 0 -2 -2h-2" />
                    <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    <path d="M8 11h4" />
                    <path d="M8 15h3" />
                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                    <path d="M18.5 19.5l2.5 2.5" />
                </svg>
            </p>
            <!-- <img src="icono/stock.png" alt="stock"> -->
            <a href="controlarStock.php"><button>Continuar</button></a>
        </div>
    </div>



</main>



    
</body>
</html>