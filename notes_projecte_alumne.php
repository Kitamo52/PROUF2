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
if (!isset($_SESSION['nombre_alumno']) || !isset($_SESSION['id_estudiant'])) {
    // Si la sesión no tiene el nombre del alumno, redirigir al inicio de sesión o asignar valores por defecto
    $_SESSION['nombre_alumno'] = 'Desconocido'; // O podrías redirigir a una página de inicio
    $_SESSION['id_estudiant'] = 0; // ID por defecto
}

// Asignar el nombre del alumno y el id_estudiant de la sesión
$nombreAlumno = $_SESSION['nombre_alumno'];
$idEstudiant = $_SESSION['id_estudiant'];

// Consulta para obtener la puntuación del proyecto del estudiante
$query = "SELECT puntuacio_projecte
          FROM assignacio
          WHERE id_estudiant = $idEstudiant AND id_projecte = 1";

// Ejecutar la consulta
$resultat = mysqli_query($connexio, $query);
$puntuacioProjecte = mysqli_fetch_assoc($resultat);

// Si no hay puntuación para el proyecto, establecer un valor por defecto (por ejemplo, 0)
$puntuacioProjecte = $puntuacioProjecte ? $puntuacioProjecte['puntuacio_projecte'] : 'No asignada';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Projecte </title>
    <link rel="stylesheet" href="lumiere2alumno.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .styled-table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            font-family: Arial, sans-serif;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .styled-table thead tr {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:hover {
            background-color:rgb(139, 139, 139);
            color: #ffffff;
        }

        .styled-table td, .styled-table th {
            padding: 12px 15px;
            text-align: center;
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
        <h1 class="tituloassignatures"> Nota del Projecte </h1>
    </div>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Id Estudiant</th>
                    <th>Nota del Projecte</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($idEstudiant); ?></td>
                    <td><?php echo htmlspecialchars($puntuacioProjecte); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        // Función para ir a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
    
</body>
</html>