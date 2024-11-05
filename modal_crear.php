<?php
include 'conexion.php';
$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $dni = mysqli_real_escape_string($conn, $_POST['dni']);
    $telefono = $_POST["telefono"];
    $sucursal = $_POST["sucursal"];
    $rol = $_POST["rol"];
    $clave = $dni; 

    //Aca tomo los ultimos 4 numeros del DNI y lo guardo en la variable clave
    $clave = substr($dni, -4);

    //Validar si el email o el dni ingresado por el usuario no este ya en la BD

    $select="SELECT usu_correo, usu_dni FROM usuarios WHERE usu_correo='$correo' OR usu_dni='$dni';";

    $resulset=mysqli_query($conn, $select);

    // Verificar si hay resultados
if (mysqli_num_rows($resulset) > 0) {
    $fila = mysqli_fetch_assoc($resulset);
    
    // Verificar si es el correo o el DNI el que está duplicado
    if ($fila['usu_correo'] === $correo) {
        $mensaje = "El correo ya está registrado: " . $fila['usu_correo'];
    } elseif ($fila['usu_dni'] === $dni) {
        $mensaje = "El DNI ya está registrado: " . $fila['usu_dni'];
    }
    
    // Redirigir a la página anterior con el mensaje de error
    header("Location: agregar_empleado.php?error=" . urlencode($mensaje));
    exit;

}else{

    $sql = "INSERT INTO usuarios (usu_nombre, usu_apellido, usu_correo, usu_clave, usu_telefono, usu_dni, usu_estado, suc_id, rol_id) 
            VALUES ('$nombre', '$apellido', '$correo', '$clave', '$telefono', '$dni', 1, '$sucursal', '$rol')";

    if ($conn->query($sql) === TRUE) {
        header("Location: agregar_empleado.php?insertExitoso");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

}
