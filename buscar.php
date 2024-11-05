<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 02){

    require "conexion.php";
    $conn=conectar();


}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}

    $buscador=isset($_POST['buscador']) ? $conn->real_escape_string($_POST['buscador']) : null;

    $and='';

    if($buscador != null){

        $and = "AND(";
        $and .="lib_nombre LIKE '%".$buscador."%'";
        //$where = substr_replace($where, "", -3);
        $and .=")";
      
    }

    $select="SELECT lib_id, lib_nombre, lib_precio, lib_stock_disponible FROM libros WHERE lib_estado=01 AND lib_stock_disponible>1 $and;";

    $resulset=mysqli_query($conn, $select);

    $html='';

    if(mysqli_affected_rows($conn) > 0){

        while($registro=mysqli_fetch_assoc($resulset)){

            $html .= "<tr>";
            $html .= "<td>".$registro['lib_nombre']."</td>";
            $html .= "<td>".$registro['lib_precio']."</td>";
            $html .= "<td>".$registro['lib_stock_disponible']."</td>";
            //$html .= "<td><button type='button'>Elegir</button></td>";
            $html .= "<td><form action='' method='POST'>";
            $html .= '<input type="hidden" name="lib_id" value='.$registro['lib_id'].'>';
            $html .= '<input type="hidden" name="lib_nombre" value="'.$registro['lib_nombre'].'">';
            $html .= '<input type="hidden" name="lib_precio" value="'.$registro['lib_precio'].'">';
            $html .= '<input type="hidden" name="lib_stock" value="'.$registro['lib_stock_disponible'].'">';
            $html .= '<input type="submit" value="Elegir">';
            $html .= "</form></td>";
            $html .= "</tr>";
            
        }
        


    }else{
        $html .= "<tr>";
        $html .= '<td colspan="7">Sin Resultados</td>';
        $html .= "</tr>";
    }

    echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>