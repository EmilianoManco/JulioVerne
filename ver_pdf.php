<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 01 or $_SESSION['rol'] == 03){

}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}
if (isset($_GET['archivo'])) {
    $archivo = urldecode($_GET['archivo']);

    // Verifica que el archivo exista
    if (file_exists($archivo)) {
        // Muestra el PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($archivo) . '"');
        readfile($archivo);
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "No se especificó un archivo.";
}
?>