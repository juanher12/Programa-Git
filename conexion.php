<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_de_datos = "citas_medicas_juan";

$conexion = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

?>