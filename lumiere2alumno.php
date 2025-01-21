<?php
// Configuración de la conexión a la base de datos
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
    <title>Panell d'Alumnes</title>
    <link rel="stylesheet" href="lumiere2alumno.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>

<body>
    <!-- Barra de navegación y bienvenida -->
    <div class="header">
        <div class="welcome-message">
            <!-- Mostrar el nombre del alumno -->
            <p>Bienvenido, <?php echo htmlspecialchars($nombreAlumno); ?></p>
        </div>
        <div class="logout-button">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloraco">Racó de l'Alumne</h1>
    </div>

    <div class="imgprofe">
        <img src="img/logo_lumiere-removebg-preview.png" alt="">
    </div>

    <!-- Menú de navegación -->
    <div class="menu">
        <button class="menu-btn" onclick="window.location.href='notes_alumne.php'">Les Meves Notes</button>
        <button class="menu-btn" onclick="window.location.href='notes_projecte_alumne.php'">Notes Projecte</button>
        <button class="menu-btn" onclick="window.location.href='activitats_curs.php'">Activitats en curs</button>
    </div>

</body>

</html>