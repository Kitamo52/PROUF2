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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assignatures del Professor </title>
    <link rel="stylesheet" href="lumiere2profe.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>

<body>
    <div class="header">
        <div class="welcome-message">
            <p>Bienvenido, <?php echo $nombreProfesor; ?></p>
        </div>
        <div class="logout-button">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloassignatures"> Assignatures del Professor </h1>
    </div>

    <br><br>

    <div class="imgprofe">
        <img src="img/logo_lumiere-removebg-preview.png" alt="">
    </div>

    <br>

    <!-- Menú de navegación -->
    <div class="menu">
        <button class="menu-btn" onclick="window.location.href='asignatura_php.php'"> PHP </button>
        <button class="menu-btn" onclick="window.location.href='asignatura_js.php'"> Javascript </button>
        <button class="menu-btn" onclick="window.location.href='asignatura_disseny.php'"> Disseny </button>
        <button class="menu-btn" onclick="window.location.href='asignatura_empresa.php'"> Empresa </button>
        <button class="menu-btn" onclick="window.location.href='asignatura_projecte.php'"> Projecte </button>
    </div>

</body>