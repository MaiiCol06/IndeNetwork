<?php
if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
    $rutaImagenPerfil = "../img/perfil/" . basename($_FILES['foto-perfil']['name']);
    move_uploaded_file($_FILES['foto-perfil']['tmp_name'], $rutaImagenPerfil);
} else {
    $rutaImagenPerfil = "../img/pagina/usuario.png";
}

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
    $fechaNacimiento = mysqli_real_escape_string($conexion, $_POST['fecha-nacimiento']);
    $grado = !empty($_POST['grado']) ? mysqli_real_escape_string($conexion, $_POST['grado']) : 'NULL';
    $grupo = !empty($_POST['grupo']) ? mysqli_real_escape_string($conexion, $_POST['grupo']) : 'NULL';
    $intereses = mysqli_real_escape_string($conexion, $_POST['intereses']);
    
    $insertQuery = "INSERT INTO usuarios (Nombre, Apellido, CorreoElectronico, Contrasena, FechaNacimiento, Grado, Grupo, Intereses, RutaImagenPerfil) 
                    VALUES ('$nombre', '$apellido', '$correo', '$contrasena', '$fechaNacimiento', $grado, $grupo, '$intereses', '$rutaImagenPerfil')";

if (mysqli_query($conexion, $insertQuery)) {
    header("location: ../html/inicio-sesion.html");
        exit();
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }
}
mysqli_close($conexion);
?>
