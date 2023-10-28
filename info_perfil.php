<?php
$servidor = "localhost";
$usuario = "id21450707_maicol_moreno";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetworkdb";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION['fk_usuario'])) {
    header("Location: login.html");
    exit();
}

$nombre_usuario = $_SESSION['fk_usuario'];

$sql = "SELECT usuario_id, nombre, nombre_usuario, foto_perfil FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $nombre = $row['nombre'];
    $nombre_usuario = $row['nombre_usuario'];
    $fotoPerfil = base64_encode($row['foto_perfil']);
} else {
    header("Location: login.html");
    exit();
}

echo $nombre;
echo $fotoPerfil;

mysqli_close($conexion);
?>
