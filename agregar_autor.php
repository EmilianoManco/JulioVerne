<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); 

require "conexion.php";
$conn = conectar();

$name = isset($_POST['name']) ? $_POST['name'] : '';
if ($name === '') {
    echo json_encode(array('error' => 'Nombre del autor no proporcionado'));
    exit();
}

// Obtener el último ID de la tabla de autores
$select = "SELECT MAX(aut_id) AS ultimo_id FROM autores;";
$resulset = mysqli_query($conn, $select);

if ($resulset && mysqli_num_rows($resulset) > 0) {
    $row = mysqli_fetch_assoc($resulset);
    $ultimoID = $row['ultimo_id'] + 1; // Incrementar el último ID

    // Insertar el nuevo autor
    $insert = "INSERT INTO autores (aut_id, aut_desc) VALUES ('$ultimoID', '$name');";
    if ($conn->query($insert) === TRUE) {
        $response = array('aut_id' => $ultimoID, 'aut_desc' => $name);
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Error al insertar el autor: ' . $conn->error));
    }
} else {
    echo json_encode(array('error' => 'Error al obtener el último ID de la tabla'));
}
?>
