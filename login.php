<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contraseña);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        echo "<h2>Inicio de sesión exitoso</h2>";
        echo "<p>Bienvenido al sistema.</p>";
    } else {
        echo "<h2>Usuario o contraseña incorrectos</h2>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
</head>

<body>

    <h1>Sistema de Citas Médicas</h1>
    <h2>Iniciar sesión</h2>

    <form method="POST">

        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contraseña" required>

        <br><br>

        <button type="submit">Ingresar</button>

    </form>

</body>
</html>