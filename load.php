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

    $where = '';
    $and= '';

    if($buscador != null){

        /*$where = "WHERE (";
        $where .="lib_nombre LIKE '%".$buscador."%' OR aut_desc LIKE '%".$buscador."%'";
        //$where = substr_replace($where, "", -3);
        $where .=")";*/
        
        $and ="AND(";
        $and .="lib_nombre LIKE '%".$buscador."%' OR aut_desc LIKE '%".$buscador."%'";
        $and .=")";
    }

    $select="SELECT 
    libros.lib_id, 
    libros.lib_nombre, 
    libros.lib_anio_publicacion, 
    libros.lib_estado, 
    libros.gen_id, 
    generos.gen_desc, 
    libros.edi_id, 
    editoriales.edi_desc, 
    /*aut_x_libr.aut_id, */
    autores.aut_id, 
    autores.aut_desc
FROM 
    julioVerne.libros
INNER JOIN 
    julioVerne.generos ON libros.gen_id = generos.gen_id
INNER JOIN 
    julioVerne.editoriales ON libros.edi_id = editoriales.edi_id
LEFT JOIN 
    julioVerne.aut_x_libr ON libros.lib_id = aut_x_libr.lib_id
LEFT JOIN 
    julioVerne.autores ON aut_x_libr.aut_id = autores.aut_id WHERE libros.lib_estado=01 $and";

    $resulset=mysqli_query($conn, $select);

    $html='';

    if(mysqli_affected_rows($conn) > 0){

        while($registro=mysqli_fetch_assoc($resulset)){

            $html .= "<tr>";
            $html .= "<td class='uppercase'>".$registro['lib_nombre']."</td>";
            $html .= "<td>".$registro['aut_desc']."</td>";
            $html .= "<td>".$registro['gen_desc']."</td>";
            $html .= "<td>".$registro['edi_desc']."</td>";
            $html .= "<td><button type='button' class='btn btn-primary' data-id='" . $registro['lib_id'] . "' data-bs-toggle='modal' data-bs-target='#modalContainer' onclick='loadModal(" . $registro['lib_id'] . ")'>Modificar</button></td>";
            //$html .="<td><button type='button' class='btn btn-primary' data-id='".$registro['lib_id']."' data-bs-toggle='modal' data-bs-target='#modal_EliminarLibro".$registro['lib_id']."'>Eliminar</button></td>";
            //$html .= "<td><button type='button' class='btn btn-danger' data-id='" . $registro['lib_id'] . "' data-bs-toggle='modal' data-bs-target='#modal_EliminarLibro" . $registro['lib_id'] . "'>Eliminar</button></td>";
            $html .= "<td><button type='button' class='btn btn-danger' data-id='" . $registro['lib_id'] . "' onclick='loadModal(" . $registro['lib_id'] . ", true)'>Eliminar</button></td>";
            $html .= "</tr>";
            
        }
        


    }else{
        $html .= "<tr>";
        $html .= '<td colspan="7">Sin Resultados</td>';
        $html .= "</tr>";
    }

    echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>