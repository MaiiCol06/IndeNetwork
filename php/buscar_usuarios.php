<?php
// buscar_usuarios.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Bogota');

$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Asegúrate de conectar a tu base de datos aquí

$textoBusqueda = $_POST['textoBusqueda'];

// Realiza la búsqueda en la base de datos para usuarios
$queryUsuarios = "SELECT * FROM usuarios WHERE Nombre LIKE ? OR Apellido LIKE ?";
$stmtUsuarios = $conexion->prepare($queryUsuarios);
$like = '%' . $textoBusqueda . '%';
$stmtUsuarios->bind_param('ss', $like, $like);
$stmtUsuarios->execute();
$resultUsuarios = $stmtUsuarios->get_result();

// Realiza la búsqueda en la base de datos para grupos
$queryGrupos = "SELECT * FROM Grupos WHERE NombreGrupo LIKE ?";
$stmtGrupos = $conexion->prepare($queryGrupos);
$stmtGrupos->bind_param('s', $like);
$stmtGrupos->execute();
$resultGrupos = $stmtGrupos->get_result();

$usuarios = [];
$grupos = [];

while ($row = $resultUsuarios->fetch_assoc()) {
    $usuarios[] = $row;
}

while ($row = $resultGrupos->fetch_assoc()) {
    $grupos[] = $row;
}

$resultados = [
    'usuarios' => $usuarios,
    'grupos' => $grupos
];

echo json_encode($resultados);
?>
