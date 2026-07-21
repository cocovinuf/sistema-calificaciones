<?php
$conexion = new mysqli("localhost", "root", "", "alumnos_db");

if ($conexion->connect_error) {
    http_response_code(500);
    die("Error de conexión");
}

?>
