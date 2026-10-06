<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $identificacion = $_POST["identificacion"];
    $especialidad = $_POST["especialidad"];
    $celular = $_POST["celular"];
    $correo = $_POST["correo"];
    $id_usuario = $_POST["id_usuario"];

    $sql = "INSERT INTO medicos
    (Nombre, Identificacion, Especialidad, Celular, Correo, id_usuario)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sssssi",
        $nombre,
        $identificacion,
        $especialidad,
        $celular,
        $correo,
        $id_usuario
    );

    if ($stmt->execute()) {
        echo "<p>Médico registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar el médico: " . $conexion->error . "</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Gestión de Médicos</title>

</head>

<body>

    <h1>Gestión de Médicos</h1>

    <h2>Registrar médico</h2>

    <form method="POST">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Identificación:</label><br>
        <input type="text" name="identificacion" required>
        <br><br>

        <label>Especialidad:</label><br>
        <input type="text" name="especialidad" required>
        <br><br>

        <label>Celular:</label><br>
        <input type="text" name="celular" required>
        <br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required>
        <br><br>

        <label>ID de usuario:</label><br>
        <input type="number" name="id_usuario" value="1" required>
        <br><br>

        <button type="submit">Registrar médico</button>

    </form>

    <hr>

    <h2>Médicos registrados</h2>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Identificación</th>
            <th>Especialidad</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>ID Usuario</th>
        </tr>

        <?php

        $sql = "SELECT
                    id_medico,
                    Nombre,
                    Identificacion,
                    Especialidad,
                    Celular,
                    Correo,
                    id_usuario
                FROM medicos
                ORDER BY id_medico DESC";

        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {

            while ($medico = $resultado->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $medico["id_medico"] . "</td>";
                echo "<td>" . $medico["Nombre"] . "</td>";
                echo "<td>" . $medico["Identificacion"] . "</td>";
                echo "<td>" . $medico["Especialidad"] . "</td>";
                echo "<td>" . $medico["Celular"] . "</td>";
                echo "<td>" . $medico["Correo"] . "</td>";
                echo "<td>" . $medico["id_usuario"] . "</td>";

                echo "</tr>";
            }

        } else {

            echo "<tr>";
            echo "<td colspan='7'>No hay médicos registrados.</td>";
            echo "</tr>";

        }

        ?>

    </table>

</body>

</html>