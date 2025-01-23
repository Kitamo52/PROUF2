<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Verificar conexión
if (!$connexio) {
    die("Error de connexió: " . mysqli_connect_error());
}

// Verificar la sesión del usuario
session_start();
$nombreProfesor = $_SESSION['nombre_profesor'] ?? 'Desconocido'; // Si no hay sesión, mostrar 'Desconocido'

// Mensaje para mostrar los resultados
$mensaje = "";

// Validar si el profesor y el proyecto predeterminado existen
$check_professor = "SELECT COUNT(*) AS total FROM professor WHERE id_professor = 1";
$result_professor = mysqli_query($connexio, $check_professor);
$row_professor = mysqli_fetch_assoc($result_professor);

if ($row_professor['total'] == 0) {
    // Crear un profesor predeterminado
    $default_professor = "INSERT INTO professor (id_professor, nom_professor) VALUES (1, 'Professor Default')";
    if (!mysqli_query($connexio, $default_professor)) {
        die("Error al crear el professor predeterminat: " . mysqli_error($connexio));
    }
}

$check_projecte = "SELECT COUNT(*) AS total FROM projecte WHERE id_projecte = 1";
$result_projecte = mysqli_query($connexio, $check_projecte);
$row_projecte = mysqli_fetch_assoc($result_projecte);

if ($row_projecte['total'] == 0) {
    // Crear un proyecto predeterminado
    $default_projecte = "INSERT INTO projecte (id_professor, data_inici, data_fi, id_projecte, nom_projecte) 
                         VALUES (1, '2025-01-01', '2025-12-31', 1, 'Projecte Default')";
    if (!mysqli_query($connexio, $default_projecte)) {
        die("Error al crear el projecte predeterminat: " . mysqli_error($connexio));
    }
}

// Manejo de las acciones de las actividades
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear actividad
    if (isset($_POST['crear_activitat'])) {
        $nom_activitat = mysqli_real_escape_string($connexio, $_POST['nom_activitat'] ?? '');
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat'] ?? '');
        $data_inici = mysqli_real_escape_string($connexio, $_POST['data_inici'] ?? '');
        $data_fi = mysqli_real_escape_string($connexio, $_POST['data_fi'] ?? '');
        $id_projecte = 1; // El ID del proyecto siempre es 1

        if ($id_activitat && $nom_activitat && $data_inici && $data_fi) {
            $sql = "INSERT INTO activitat (id_projecte, data_inici, data_fi, id_activitat, nom_activitat, estat_activitat) 
                    VALUES ('$id_projecte', '$data_inici', '$data_fi', '$id_activitat', '$nom_activitat', 'no_entregat')";
            
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Activitat creada amb èxit!";
            } else {
                $mensaje = "Error en crear l'activitat: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Tots els camps són obligatoris!";
        }
    }

    // Modificar actividad
    if (isset($_POST['modificar_activitat'])) {
        $nom_activitat = mysqli_real_escape_string($connexio, $_POST['nom_activitat']);
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat']);
        $data_inici = mysqli_real_escape_string($connexio, $_POST['data_inici']);
        $data_fi = mysqli_real_escape_string($connexio, $_POST['data_fi']);
        $estat_activitat = mysqli_real_escape_string($connexio, $_POST['estat_activitat'] ?? 'no_entregat');
        $id_projecte = 1;

        if ($id_activitat) {
            $sql = "UPDATE activitat SET 
                    nom_activitat = '$nom_activitat', 
                    data_inici = '$data_inici', 
                    data_fi = '$data_fi',
                    estat_activitat = '$estat_activitat'
                    WHERE id_activitat = '$id_activitat'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Activitat modificada amb èxit!";
            } else {
                $mensaje = "Error en modificar l'activitat: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'activitat per modificar!";
        }
    }

    // Eliminar actividad
    if (isset($_POST['eliminar_activitat'])) {
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat']);
        if ($id_activitat) {
            $sql = "DELETE FROM activitat WHERE id_activitat = '$id_activitat'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Activitat eliminada amb èxit!";
            } else {
                $mensaje = "Error en eliminar l'activitat: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'activitat per eliminar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell d'Activitats</title>
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
        <h1>Gestió d'Activitats</h1>
    </div>

    <form class="crearactivitat" method="POST">
        <div class="form-container">
            <input type="text" name="nom_activitat" placeholder="Nom de l'Activitat" required>
            <br><br>
            <input type="text" name="id_activitat" placeholder="ID de l'activitat" required>
            <br><br>
            <input type="datetime-local" name="data_inici" required>
            <br><br>
            <input type="datetime-local" name="data_fi" required>
            <br><br><br><br>

            <div class="form-buttons">
                <button type="submit" class="botonform" name="crear_activitat">Crear Activitat</button>
                <button type="submit" class="botonform" name="modificar_activitat">Modificar Activitat</button>
                <button type="submit" class="botonform" name="eliminar_activitat">Eliminar Activitat</button>
            </div>
        </div>
    </form>

    <?php if ($mensaje) : ?>
        <p style="color: green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <script>
        // Función para ir a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>