<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuari = "root";
$clau = "";
$bbdd = "micro2";
$connexio = mysqli_connect($servidor, $usuari, $clau, $bbdd);

// Verificamos si la conexión es exitosa
if (!$connexio) {
    die("Error de conexión: " . mysqli_connect_error());
}

$resultadologin =""; // creo aqui la variable porque si no da error al controlar el login

// Recibimos los datos del formulario HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"]; // Nombre de usuario desde el formulario
    $contrasena = $_POST["contrasena"]; // Contraseña desde el formulario

    // Preparamos la consulta SQL para la tabla 'estudiant'
    $sqlEstudiant = "SELECT * FROM estudiant WHERE nom_estudiant = '$usuario' AND pw_estudiant = '$contrasena'";
    $resultEstudiant = mysqli_query($connexio, $sqlEstudiant);

    // Si encontramos un resultado en 'estudiant'
    if (mysqli_num_rows($resultEstudiant) > 0) {
        // echo "¡Bienvenido, $usuario! Has ingresado como estudiante.<br>";
        header("Location: lumiere2alumno.php");
    } else {
        // Si no está en 'estudiant', buscamos en la tabla 'professor'
        $sqlProfessor = "SELECT * FROM professor WHERE nom_professor = '$usuario' AND pw_professor = '$contrasena'";
        $resultProfessor = mysqli_query($connexio, $sqlProfessor);

        if (mysqli_num_rows($resultProfessor) > 0) {
            // echo "¡Bienvenido, $usuario! Has ingresado como profesor.<br>";
                    // Si encontramos el profesor en la base de datos, guardamos su nombre en la sesión
        session_start(); // Iniciar la sesión
        $_SESSION['nombre_profesor'] = $usuario; // Guardamos el nombre del profesor en la sesión
        // Redirigimos al panel de control de profesores
            header("Location: lumiere2profe.php");
        } else {
            // Si no está en ninguna de las dos tablas
            $resultadologin = "  <span class='resultadologin'> Usuario y/o contraseña incorrectos. </span>";    
        }
    }
}

// Cerramos la conexión
mysqli_close($connexio);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Centre d'Estudis Lumiere </title>
    <link rel="stylesheet" href="lumiere.css">
    <link rel="icon" href="img/logo_lumiere-removebg-preview.png" type="image/x-icon">
</head>

<body>

    <div class="container">

        <img src="img/lumiere_logogrande.png" alt="">

        <br><br>

        <form action="" method="post" id="formulario">
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre" style="font-weight: bolder;">Usuari</label>
                    <input type="text" name="usuario" placeholder=" Nom d'usuari ">
                </div>
                <span id="snom"></span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contrasena" style="font-weight: bolder;">Contrasenya</label>
                    <input type="password" name="contrasena" placeholder=" Contrasenya ">
                </div>
                <span id="scon"></span>
            </div>

            <br>

            <?php

            $resultadologin;
            if ($resultadologin) {
                echo $resultadologin;
            }
            ?>

            <input type="submit"></input>
        </form>
    </div>



</body>

</html>