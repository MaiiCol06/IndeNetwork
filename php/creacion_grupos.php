<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$nombreGrupo = $_POST['NombreGrupo'];
$descripcionGrupo = $_POST['Descripcion'];
$fotoGrupo = $_FILES['FotoGrupo']['name'];
$privacidad = $_POST['Privacidad'];
$categoria = $_POST['Categoria'];
$asignatura = $_POST['Asignatura'];

$target_dir = "../img/perfil/grupo/";
$target_file = $target_dir . basename($fotoGrupo);
move_uploaded_file($_FILES["FotoGrupo"]["tmp_name"], $target_file);

$query = "INSERT INTO Grupos (NombreGrupo, Descripcion, FotoGrupo, Privacidad, Categoria, Asignatura) VALUES ('$nombreGrupo', '$descripcionGrupo', '$target_file', '$privacidad', '$categoria', '$asignatura')";

if (mysqli_query($conexion, $query)) {
    echo "Grupo creado con éxito";
} else {
    echo "Error al crear el grupo: " . mysqli_error($conexion);
}

mysqli_close($conexion);

?>
