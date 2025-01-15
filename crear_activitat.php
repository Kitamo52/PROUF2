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
    <title> Panell d'Alumnes </title>
    <link rel="stylesheet" href="lumiere2profe.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>

<body>
    <div class="header">
        <div class="welcome-message">
            <p>Bienvenido, <?php echo $nombreProfesor; ?></p>
        </div>
        <div class="logout-button">
            <img src="img/arrow-left.png" alt="Atrás" class="back-button" onclick="goBack()">
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloassignatures"> Creació d'Activitats </h1>
    </div>

<br><br>

    <form class="crearactivitat">
        <div class="form-container">
            <input type="text" id="nom_activitat" placeholder="Nom de l'Activitat">
            <br><br>
            <input type="text" id="id_activitat" placeholder="ID de l'activitat">
            <br><br>
            <input type="datetime-local" id="data_inici">
            <br><br>
            <input type="datetime-local" id="data_final">
            <br><br><br><br>

            <div class="form-buttons">
                <button type="button" class="botonform">Crear Estudiant</button>
                <button type="button" class="botonform">Modificar Estudiant</button>
                <button type="button" class="botonform">Eliminar Estudiant</button>
            </div>
        </div>
    </form>

    <script>
        // Función para ir a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>