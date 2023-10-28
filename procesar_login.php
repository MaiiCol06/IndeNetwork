<?php

// Conexión a la BD
$servidor = "localhost";
$usuario = "id21450707_maicol_moreno"; 
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetworkdb";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);   

// Verificación de la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Recuperar datos del formulario
$usuario = $_POST['nombre_usuario'];
$contraseña = $_POST['contrasena']; // Corregido el nombre del campo

// Escapar las variables para evitar SQL Injection
$usuario = mysqli_real_escape_string($conexion, $usuario);
$contraseña = mysqli_real_escape_string($conexion, $contraseña);

// Consulta para verificar credenciales
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$usuario' AND contrasena = '$contraseña'";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) {
    // Credenciales correctas
    session_start(); // Iniciar la sesión
    $_SESSION['fk_usuario'] = $usuario; // Establecer el ID de usuario en la sesión
    header("Location: feed.html");
    exit();
} else {
    // Usuario o contraseña incorrectos
    echo "Usuario o contraseña incorrectos";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

?>
