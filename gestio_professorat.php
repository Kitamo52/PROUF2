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

    // Manejo de items
    if (isset($_POST['crear_item'])) {
        $nom_item = mysqli_real_escape_string($connexio, $_POST['nom_item'] ?? '');
        $tipus = mysqli_real_escape_string($connexio, $_POST['tipus'] ?? '');
        $percentatge = mysqli_real_escape_string($connexio, $_POST['percentatge'] ?? '');
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat'] ?? '');

        if ($nom_item && $tipus && $percentatge && $id_activitat) {
            $sql = "INSERT INTO item (nom_item, tipus_item, percentatge, id_activitat) 
                    VALUES ('$nom_item', '$tipus', '$percentatge', '$id_activitat')";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Item creat amb èxit!";
            } else {
                $mensaje = "Error en crear l'item: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Tots els camps són obligatoris per crear un item!";
        }
    }

    // Modificar item
    if (isset($_POST['modificar_item'])) {
        $id_item = mysqli_real_escape_string($connexio, $_POST['id_item'] ?? '');
        $nom_item = mysqli_real_escape_string($connexio, $_POST['nom_item'] ?? '');
        $tipus = mysqli_real_escape_string($connexio, $_POST['tipus'] ?? '');
        $percentatge = mysqli_real_escape_string($connexio, $_POST['percentatge'] ?? '');
        $id_activitat = mysqli_real_escape_string($connexio, $_POST['id_activitat'] ?? '');

        if ($id_item) {
            $sql = "UPDATE item SET 
                    nom_item = '$nom_item', 
                    tipus_item = '$tipus', 
                    percentatge = '$percentatge', 
                    id_activitat = '$id_activitat' 
                    WHERE id_item = '$id_item'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Item modificat amb èxit!";
            } else {
                $mensaje = "Error en modificar l'item: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'item per modificar!";
        }
    }

    // Eliminar item
    if (isset($_POST['eliminar_item'])) {
        $id_item = mysqli_real_escape_string($connexio, $_POST['id_item'] ?? '');
        if ($id_item) {
            $sql = "DELETE FROM item WHERE id_item = '$id_item'";
            if (mysqli_query($connexio, $sql)) {
                $mensaje = "Item eliminat amb èxit!";
            } else {
                $mensaje = "Error en eliminar l'item: " . mysqli_error($connexio);
            }
        } else {
            $mensaje = "Cal indicar l'ID de l'item per eliminar!";
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
            <form class="formgestioprofe" method="POST">
                <input type="text" name="nom_item" placeholder="Nom de l'Item">
                <br><br>
                <label for="tipus">Tipus de l'Item:</label>
                <br>
                <input type="radio" id="soft-skills" name="tipus" value="Soft Skills">
                <label for="soft-skills">Soft Skills</label>
                <br>
                <input type="radio" id="hard-skills" name="tipus" value="Hard Skills">
                <label for="hard-skills">Hard Skills</label>
                <br><br>
                <input type="text" name="percentatge" placeholder="Percentatge">
                <br><br>
                <input type="text" name="id_activitat" placeholder="ID Activitat">
                <br><br>
                <button type="submit" class="botonform" name="crear_item">Crear Item</button>
                <button type="submit" class="botonform" name="modificar_item">Modificar Item</button>
                <button type="submit" class="botonform" name="eliminar_item">Eliminar Item</button>
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
