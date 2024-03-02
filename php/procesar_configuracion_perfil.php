<?php
$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['fk_usuario'])) {
    $userId = $_SESSION['fk_usuario'];

    if (isset($_POST['cancelar'])) {
        header("Location: ../html/perfil.html");
        exit();
    }    

    $updates = array();

    if (!empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $updates[] = "Nombre = '$nombre'";
    }

    if (!empty($_POST['apellido'])) {
        $apellido = $_POST['apellido'];
        $updates[] = "Apellido = '$apellido'";
    }

    if (!empty($_POST['contrasena'])) {
        $contrasena = $_POST['contrasena'];
        $updates[] = "Contrasena = '$contrasena'";
    }

    if (!empty($_POST['fecha-nacimiento'])) {
        $fecha_nacimiento = $_POST['fecha-nacimiento'];
        $updates[] = "FechaNacimiento = '$fecha_nacimiento'";
    }

    if (!empty($_POST['grado'])) {
        $grado = $_POST['grado'];
        $updates[] = "Grado = '$grado'";
    }

    if (!empty($_POST['grupo'])) {
        $grupo = $_POST['grupo'];
        $updates[] = "Grupo = '$grupo'";
    }

    if (!empty($_POST['biografia'])) {
        $biografia = $_POST['biografia'];
        $updates[] = "Biografia = '$biografia'";
    }

    if (!empty($_POST['intereses'])) {
        $intereses = $_POST['intereses'];
        $updates[] = "Intereses = '$intereses'";
    }

    if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
        $rutaImagenPerfil = "../img/perfil/" . basename($_FILES['foto-perfil']['name']);
        move_uploaded_file($_FILES['foto-perfil']['tmp_name'], $rutaImagenPerfil);
        $updates[] = "RutaImagenPerfil = '$rutaImagenPerfil'";
    }

    if (!empty($updates)) {
        $updateQuery = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE ID = $userId";

        if (mysqli_query($conexion, $updateQuery)) {
            header("location: ../html/perfil.html");
        } else {
            echo "Error al actualizar: " . mysqli_error($conexion);
        }
    } else {
        header("location: ../html/perfil.html");
    }
} else {
    header("location: ../index.html");
    exit();
}

mysqli_close($conexion);
?>
