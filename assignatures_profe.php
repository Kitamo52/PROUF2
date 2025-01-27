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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de Estudiantes</title>
    <link rel="stylesheet" href="lumiere2profe.css">
    <style>
        /* Estilos específicos para la tabla de notas */
        .styled-table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            color: #333;
            font-size: 18px;
        }

        .styled-table thead {
            background-color: #2c3e50;
            color: white;
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        /* Alineación de la columna de puntuación hacia la derecha */
        .styled-table td:nth-child(2) {
            text-align: right;
        }

        /* Estilo para los inputs */
        .nota-input {
            width: 60px;
            padding: 5px;
            text-align: right;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Estilo para el botón de guardar */
        .boton-guardar {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .boton-guardar:hover {
            background-color: #2980b9;
        }

        /* Filas alternas */
        .styled-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .styled-table tbody tr:hover {
            background-color:rgb(110, 110, 110);
            color: white;
        }

        /* Contenedor de la tabla */
        .tabla-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
    </style>
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