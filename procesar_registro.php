<?php

// Conexión a la BD
$servidor = "localhost";
$usuario = "id21450707_maicol_moreno";
$contrasena = "Smith@2006";
$basedatos = "id21450707_indenetworkdb";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

// Recuperar datos del formulario
$nombre = $_POST['nombre'];
$usuario = $_POST['nombre_usuario'];
$email = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$grado = $_POST['grado'];
$interes = $_POST['intereses'];
$biografia = $_POST['biografia'];

// Manejo de la foto de perfil
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['size'] > 0) {
    $directorio_foto_perfil = 'imagenes/perfil/';
    
    $foto_perfil_nombre = uniqid() . '_' . $_FILES['foto_perfil']['name'];
    $ruta_foto_perfil = $directorio_foto_perfil . $foto_perfil_nombre;

    move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_foto_perfil);
} else {
    $foto_perfil_nombre = 'default.jpg';
}

// Insertar nuevo usuario especificando nombres de columnas
$sql = "INSERT INTO usuarios (nombre, nombre_usuario, correo_electronico, contrasena, grado, intereses, foto_perfil, biografia)  
       VALUES ('$nombre', '$usuario', '$email', '$contrasena', '$grado', '$interes', '$foto_perfil_nombre', '$biografia')";

if (!mysqli_query($conexion, $sql)) {
    die("Error al insertar en la BD: " . mysqli_error($conexion));
}

// Redirigir al formulario de inicio de sesión
header("Location: login.html");
