<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

    require "conexion.php";
    $conn=conectar();


}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}



$buscador=isset($_POST['buscar']) ? $conn->real_escape_string($_POST['buscar']) : null;

$and = '';

if($buscador != null){
    
        $and = "AND (";
        $and .="lib_nombre LIKE '%".$buscador."%'";
        $and .=")";
}

$select="SELECT lib_id, lib_nombre, lib_stock_disponible FROM libros WHERE lib_estado=1 $and;";

$resulset=mysqli_query($conn, $select);

$html='';

    if(mysqli_affected_rows($conn) > 0){

        while($registro=mysqli_fetch_assoc($resulset)){

            $html .= "<tr>";
            $html .= "<td>".$registro['lib_nombre']."</td>";
            $html .= "<td>".$registro['lib_stock_disponible']."</td>";
            $html .= "<td><button type='button' class='btn btn-primary' data-id='".$registro['lib_id']."' data-bs-toggle='modal' data-bs-target='#modalContainer' onclick='loadModal(" . $registro['lib_id'] . ")'>Actualizar</button></td>";
            $html .= "</tr>";
            
        }
        
    }else{
        $html .="<tr>";
        $html .= "<td colspan='7'>Sin Resultados en la busqueda</td>";
        $html .="</tr>";
    }

    echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>