<?php
$servidor = "localhost";
$usuario = "id21450707_maicol";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetwork";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

session_start();
if (isset($_SESSION['fk_usuario'])) {
    $id_usuario = (int) $_SESSION['fk_usuario'];
    $es_profesor = isset($_SESSION['es_profesor']) && $_SESSION['es_profesor'];

    $fk_profesor = $es_profesor ? $id_usuario : NULL;
    $fk_usuario = !$es_profesor ? $id_usuario : NULL;

    $texto_contenido = isset($_POST['texto']) ? $_POST['texto'] : '';
    $texto_contenido = mysqli_real_escape_string($conexion, $texto_contenido);     

    $ruta_imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "../img/publicacion/" . $nombre_imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    }

    $ruta_archivo = '';
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES['archivo']['name']);
        $ruta_archivo = "../archive/" . $nombre_archivo;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo);
    }

    $sql = "INSERT INTO Publicaciones (fk_Usuario, fk_Profesor, TextoContenido, ImagenRuta, ArchivoRuta) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iisss", $fk_usuario, $fk_profesor, $texto_contenido, $ruta_imagen, $ruta_archivo);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'error' => $stmt->error);
    }
    echo json_encode($response);

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../html/inicio-sesion.html");
    exit;
}
?>
