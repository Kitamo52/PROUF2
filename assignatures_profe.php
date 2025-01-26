<?php
// Conexión a la base de datos
$connexio = mysqli_connect("localhost", "root", "", "micro2");

// Verificar conexión
if (!$connexio) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Actualizar nota si se envía el formulario
if (isset($_POST['actualizar_nota'])) {
    $id_avaluacio = $_POST['id_avaluacio'];
    $puntuacio = $_POST['puntuacio'];
    $sql = "UPDATE avaluacio SET puntuacio = '$puntuacio' WHERE id_avaluacio = '$id_avaluacio'";
    mysqli_query($connexio, $sql);
}

// Obtener todos los datos de la tabla
$sql = "SELECT * FROM avaluacio";
$resultat = mysqli_query($connexio, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de Estudiantes</title>
    <link rel="stylesheet" href="lumiere2profe.css">
</head>

<body>
    <div class="header">
        <div class="welcome-message">
            <p>Bienvenido, Profesor</p>
        </div>
        <div class="logout-button">
            <img src="img/arrow-left.png" alt="Atrás" class="back-button" onclick="goBack()">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloassignatures">Notas de los Estudiantes</h1>
    </div>

    <div class="tabla-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID Avaluació</th>
                    <th>Puntuació</th>
                    <th>ID Activitat</th>
                    <th>ID Estudiant</th>
                    <th>ID Item</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultat)) : ?>
                    <tr>
                        <form method="POST">
                            <td><?php echo $fila['id_avaluacio']; ?></td>
                            <td>
                                <input type="number" name="puntuacio" value="<?php echo $fila['puntuacio']; ?>" min="0" max="10" class="nota-input">
                            </td>
                            <td><?php echo $fila['id_activitat']; ?></td>
                            <td><?php echo $fila['id_estudiant']; ?></td>
                            <td><?php echo $fila['id_item']; ?></td>
                            <td>
                                <input type="hidden" name="id_avaluacio" value="<?php echo $fila['id_avaluacio']; ?>">
                                <button type="submit" name="actualizar_nota" class="boton-guardar">Guardar</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>