<?php
session_start();
if(isset($_SESSION['id']) and $_SESSION['rol'] == 03){

    require "conexion.php";
    $conn=conectar();

}else{
    echo "<h3>ACCESO NO AUTORIZADO!</h3>";
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
    <title>Generar Reporte | Julio Verne</title>
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
    <main id="gen_rep">
        <div class="btn_volver">
            <a href="contaduria.php">
                <button class="volver">Volver</button>
            </a>
        </div>
        <div class="gr_contenedor">
            <form class="gr_formulario" action="crear_reporte.php" onsubmit="return validarFechas()" target="_blank" method="POST">
                
                <h4 class="gr_subtitulo">Generar Reporte</h4>

                <div class="gr_fechas">
                    <div class="gr_sucursal">
                        <label for="sucursal"><p>Sucursal</p></label>
                        <?php 
                        $select="SELECT * FROM sucursales;";
                        $resultado=mysqli_query($conn, $select);
                        ?>
                        <select name="sucursal" id="sucursal" required>
                            <option value="" disabled selected>Selecione una sucursal...</option>
                            <?php
                            while($registro=mysqli_fetch_assoc($resultado)){
                        ?>
                            <option value="<?php echo $registro['suc_nombre']; ?>"><?php echo $registro['suc_nombre']; ?></option>
                        <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="gr_fecha_desde_hasta">
                        <label for="date1"><p>Seleccione por Fecha</p></label>
                        <div class="dh">
                            <label for="date1"><p>Desde</p></label>
                            <input type="date" name="date1" id="date1" max="<?= date("Y-m-d"); ?>">
                        </div>
                        <div class="dh">
                            <label for="date2"><p>Hasta</p></label>
                            <input type="date" name="date2" id="date2" max="<?= date("Y-m-d"); ?>">
                        </div>
                    </div>
                        
                    <div class="gr_semana">
                        <label for="week"><p>Seleccione por Semana</p></label>
                        <input type="week" name="semana" id="week" max="<?= date("Y-\WW"); ?>">
                    </div>
                        
                    <div class="gr_mes">
                        <label for="month"><p>Seleccione por Mes</p></label>
                        <input type="month" name="mes" id="month"max="<?= date("Y-m"); ?>">
                    </div>
                </div>
                    
                <input class="gr_btn" type="submit" value="Generar">            

            </form>
            <?php
            if(isset($_GET['sinDatos'])){
            ?>
            <script>
                window.alert("No se puede generar el Reporte porque no se encontraron datos en la fecha seleccionada!");
            </script>

            <?php
            }
            ?>

        </div>
    </main>

    <script>
        function validarFechas() {
            // Obtener los valores de las fechas
            var fecha1 = document.getElementById('date1').value;
            var fecha2 = document.getElementById('date2').value;
            var semana = document.getElementById('week').value;
            var mes = document.getElementById('month').value;

            /* Si alguno de los campos está vacío, no validamos
            if (!fecha1 || !fecha2) {
                alert("Por favor, seleccione ambas fechas.");
                return false;
            }*/

            // Validar si el usuario ha seleccionado más de una opción
            var seleccionados = 0;
            if (fecha1 || fecha2) seleccionados++; // Si hay una fecha seleccionada, contar como una opción
            if (semana) seleccionados++;
            if (mes) seleccionados++;

            // Si ha seleccionado más de una opción, mostrar mensaje y prevenir el envío
            if (seleccionados > 1) {
                alert("Por favor, seleccione solo una opción (por Fecha, Semana o Mes) para generar el reporte.");
                return false;
            }

            //Validar si el usuario no eligio ninguna opcion antes de enviar
            if(fecha1 == '' && fecha2 == '' && semana == '' && mes == ''){
                alert("No ingreso ninguna fecha, Por Favor seleccione una opcion!");
                return false;
            }

            // Convertir los valores a objetos de tipo Date
            var inicio = new Date(fecha1);
            var fin = new Date(fecha2);

            // Validar que la fecha de inicio sea anterior a la fecha de fin
            if (inicio > fin) {
                alert("La fecha de inicio no puede ser posterior a la fecha de fin.");
                return false;
            }

            // Si todo está bien, permitir el envío del formulario
            return true;
        }
    </script>


</body>
</html>