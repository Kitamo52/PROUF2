<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Verificar la sesión del usuario (nombre del profesor)
// Supongamos que el nombre del profesor está almacenado en una variable de sesión llamada 'nombre_profesor'
session_start();
$nombreProfesor = $_SESSION['nombre_profesor'] ?? 'Desconocido'; // Si no hay sesión, mostrar 'Desconocido'
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Profesores</title>
    <link rel="stylesheet" href="lumiere2profe.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>

<body>
    <!-- Barra de navegación y bienvenida -->
    <div class="header">
        <div class="welcome-message">
            <p>Bienvenido, <?php echo $nombreProfesor; ?></p>
        </div>
        <div class="logout-button">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloraco"> Racó del Professor </h1>
    </div>

    <div class="imgprofe">
        <img  src="img/logo_lumiere-removebg-preview.png" alt="">
    </div>

    <!-- Menú de navegación -->
    <div class="menu">
        <button class="menu-btn" onclick="window.location.href='assignatures_profe.php'"> Assignatures del Professor </button>
        <button class="menu-btn" onclick="window.location.href='gestio_professorat.php'"> Gestions del Professorat </button>
        <button class="menu-btn" onclick="window.location.href='crear_activitat.php'"> Crear Activitat </button>
    </div>

</body>

</html>