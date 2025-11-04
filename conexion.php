<?php

$conexion = new mysqli("localhost", "root", "", "kiosko_mayorista");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
else {echo "hola si funciona";}
?>

