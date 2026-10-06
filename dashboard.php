<?php

include "conexion.php";

echo "<h1>Sistema de Citas Médicas</h1>";

echo "<h2>Panel principal</h2>";

echo "<p>Bienvenido al sistema de gestión de citas médicas.</p>";

echo "<h3>Opciones disponibles</h3>";

echo "<ul>";
echo "<li><a href='pacientes.php'>Pacientes</a></li>";
echo "<li><a href='medicos.php'>Médicos</a></li>";
echo "<li><a href='citas.php'>Citas médicas</a></li>";
echo "<li><a href='usuarios.php'>Usuarios</a></li>";
echo "</ul>";

?>