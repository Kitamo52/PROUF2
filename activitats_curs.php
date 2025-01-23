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
                <form method='POST' action=''>
                    <input type='hidden' name='id_actividad' value='" . $row['id_activitat'] . "'>
                    <button type='submit' name='entregar_actividad' class='btn'>Entregar</button>
                    <br><br><br><br>
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