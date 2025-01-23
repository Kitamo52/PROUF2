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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projecte</title>
    <link rel="stylesheet" href="lumiere2alumno.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
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

<div class="imgprofe">
    <img src="img/logo_lumiere-removebg-preview.png" alt="Logo Lumiere">
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
                <button class='btn'>Entregar</button>
            <br><br><br><br>
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