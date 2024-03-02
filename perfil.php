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

    $query = "SELECT u.ID, u.Nombre, u.Apellido, u.RutaImagenPerfil, u.Biografia, u.Intereses, u.Grado, u.Grupo, u.FechaRegistro
              FROM usuarios u
              WHERE u.ID = $userId";

    $resultado = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($resultado)) {
        echo '<div class="perfil-info">';
        echo '<div class="perfil-header">';
        echo '<img src="' . $row['RutaImagenPerfil'] . '" alt="Foto de perfil" class="perfil-imagen">';
        echo '<h1 class="nombre-apellido">' . $row['Nombre'] . ' ' . $row['Apellido'] . '</h1>';
        echo '<p class="grado-grupo">' . $row['Grado'] . ' - ' . $row['Grupo'] . '</p>';
        echo '</div>';
        echo '<div class="perfil-content">';
        echo '<h2 class="seccion-titulo">Biografía</h2>';
        echo '<div class="biografia-container">';
        echo '<p class="biografia">' . $row['Biografia'] . '</p>';
        echo '</div>';
        echo '<h2 class="seccion-titulo">Intereses</h2>';
        echo '<div class="intereses-container">';
        echo '<p class="intereses">' . $row['Intereses'] . '</p>';
        echo '</div>';
        echo '<h2 class="seccion-titulo">Fecha de Registro</h2>';
        echo '<p class="fecha-registro">' . date('d/m/Y', strtotime($row['FechaRegistro'])) . '</p>';
        echo '</div>';
        echo '<p id="aviso">*En el apartado Editar Perfil podras cambiar tu información de perfil</p>';
        echo '</div>';
    }
}   else {
        echo '<p>*Error al mostrar la informacion de perfil, tal vez no has iniciado sesion aun*</p>';
        exit();
}

mysqli_close($conexion);
?>
