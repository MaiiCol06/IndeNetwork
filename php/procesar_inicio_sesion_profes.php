<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servidor = "localhost";
    $usuario = "id21948119_maiicol06";
    $contrasena = "Smith@2006";
    $basedatos = "id21948119_indenet";

 $conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

 if ($conexion->connect_error) {
    echo '<script>';
    echo 'alert("No se pudo conectar con la base de datos")';
    echo '</script>';
    die("Error de conexión: " . $conexion->connect_error);
 }

 $usuario = $_POST['correo'];
 $contraseña = $_POST['contrasena'];

 // Buscar en la tabla Profesores
 $sql = "SELECT ID FROM Profesores WHERE (Documento = ? OR Correo = ?) AND Contrasena = ?";
 $stmt = $conexion->prepare($sql);
 $stmt->bind_param("iss", $usuario, $usuario, $contraseña);
 $stmt->execute();
 $stmt->store_result();

 if ($stmt->num_rows > 0) {
    $stmt->bind_result($id);
    $stmt->fetch();
    $_SESSION['fk_usuario'] = $id;
    $_SESSION['es_profesor'] = true;

    echo '<script>';
    echo 'sessionStorage.setItem("esProfesor", "true");';
    echo 'sessionStorage.setItem("usuarioId", "' . $id . '");'; // Almacenar el ID del profesor
    echo 'window.location.href = "../html/muro.html";';
    echo '</script>';
    exit();
 } else {
    echo '<script>';
    echo 'sessionStorage.setItem("usuarioLogueado", "false");';
    echo 'alert("Contraseña incorrecta. Por favor, intente nuevamente.");';
    echo 'window.location.href = "../html/inicio-sesion-profes.html";';
    echo '</script>';
    exit();
 }

 $stmt->close();

 $conexion->close();
}
?>
