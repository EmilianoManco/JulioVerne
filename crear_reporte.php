<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 03){

    require_once('tcpdf/tcpdf.php'); //Llamando a la Libreria TCPDF
    require "conexion.php";
    $conn=conectar();
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $hora=date("G:i");
    $fechaYhoraActual=date("Y_m_d_G_i");

}else{
    echo "<h4>ACCESO NO AUTORIZADO</h4>";
    exit();
}

    $sucursal=$_POST['sucursal'];
    $date1=$_POST['date1'] ?? '';
    $date2=$_POST['date2'] ?? '';
    $semana=$_POST['semana'] ?? '';
    $mes=$_POST['mes'] ?? '';

    if($date1 != '' and $date2 != ''){ //Si son distinto de vacio significa que llegaron los datos

        //Los cargo en las variables $fechaInicio y $fechaFinal que son las que uso en el SELECT
        $fechaInicio = $date1;
        $fechaFinal = $date2;

    }

    if($semana != ''){ //Si es distinto de vacio significa que llego el dato

    // Obtener el año y el número de la semana
    list($anio, $semana) = explode('-W', $semana);

    // Crear un objeto DateTime con el primer día del año y ajustar al primer lunes
    $date = new DateTime();
    $date->setISODate((int)$anio, (int)$semana); // Establecer el año y la semana

    // Obtener la fecha de inicio (lunes)
    $fechaInicio = $date->format('Y-m-d');

    // Obtener la fecha de fin (domingo)
    $date->modify('+6 days');
    $fechaFinal = $date->format('Y-m-d');

    }

    if($mes != ''){

        // Crear un objeto DateTime con el primer día del mes
        $fechaInicio = new DateTime($mes . '-01'); // Establecer el primer día del mes

        // Clonar el objeto de fecha para no modificar el original
        $Final = clone $fechaInicio;
    
        // Modificar para obtener el último día del mes
        $Final->modify('last day of this month');

        $fechaFinal = $Final->format('Y-m-d');
        $fechaInicio = $fechaInicio->format('Y-m-d');
    }

    //echo $sucursal." ".$fechaInicio." ".$fechaFinal;

    // voy a necesitar : NOMBRE DEL LIBRO, CANTIDAD DE LIBROS, PRECIO
    $select="SELECT 
    ventas_cabecera.cab_id, 
    ventas_cabecera.suc_id, 
    ventas_cabecera.cab_fecha, 
    ventas_cabecera.cab_precio_total,
    /*ventas_detalle.cab_id,*/
    ventas_detalle.lib_id,
    ventas_detalle.det_cantidad,
    ventas_detalle.det_precio,
    /*sucursales.suc_id,*/
    sucursales.suc_nombre,
    /*libros.lib_id,*/
    libros.lib_nombre
    FROM 
        julioVerne.ventas_cabecera 
    INNER JOIN 
        julioVerne.ventas_detalle ON ventas_cabecera.cab_id = ventas_detalle.cab_id
    INNER JOIN
        julioVerne.sucursales ON ventas_cabecera.suc_id = sucursales.suc_id
    INNER JOIN
        julioVerne.libros ON ventas_detalle.lib_id = libros.lib_id 
    WHERE (ventas_cabecera.cab_fecha>='$fechaInicio' AND ventas_cabecera.cab_fecha<='$fechaFinal' AND suc_nombre='$sucursal') ORDER BY ventas_cabecera.cab_fecha ASC;";

    $resultado=mysqli_query($conn, $select);

    if(mysqli_affected_rows($conn) > 0){


//CONFIGURO LAS COSAS BASICAS DEL PDF
class MYPDF extends TCPDF{
    /*
    public function Header() {
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
        $img_file = dirname( __FILE__ ) .'/img/Julio_Verne_Logo.jpg';
        $this->Image($img_file, 85, 8, 40, 35, '', '', '', false, 30, '', false, false, 0);
        //EN IMAGE LOS PRIMERO 2 NUMEROS HACEN REFERENCIA AL EJE DE CORDENADAS (X-Y) Y LOS OTROS 2 NUMEROS AL TAMAÑAO DE LA IMAGEN
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();
        
    }*/
}

//Iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);

//Establecer margenes del PDF
$pdf->SetMargins(20, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false); //Eliminar la linea superior del PDF por defecto
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //Activa o desactiva el modo de salto de página automático

//Informacion del PDF
$pdf->SetCreator('LibreriaJulioVerne');
$pdf->SetAuthor('Contaduria');
$pdf->SetTitle('Reporte');



/** Eje de Coordenadas
 *          Y
 *          -
 *          - 
 *          -
 *  X ------------- X
 *          -
 *          -
 *          -
 *          Y
 * 
 * $pdf->SetXY(X, Y);
 */

//Agregando la primera página
$pdf->AddPage();
/*$pdf->SetFont('helvetica','B',10); Tipo de fuente y tamaño de letra */
$pdf->SetXY(140, 25);
$pdf->Write(0, "Fecha: $fechaInicio");
$pdf->SetXY(140, 30);
$pdf->Write(0, "hasta: $fechaFinal");
$pdf->SetXY(140, 35);
$pdf->Write(0, "Hora: $hora");
$pdf->SetXY(15, 25);
$pdf->Write(0, 'Libreria Julio Verne');
$pdf->ln(5);
$pdf->setXY(15, 30);
$pdf->write(0, "Sucursal : $sucursal");
$logo = dirname( __FILE__ ) .'/img/Julio_Verne_Logo.jpg';
$pdf->Image($logo, 85, 8, 40, 35); //Primeros 2 corresponden a los ejes x/y, los otros 2 numeros es el tamaño de la imagen


$pdf->Ln(30); //Salto de Linea

$pdf->SetFont('helvetica','B', 15);
$pdf->SetTextColor(34,68,136); 
$pdf->Cell(170,6,'REPORTE',0,1,'C'); // LOS PRIMOS 2 NUMEROS PARA LOS EJES(X Y) 
//^^^ENTRE COMILLAS SIMPLE LO Q QUIERO Q SE MUESTRE, EL PRIMER NUMERO HACE REFERENCIA SI QUEREMOS BORDE (1 O 0)

$pdf->ln(10); //salto de linea

//ARMAR TABLA

//Armando la cabecera de la Tabla
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //La B es para letras en Negritas
//$pdf->Cell(35,6,'N° de Factura',1,0,'C',1);
$pdf->Cell(30,6,'Fecha',1,0,'C',1);
$pdf->Cell(73,6,'Libro',1,0,'C',1);
$pdf->Cell(40,6, 'Cant. Libros',1,0,'C',1);
$pdf->Cell(35,6,'Precio',1,0,'C',1);

$pdf->ln(6); //Salto de linea

$pdf->SetTextColor(0, 0, 0,); //Defino otro color para los datos dentro de la tabla
$pdf->SetFont('helvetica','',10);//Defino otro tipo de letra para los datos
$total = 0;

while($registro=mysqli_fetch_assoc($resultado)){

//Armando la tabla con los datos
$pdf->Cell(30,6,($registro['cab_fecha']),1,0,'C');
$pdf->Cell(73,6,($registro['lib_nombre']),1,0,'C');
$pdf->Cell(40,6,($registro['det_cantidad']),1,0,'C');
$pdf->Cell(35,6,('$ '. $registro['det_precio']),1,1,'C');

//realizo la cuenta para saber la cantidad total de dinero recaudado

$cantidadLibro = intval($registro['det_cantidad']);
$precioLibro = intval($registro['det_precio']);


$total = $cantidadLibro * $precioLibro + $total;

}

$pdf->ln(0); //salto de linea

//Armando la celda al final para calcular el total
//$pdf->SetFillColor(232,232,232);
$pdf->SetTextColor(196, 35, 0);
$pdf->SetFont('helvetica','B',13); 

$pdf->Cell(143,6,'TOTAL',1,0,'C');
$pdf->Cell(35,6,('$ '. $total),1,0,'C');

// Ruta de la carpeta donde se guardará el PDF
$folderPath = __DIR__ . '/pdfs/';

$nombrePDF='Reporte_' . $fechaYhoraActual . '.pdf';

$pdf->Output($folderPath.$nombrePDF, 'F'); 
// Output funcion que recibe 2 parameros, el nombre del archivo, ver archivo o descargar,
// La D es para Forzar una descarga

$pdf->Output($folderPath.$nombrePDF, 'I');


}else{
    //PENSAR ESTA PARTE PORQ ME GENERA 2 PESTAÑAS
    header("location:generarReporte.php?sinDatos");
}


?>