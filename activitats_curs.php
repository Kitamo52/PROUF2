<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Verificar la conexión a la base de datos
if (!$connexio) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Iniciar sesión
session_start();

// Verificar si el nombre del alumno está disponible en la sesión
if (!isset($_SESSION['nombre_alumno'])) {
    $_SESSION['nombre_alumno'] = 'Desconocido'; // Valor por defecto
}

// Asignar el nombre del alumno
$nombreAlumno = $_SESSION['nombre_alumno'];

// Actualizar el estado de la actividad cuando se hace clic en "Entregar"
if (isset($_POST['entregar_actividad'])) {
    $id_actividad = $_POST['id_actividad'];
    $query_update = "UPDATE activitat SET estat_activitat = 'entregat' WHERE id_activitat = '$id_actividad'";
    if (mysqli_query($connexio, $query_update)) {
        echo "<script>alert('Actividad entregada correctamente');</script>";
    } else {
        echo "<script>alert('Error al entregar la actividad');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projecte</title>
    <link rel="stylesheet" href="lumiere2alumno.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        color: #2c3e50;
        margin: 0;
        padding: 0;
    }

    .title-container {
        text-align: center;
        margin-top: 20px;
    }

    .title-container h1 {
        font-size: 2em;
        color:rgb(244, 244, 244);
    }

    .entregas-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco transparente */
        width: 300px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .card h3 {
        font-size: 1.5em;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 1em;
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    .card button {
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .card button:hover {
        background-color: #2980b9;
    }

    .no-activities {
        font-size: 1.2em;
        color: #7f8c8d;
        text-align: center;
        margin-top: 20px;
    }
</style>

</head>
<body>
<div class="header">
    <div class="welcome-message">
        <p>Bienvenido, <?php echo htmlspecialchars($nombreAlumno); ?></p>
    </div>
    <div class="logout-button">
        <img src="img/arrow-left.png" alt="Atrás" class="back-button" onclick="goBack()">
        <a href="lumiere1.php" class="btn">Cerrar sesión</a>
    </div>
</div>

<div class="title-container">
    <h1 class="tituloassignatures">Activitats en Curs</h1>
</div>

<!-- Contenedor para las entregas -->
<div class="entregas-container">
    <?php
    $query = "SELECT * FROM activitat WHERE estat_activitat = 'no_entregat'";
    $result = mysqli_query($connexio, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='card'>
                <h3>" . htmlspecialchars($row['nom_activitat']) . "</h3>
                <p>Data Inici: " . htmlspecialchars($row['data_inici']) . "</p>
                <p>Data Final: " . htmlspecialchars($row['data_fi']) . "</p>
                <form method='POST' action=''>
                    <input type='hidden' name='id_actividad' value='" . $row['id_activitat'] . "'>
                    <button type='submit' name='entregar_actividad'>Entregar</button>
                </form>
            </div>
            ";
        }
    } else {
        echo "<p class='no-activities'>No hay actividades pendientes.</p>";
    }
    ?>
</div>

<script>
    // Función para ir a la página anterior
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>