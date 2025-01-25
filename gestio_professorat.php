<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Verificar la sesión del usuario (nombre del profesor)
session_start();
$nombreProfesor = $_SESSION['nombre_profesor'] ?? 'Desconocido'; // Si no hay sesión, mostrar 'Desconocido'

// Mensaje para mostrar resultados de las acciones
$mensaje = "";

// Manejo del formulario para estudiantes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear estudiante
    if (isset($_POST['crear_estudiant'])) {
        $id_estudiant = mysqli_real_escape_string($connexio, $_POST['id_estudiant'] ?? '');
        $nom = mysqli_real_escape_string($connexio, $_POST['nom_estudiant'] ?? '');
        $cognom = mysqli_real_escape_string($connexio, $_POST['cognom_estudiant'] ?? '');
        $contrasenya = mysqli_real_escape_string($connexio, $_POST['contrasenya_estudiant'] ?? '');
        $correu = mysqli_real_escape_string($connexio, $_POST['email_estudiant'] ?? '');
        $estat = mysqli_real_escape_string($connexio, $_POST['estat_estudiant'] ?? 'activo');
    
        if ($nom && $cognom && $contrasenya && $correu) {
            $sql = "INSERT INTO estudiant (id_estudiant,correu_estudiant, nom_estudiant, pw_estudiant, estat) 
                    VALUES ('$id_estudiant','$correu', '$nom $cognom', '$contrasenya', '$estat')";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Estudiant creat amb èxit!";
            } else {
                $mensaje = "Error en crear l'estudiant: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Tots els camps són obligatoris!";
        }
    }

    // Modificar estudiante
    if (isset($_POST['modificar_estudiant'])) {
        $id = mysqli_real_escape_string($connexio, $_POST['id_estudiant'] ?? '');
        $nom = mysqli_real_escape_string($connexio, $_POST['nom_estudiant'] ?? '');
        $cognom = mysqli_real_escape_string($connexio, $_POST['cognom_estudiant'] ?? '');
        $contrasenya = mysqli_real_escape_string($connexio, $_POST['contrasenya_estudiant'] ?? '');
        $correu = mysqli_real_escape_string($connexio, $_POST['email_estudiant'] ?? '');
        $estat = mysqli_real_escape_string($connexio, $_POST['estat_estudiant'] ?? '');

        if ($id && ($nom || $cognom || $contrasenya || $correu || $estat)) {
            $sql = "UPDATE estudiant SET 
                    nom_estudiant = '$nom $cognom', 
                    pw_estudiant = '$contrasenya', 
                    correu_estudiant = '$correu', 
                    estat = '$estat' 
                    WHERE id_estudiant = '$id'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Estudiant modificat amb èxit!";
            } else {
                $mensaje = "Error en modificar l'estudiant: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'estudiant i almenys un camp per modificar!";
        }
    }

    // Eliminar estudiante
    if (isset($_POST['eliminar_estudiant'])) {
        $id = mysqli_real_escape_string($connexio, $_POST['id_estudiant'] ?? '');
        if ($id) {
            $sql = "DELETE FROM estudiant WHERE id_estudiant = '$id'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Estudiant eliminat amb èxit!";
            } else {
                $mensaje = "Error en eliminar l'estudiant: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'estudiant per eliminar!";
        }
    }

}

