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
    // Si la sesión no tiene el nombre del alumno, redirigir al inicio de sesión o asignar un valor por defecto
    $_SESSION['nombre_alumno'] = 'Desconocido'; // O podrías redirigir a una página de inicio
}

// Asignar el nombre del alumno
$nombreAlumno = $_SESSION['nombre_alumno'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Projecte </title>
    <link rel="stylesheet" href="lumiere2alumno.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>
<body>
<div class="header">
        <div class="welcome-message">
            <p>Bienvenido, <?php echo $nombreAlumno; ?></p>
        </div>
        <div class="logout-button">
            <img src="img/arrow-left.png" alt="Atrás" class="back-button" onclick="goBack()">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloassignatures"> Notes del Projecte </h1>
    </div>

    
    <br><br>

    <div class="imgprofe">
        <img  src="img/logo_lumiere-removebg-preview.png" alt="">
    </div>

    <script>
        // Función para ir a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
    
</body>
</html>