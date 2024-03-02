<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    echo '<script>';
    echo 'alert("No se pudo conectar con la base de datos")';
    echo '</script>';
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$nombre = $_POST['nombre'];

$query = "SELECT ID, Nombre, Apellido, RutaImagenPerfil FROM usuarios WHERE Nombre LIKE '%$nombre%' OR Apellido LIKE '%$nombre%'";

$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo '<li>';

        echo '<img src="' . $row['RutaImagenPerfil'] . '" alt="Foto de perfil" class="foto-perfil">';
        
        echo '<div class="info-container">';
        echo '<span>' . $row['Nombre'] . ' ' . $row['Apellido'] . '</span>';
        echo '</div>';

        echo '</li>';
    }
    
} else {
    echo '<li>No se encontraron usuarios con ese nombre.</li>';
}

mysqli_close($conexion);
?>
