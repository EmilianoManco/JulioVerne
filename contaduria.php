<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 03){

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
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='contaduria.css' as='style'>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="contaduria.css">    
    <title>Contaduria | Julio Verne</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Julio Verne Logo">
        </div>
        <h1 class="nombre-empresa">Libreria Julio Verne</h1>
        <div class="nameandclose">
            <form class="logout" action="index.php" method="POST">
                <div class="nomb">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                    </svg>
                    <p>
                    <?php echo "".$_SESSION['nombre'];?>
                    </p>
                </div>
                <div class="desaparecer">
                    <input class="logout__btn" type="submit" value="Cerrar Sesión">
                </div>
            </form>
        </div>
    </header>
    <main id="contaduria">
        <div class="padre">
            <div class="c_contenedor">
                <h4>Generar Reportes</h4>
                <p class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                        <path d="M18 14v4h4" />
                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                        <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M8 11h4" />
                        <path d="M8 15h3" />
                    </svg>
                </p>
                <a href="generarReporte.php"><button>Continuar</button></a>
            </div>
            <div class="c_contenedor">
                <h4>Listado Reportes</h4>
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