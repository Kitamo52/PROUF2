<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Iniciar sesión
session_start();

// Verificar si el nombre y el id del alumno están disponibles en la sesión
if (!isset($_SESSION['nombre_alumno']) || !isset($_SESSION['id_estudiant'])) {
    // Si no están disponibles, redirigir al inicio de sesión o asignar valores por defecto
    $_SESSION['nombre_alumno'] = 'Desconocido';
    //$_SESSION['id_estudiant'] = 0; // ID por defecto
}

// Asignar variables de sesión
$nombreAlumno = $_SESSION['nombre_alumno'];
$idEstudiant = $_SESSION['id_estudiant'];

// Consulta para obtener las notas del estudiante
$query = "SELECT avaluacio.id_avaluacio, avaluacio.puntuacio, activitat.nom_activitat
          FROM avaluacio
          JOIN activitat ON avaluacio.id_activitat = activitat.id_activitat
          WHERE avaluacio.id_estudiant = $idEstudiant";
          echo $query;
// $stmt = $connexio->prepare($query);
// $stmt->bind_param("i", $idEstudiant);
// $stmt->execute();
// $resultat = $stmt->get_result();
$resultat = mysqli_query($connexio,$query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Notes de Alumne </title>
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
            background-color: #f1c40f;
            color: #ffffff;
        }

        .styled-table td, .styled-table th {
            padding: 12px 15px;
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
        <h1 class="tituloassignatures"> Notes del Alumne </h1>
    </div>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID Avaluació</th>
                    <th>Nom Activitat</th>
                    <th>Puntuació</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultat->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['id_avaluacio']); ?></td>
                        <td><?php echo htmlspecialchars($fila['nom_activitat']); ?></td>
                        <td><?php echo htmlspecialchars($fila['puntuacio']); ?></td>
                    </tr>
                <?php endwhile; ?>
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