<?php
$servidor = "localhost";
$usuario = "id21450707_maicol";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetwork";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $archivoID = $_GET['id'];

    $conexion = new mysqli("localhost", "id21450707_maicol", "Smith@2006", "id21450707_indenetwork");

    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos..");
    }

    $sql = "SELECT ArchivoRuta FROM Publicaciones WHERE ID = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $archivoID);
        if ($stmt->execute()) {
            $stmt->bind_result($rutaArchivo);
            $stmt->fetch();
            if ($rutaArchivo) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"" . basename($rutaArchivo) . "/");
                readfile($rutaArchivo);
                exit;
            }
        }
        $stmt->close();
    }
    $conexion->close();
}

http_response_code(404);
echo "Error: Archivo no encontrado";
?>
