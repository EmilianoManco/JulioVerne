<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01){

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
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='administrador.css' as='style'>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="administrador.css">
    <title>Admin | Julio Verne</title>

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
            <h4>Agregar Empleados</h4>
            <p class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>
            </p>
            <a href="agregar_empleado.php"><button>Continuar</button></a>
        </div>
        <div class="contenedor">
            <h4>Gestionar Empleados</h4>
            <p class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-laptop" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 19l18 0" />
                    <path d="M5 6m0 1a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1z" />
                </svg>
            </p>
            <a href="gestionar_empleados.php"><button>Continuar</button></a>
        </div>
        <div class="contenedor">
            <h4>Listado de Reportes</h4>
            <p class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-search" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M18.5 18.5l2.5 2.5" />
                    <path d="M4 6h16" />
                    <path d="M4 12h4" />
                    <path d="M4 18h4" />
                </svg>
            </p>
            <a href="listarReportes.php"><button>Visualizar</button></a>
        </div>
    </div>


</main>






</body>
</html>