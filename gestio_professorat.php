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
            <a href="lumiere1.php" class="btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="title-container">
        <h1 class="tituloassignatures"> Gestió del Professorat </h1>
    </div>

    <div class="columna">
    <div>
        <h1>Estudiants</h1>
        <br><br>
        <form class="formgestioprofe">
            <input type="text" id="nom_estudiant" placeholder=" Ingresa el teu nom ">
            <br><br>
            <input type="text" id="Cognom_estudiant" placeholder=" Ingresa primer cognom ">
            <br><br>
            <input type="password" id="contrasenya_estudiant" placeholder=" Contrasenya ">
            <br><br>
            <input type="text" id="email_estudiant" placeholder=" Correu Electrònic ">
            <br><br>
            <input type="text" id="estat_estudiant" placeholder=" Estat Estudiant ">
            <br><br>
            <br><br>

            <button type="button" class="botonform" onclick=""> Crear Estudiant </button>
            <button type="button" class="botonform" onclick=""> Modificar Estudiant </button>
            <button type="button" class="botonform" onclick=""> Eliminar Estudiant </button>
        </form>
    </div>

    <div>
        <h1>Items</h1>
        <br><br>
        <form class="formgestioprofe">
        <input type="text" id="nom" placeholder="Nom del ítem">
        <br><br>

        <label for="tipus">Tipus del ítem:</label>
        <br>
        <input type="radio" id="soft-skills" name="tipus" value="Soft Skills">
        <label for="soft-skills">Soft Skills</label>
        <br>
        <input type="radio" id="hard-skills" name="tipus" value="Hard Skills">
        <label for="hard-skills">Hard Skills</label>
        <br><br>
        <input type="text" id="Percentatge" placeholder=" Percentatge ">
        <br><br>
        <input type="text" id="Percentatge" placeholder=" Percentatge ">            


                <br><br>
                <br><br>

            <button type="button" class="botonform" onclick=""> Crear Item </button>
            <button type="button" class="botonform" onclick=""> Modificar Item </button>
            <button type="button" class="botonform" onclick=""> Eliminar Item </button>
        </form>
        
    </div>

    </div>

</body>