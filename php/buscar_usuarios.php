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

try {
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

    $queryProfesores = "SELECT * FROM Profesores WHERE Nombre LIKE ? OR Apellido LIKE ?";
    $stmtProfesores = $conexion->prepare($queryProfesores);
    $stmtProfesores->bind_param('ss', $like, $like);
    $stmtProfesores->execute();
    $resultProfesores = $stmtProfesores->get_result();

    $usuarios = [];
    $grupos = [];
    $profesores = [];

    while ($row = $resultUsuarios->fetch_assoc()) {
        $usuarios[] = $row;
    }

    while ($row = $resultGrupos->fetch_assoc()) {
        $grupos[] = $row;
    }

    while ($row = $resultProfesores->fetch_assoc()) {
        $profesores[] = $row;
    }

    $resultados = [
        'usuarios' => $usuarios,
        'grupos' => $grupos,
        'profesores' => $profesores
    ];

    // Asegúrate de que la respuesta sea un JSON válido
    header('Content-Type: application/json');
    echo json_encode($resultados);
} 
catch (Exception $e) {
    // Si hay un error, devuelve un JSON con un mensaje de error
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