// Manejo del formulario para skills
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear skill
    if (isset($_POST['crear_skill'])) {
        $id_item = mysqli_real_escape_string($connexio, $_POST['id_item'] ?? '');
        $nom_item = mysqli_real_escape_string($connexio, $_POST['nom_item'] ?? '');
        $descripcio = mysqli_real_escape_string($connexio, $_POST['descripcio'] ?? '');
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat'] ?? '');
        $id_projecte = mysqli_real_escape_string($connexio, $_POST['id_projecte'] ?? '');

        if ($nom_item && $id_activitat && $id_projecte) {
            if ($id_item) {
                // Si se proporciona un ID, lo utilizamos en la creación
                $sql = "INSERT INTO skills (id_item, nom_item, descripcio, id_activitat, id_projecte) 
                        VALUES ('$id_item', '$nom_item', '$descripcio', '$id_activitat', '$id_projecte')";
            } else {
                // Si no se proporciona un ID, dejamos que la base de datos lo genere automáticamente
                $sql = "INSERT INTO skills (nom_item, descripcio, id_activitat, id_projecte) 
                        VALUES ('$nom_item', '$descripcio', '$id_activitat', '$id_projecte')";
            }

            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Skill creat amb èxit!";
            } else {
                $mensaje = "Error en crear el skill: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Tots els camps són obligatoris per crear un skill!";
        }
    }

    // Modificar skill
    if (isset($_POST['modificar_skill'])) {
        $id_item = mysqli_real_escape_string($connexio, $_POST['id_item'] ?? '');
        $nom_item = mysqli_real_escape_string($connexio, $_POST['nom_item'] ?? '');
        $descripcio = mysqli_real_escape_string($connexio, $_POST['descripcio'] ?? '');
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat'] ?? '');
        $id_projecte = mysqli_real_escape_string($connexio, $_POST['id_projecte'] ?? '');

        if ($id_item && ($nom_item || $descripcio || $id_activitat || $id_projecte)) {
            $sql = "UPDATE skills SET 
                    nom_item = '$nom_item', 
                    descripcio = '$descripcio', 
                    id_activitat = '$id_activitat', 
                    id_projecte = '$id_projecte' 
                    WHERE id_item = '$id_item'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Skill modificat amb èxit!";
            } else {
                $mensaje = "Error en modificar el skill: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID del skill i almenys un camp per modificar!";
        }
    }

    // Eliminar skill
    if (isset($_POST['eliminar_skill'])) {
        $id_item = mysqli_real_escape_string($connexio, $_POST['id_item'] ?? '');
        if ($id_item) {
            $sql = "DELETE FROM skills WHERE id_item = '$id_item'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Skill eliminat amb èxit!";
            } else {
                $mensaje = "Error en eliminar el skill: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID del skill per eliminar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell d'Alumnes</title>
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
        <h1 class="tituloassignatures">Gestió del Professorat</h1>
    </div>

    <div class="columna">
        <div>
            <h1>Estudiants</h1>
            <br><br>
            <?php if ($mensaje) : ?>
                <p style="color: green;"><?php echo $mensaje; ?></p>
            <?php endif; ?>
            <form class="formgestioprofe" method="POST">
                <input type="text" name="id_estudiant" placeholder="ID de l'Estudiant (Per Modificar o Eliminar)">
                <br><br>
                <input type="text" name="nom_estudiant" placeholder="Nom">
                <br><br>
                <input type="text" name="cognom_estudiant" placeholder="Cognom">
                <br><br>
                <input type="password" name="contrasenya_estudiant" placeholder="Contrasenya">
                <br><br>
                <input type="text" name="email_estudiant" placeholder="Correu Electrònic">
                <br><br>
                <input type="text" name="estat_estudiant" placeholder="Estat" value="actiu">
                <br><br>
                <button type="submit" class="botonform" name="crear_estudiant">Crear Estudiant</button>
                <button type="submit" class="botonform" name="modificar_estudiant">Modificar Estudiant</button>
                <button type="submit" class="botonform" name="eliminar_estudiant">Eliminar Estudiant</button>
            </form>
        </div>

        <div>
            <h1>Items</h1>
            <br><br>
    <!-- Formulario para skills -->
    <form method="POST">
        <input type="text" name="id_item" placeholder="ID del Skill (Per Modificar o Eliminar)">
        <br><br>
        <input type="text" name="nom_item" placeholder="Nom del Skill">
        <br><br>
        <textarea name="descripcio" placeholder="Descripció"></textarea>
        <br><br>
        <input type="text" name="id_activitat" placeholder="ID de l'Activitat">
        <br><br>
        <input type="text" name="id_projecte" placeholder="ID del Projecte">
        <br><br>
        <button type="submit" name="crear_skill">Crear Skill</button>
        <button type="submit" name="modificar_skill">Modificar Skill</button>
        <button type="submit" name="eliminar_skill">Eliminar Skill</button>
    </form>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
