<?php
session_start(); // Iniciar sesión si aún no está iniciada

if (!isset($_SESSION['fk_usuario'])) {
    // Redirigir al usuario si no ha iniciado sesión
    header("Location: login.html"); // Cambia el nombre del archivo de inicio de sesión si es diferente
    exit();
}

// Conexión a la BD
$conexion = mysqli_connect("localhost", "id21450707_maicol_moreno", "Smith@2006", "id21450707_indenetworkdb");

// Verificación de la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
    header("Location: login.html"); // Cambia el nombre del archivo de inicio de sesión si es diferente
    exit();
}

// Recuperar datos del formulario
$texto = $_POST['texto']; // Contenido del texto de la publicación
$imagen = $_FILES['imagen']; // Archivo de imagen subido

// Verificar si se cargó una imagen y guardarla
$imagen_nombre = null;
if ($imagen['size'] > 0) {
    // Asegúrate de que estás guardando los archivos dentro de la ruta permitida
    $ruta_imagen = 'imagenes/publicacion/' . uniqid() . '_' . $imagen['name'];
    
    if (!move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
        die("Error al mover el archivo");
    }
    
    $imagen_nombre = basename($ruta_imagen);
}

// Obtener el ID de usuario de la sesión
$nombre_usuario = $_SESSION['fk_usuario'];

// Obtener el ID de usuario a partir del nombre de usuario
$sql = "SELECT usuario_id FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
$resultado = mysqli_query($conexion, $sql);

if ($fila = mysqli_fetch_assoc($resultado)) {
    $fk_usuario = $fila['usuario_id'];
} else {
    header("Location: registro.html"); // Cambia el nombre del archivo de inicio de sesión si es diferente
    exit();
}

// Insertar nueva publicación
$sql = "INSERT INTO publicaciones (fk_usuario, contenido, imagen, fecha_creacion)  
       VALUES ('$fk_usuario', '$texto', '$imagen_nombre', NOW())";

if (!mysqli_query($conexion, $sql)) {
    die("Error al insertar en la BD: " . mysqli_error($conexion));
}

// Redirigir al feed
header("Location: feed.html");
?>
