<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario = "id21450707_maicol";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetwork";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['fk_usuario'])) {
    $userId = $_SESSION['fk_usuario'];

    $query = "SELECT p.ID, p.Nombre, p.Apellido, p.RutaImagenPerfil, p.Biografia, p.Area
              FROM Profesores p
              WHERE p.ID = $userId";

    $resultado = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($resultado)) {
        echo '<div class="perfil-info">';
        echo '<div class="perfil-header">';
        echo '<img src="' . $row['RutaImagenPerfil'] . '" alt="Foto de perfil" class="perfil-imagen">';
        echo '<h1 class="nombre-apellido">' . $row['Nombre'] . ' ' . $row['Apellido'] . '</h1>';
        echo '</div>';
        echo '<div class="perfil-content">';
        echo '<div class="area-container">';
        echo '<p class="area">' . $row['Area'] . '</p>';
        echo '</div>';
        echo '<h2 class="seccion-titulo">Biografía</h2>';
        echo '<div class="biografia-container">';
        echo '<p class="biografia">' . $row['Biografia'] . '</p>';
        echo '</div>';
        echo '<p id="aviso">*En el apartado Editar Perfil podrás cambiar tu información de perfil</p>';
        echo '</div>';
    }
} else {
    echo '<p>*Error al mostrar la información de perfil, tal vez no has iniciado sesión aún*</p>';
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);


mysqli_close($conexion);
?>
