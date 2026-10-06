<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios
    (nombre, usuario, correo, contraseña, rol)
    VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sssss",
        $nombre,
        $usuario,
        $correo,
        $contrasena,
        $rol
    );

    if ($stmt->execute()) {
        echo "<p>Usuario registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar el usuario: " . $conexion->error . "</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>

</head>

<body>

    <h1>Gestión de Usuarios</h1>

    <h2>Registrar usuario</h2>

    <form method="POST">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" required>
        <br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required>
        <br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required>
        <br><br>

        <label>Rol:</label><br>

        <select name="rol" required>

            <option value="">Seleccione un rol</option>
            <option value="Administrador">Administrador</option>
            <option value="Medico">Medico</option>
            <option value="Recepcionista">Recepcionista</option>
            <option value="Paciente">Paciente</option>

        </select>

        <br><br>

        <button type="submit">Registrar usuario</button>

    </form>

    <hr>

    <h2>Usuarios registrados</h2>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
        </tr>

        <?php

        $sql = "SELECT
                    id_usuario,
                    nombre,
                    usuario,
                    correo,
                    rol
                FROM usuarios
                ORDER BY id_usuario DESC";

        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {

            while ($usuario_registrado = $resultado->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $usuario_registrado["id_usuario"] . "</td>";
                echo "<td>" . $usuario_registrado["nombre"] . "</td>";
                echo "<td>" . $usuario_registrado["usuario"] . "</td>";
                echo "<td>" . $usuario_registrado["correo"] . "</td>";
                echo "<td>" . $usuario_registrado["rol"] . "</td>";

                echo "</tr>";
            }

        } else {

            echo "<tr>";
            echo "<td colspan='5'>No hay usuarios registrados.</td>";
            echo "</tr>";

        }

        ?>

    </table>

</body>

</html>