<?php
$servidor = "localhost";
$usuario = "id21450707_maicol_moreno";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetworkdb";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$sql = "SELECT publicaciones.*, usuarios.nombre, usuarios.foto_perfil
        FROM publicaciones
        JOIN usuarios ON publicaciones.fk_usuario = usuarios.usuario_id
        ORDER BY fecha_creacion DESC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$publicaciones = array();

while ($fila = mysqli_fetch_assoc($resultado)) {
    $publicaciones[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($publicaciones);

mysqli_close($conexion);
?>
