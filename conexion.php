<?php

    function conectar(){

        $servidor="localhost";
        $usuario="root";
        $pass="";
        $nombreBD="julioVerne";

        $c=mysqli_connect($servidor, $usuario, $pass, $nombreBD);


        return $c;
    }

?>