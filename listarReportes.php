<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01 or $_SESSION['rol'] == 03){

    //el usuario con el rol admin o contador puede ingresar a esta pagina


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
    <link rel='preload' href='normalize.css' as='style'>
    <link rel='preload' href='contaduria.css' as='style'>
    <title>Listar Reportes</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="contaduria.css">
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
    <main id="lis_rep">
        <div class="btn_volver">
            <?php if($_SESSION['rol'] == 01){
                 ?><a href="administrador.php">
                 <button class="volver">Volver</button>
                </a> <?php
            }else{
              ?>  <a href="contaduria.php">
                <button class="volver">Volver</button>
                </a>
            <?php
            }

            ?>
        </div>

        <div class="lr_contenedor">
            <h4 class="lr_subtitulo">Listado de los Reportes</h4>
<?php
/**
 * Funcion que muestra la estructura de carpetas a partir de la ruta dada.
 */

function obtener_estructura_directorios($ruta){
    // Se comprueba que realmente sea la ruta de un directorio
    if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);
        echo "<ul class='lr_listar'>";

        // Recorre todos los elementos del directorio
        while (($archivo = readdir($gestor)) !== false)  {
                
            $ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
            if ($archivo != "." && $archivo != "..") {
                // Si es un directorio se recorre recursivamente
                if (is_dir($ruta_completa)) {
                    echo "<li>" . $archivo . "</li>";
                    obtener_estructura_directorios($ruta_completa);
                } else {
                    //echo "<li>" . $archivo . "</li>";
                    echo "
                    <li>
                        <form class='lr_formulario' action='ver_pdf.php' method='GET' target='_blank'>
                        <input type='hidden' name='archivo' value='" . urlencode($ruta_completa) . "'>
                        <input type='text' readonly value='".$archivo."'>
                        <input type='submit' value='Ver'>
                        </form>
                    </li>
                    ";
                }
            }
        }
        
        // Cierra el gestor de directorios
        closedir($gestor);
        echo "</ul>";
    } else {
        echo "No es una ruta de directorio valida";
    }
}

obtener_estructura_directorios("pdfs");//Ruta completa 

?>
        </div>
    </div>





</main>


</body>
</html>