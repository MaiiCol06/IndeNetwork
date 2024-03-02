<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$publicacionId = $_POST['publicacionId'];
$usuarioId = $_POST['usuarioId'];
$esProfesor = $_POST['esProfesor'] === 'true' ? 1 : 0;
$agregar = $_POST['agregar'] === 'true';

error_log("Recibido: publicacionId=$publicacionId, usuarioId=$usuarioId, esProfesor=$esProfesor, agregar=$agregar");


if ($agregar) {
    // Insertar like
    $sql = $esProfesor ? "INSERT INTO Likes (fk_Publicacion, fk_Profesor) VALUES (?, ?)" : "INSERT INTO Likes (fk_Publicacion, fk_Usuario) VALUES (?, ?)";
} else {
    // Eliminar like
    $sql = $esProfesor ? "DELETE FROM Likes WHERE fk_Publicacion = ? AND fk_Profesor = ?" : "DELETE FROM Likes WHERE fk_Publicacion = ? AND fk_Usuario = ?";
}

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => $conexion->error]);
    exit;
}
$stmt->bind_param("ii", $publicacionId, $usuarioId);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
    exit;
}

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conexion->close();
?>
