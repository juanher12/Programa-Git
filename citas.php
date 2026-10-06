<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_medico = $_POST["id_medico"];
    $id_paciente = $_POST["id_paciente"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $estado = $_POST["estado"];
    $id_usuario = $_POST["id_usuario"];

    $sql = "INSERT INTO citas
    (id_medico, id_paciente, fecha, hora, estado, id_usuario)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "iisssi",
        $id_medico,
        $id_paciente,
        $fecha,
        $hora,
        $estado,
        $id_usuario
    );

    if ($stmt->execute()) {
        echo "<p>Cita registrada correctamente.</p>";
    } else {
        echo "<p>Error al registrar la cita: " . $conexion->error . "</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Gestión de Citas Médicas</title>

</head>

<body>

    <h1>Gestión de Citas Médicas</h1>

    <h2>Registrar cita</h2>

    <form method="POST">

        <label>Médico:</label><br>

        <select name="id_medico" required>

            <option value="">Seleccione un médico</option>

            <?php

            $medicos = $conexion->query(
                "SELECT id_medico, Nombre FROM medicos ORDER BY Nombre"
            );

            while ($medico = $medicos->fetch_assoc()) {

                echo "<option value='" . $medico["id_medico"] . "'>";
                echo $medico["Nombre"];
                echo "</option>";

            }

            ?>

        </select>

        <br><br>

        <label>Paciente:</label><br>

        <select name="id_paciente" required>

            <option value="">Seleccione un paciente</option>

            <?php

            $pacientes = $conexion->query(
                "SELECT id_paciente, nombre FROM pacientes ORDER BY nombre"
            );

            while ($paciente = $pacientes->fetch_assoc()) {

                echo "<option value='" . $paciente["id_paciente"] . "'>";
                echo $paciente["nombre"];
                echo "</option>";

            }

            ?>

        </select>

        <br><br>

        <label>Fecha:</label><br>
        <input type="date" name="fecha" required>

        <br><br>

        <label>Hora:</label><br>
        <input type="time" name="hora" required>

        <br><br>

        <label>Estado:</label><br>

        <select name="estado" required>

            <option value="Pendiente">Pendiente</option>
            <option value="Confirmada">Confirmada</option>
            <option value="Cancelada">Cancelada</option>
            <option value="Atendida">Atendida</option>

        </select>

        <br><br>

        <label>Usuario responsable:</label><br>

        <select name="id_usuario" required>

            <option value="">Seleccione un usuario</option>

            <?php

            $usuarios = $conexion->query(
                "SELECT id_usuario, nombre FROM usuarios ORDER BY nombre"
            );

            while ($usuario = $usuarios->fetch_assoc()) {

                echo "<option value='" . $usuario["id_usuario"] . "'>";
                echo $usuario["nombre"];
                echo "</option>";

            }

            ?>

        </select>

        <br><br>

        <button type="submit">Registrar cita</button>

    </form>

    <hr>

    <h2>Citas registradas</h2>

    <table border="1" cellpadding="8">

        <tr>

            <th>ID</th>
            <th>Médico</th>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Usuario</th>

        </tr>

        <?php

        $sql = "SELECT
                    c.id_cita,
                    m.Nombre AS medico,
                    p.nombre AS paciente,
                    c.fecha,
                    c.hora,
                    c.estado,
                    u.nombre AS usuario
                FROM citas c
                INNER JOIN medicos m
                    ON c.id_medico = m.id_medico
                INNER JOIN pacientes p
                    ON c.id_paciente = p.id_paciente
                LEFT JOIN usuarios u
                    ON c.id_usuario = u.id_usuario
                ORDER BY c.fecha DESC, c.hora DESC";

        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {

            while ($cita = $resultado->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $cita["id_cita"] . "</td>";
                echo "<td>" . $cita["medico"] . "</td>";
                echo "<td>" . $cita["paciente"] . "</td>";
                echo "<td>" . $cita["fecha"] . "</td>";
                echo "<td>" . $cita["hora"] . "</td>";
                echo "<td>" . $cita["estado"] . "</td>";
                echo "<td>" . $cita["usuario"] . "</td>";

                echo "</tr>";
            }

        } else {

            echo "<tr>";
            echo "<td colspan='7'>No hay citas registradas.</td>";
            echo "</tr>";

        }

        ?>

    </table>

</body>

</html>