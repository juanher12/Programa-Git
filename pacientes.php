<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $identificacion = $_POST["identificacion"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $celular = $_POST["celular"];
    $direccion = $_POST["direccion"];
    $eps = $_POST["eps"];
    $tipo_sangre = $_POST["tipo_sangre"];

    $sql = "INSERT INTO pacientes 
    (nombre, identificacion, fecha_nacimiento, celular, direccion, eps, tipo_sangre)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $nombre,
        $identificacion,
        $fecha_nacimiento,
        $celular,
        $direccion,
        $eps,
        $tipo_sangre
    );

    if ($stmt->execute()) {
        echo "<p>Paciente registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar el paciente: " . $conexion->error . "</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Gestión de Pacientes</title>

</head>

<body>

    <h1>Gestión de Pacientes</h1>

    <h2>Registrar paciente</h2>

    <form method="POST">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Identificación:</label><br>
        <input type="text" name="identificacion" required>
        <br><br>

        <label>Fecha de nacimiento:</label><br>
        <input type="date" name="fecha_nacimiento" required>
        <br><br>

        <label>Celular:</label><br>
        <input type="text" name="celular" required>
        <br><br>

        <label>Dirección:</label><br>
        <input type="text" name="direccion" required>
        <br><br>

        <label>EPS:</label><br>
        <input type="text" name="eps" required>
        <br><br>

        <label>Tipo de sangre:</label><br>
        <input type="text" name="tipo_sangre">
        <br><br>

        <button type="submit">Registrar paciente</button>

    </form>

    <hr>

    <h2>Pacientes registrados</h2>

    <table border="1" cellpadding="8">

        <tr>

            <th>ID</th>
            <th>Nombre</th>
            <th>Identificación</th>
            <th>Fecha de nacimiento</th>
            <th>Celular</th>
            <th>Dirección</th>
            <th>EPS</th>
            <th>Tipo de sangre</th>

        </tr>

        <?php

        $sql = "SELECT 
                    id_paciente,
                    nombre,
                    identificacion,
                    fecha_nacimiento,
                    celular,
                    direccion,
                    eps,
                    tipo_sangre
                FROM pacientes
                ORDER BY id_paciente DESC";

        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {

            while ($paciente = $resultado->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $paciente["id_paciente"] . "</td>";
                echo "<td>" . $paciente["nombre"] . "</td>";
                echo "<td>" . $paciente["identificacion"] . "</td>";
                echo "<td>" . $paciente["fecha_nacimiento"] . "</td>";
                echo "<td>" . $paciente["celular"] . "</td>";
                echo "<td>" . $paciente["direccion"] . "</td>";
                echo "<td>" . $paciente["eps"] . "</td>";
                echo "<td>" . $paciente["tipo_sangre"] . "</td>";

                echo "</tr>";
            }

        } else {

            echo "<tr>";
            echo "<td colspan='8'>No hay pacientes registrados.</td>";
            echo "</tr>";

        }

        ?>

    </table>

</body>

</html>