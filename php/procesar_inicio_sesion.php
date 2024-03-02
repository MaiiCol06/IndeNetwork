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

    $correo = $_POST['correo'];
    $contraseña = $_POST['contrasena'];

    // Verificar si el correo electrónico existe
    $sql = "SELECT ID FROM usuarios WHERE CorreoElectronico = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Si el correo no existe, redirigir al usuario a la página de registro
        echo '<script>';
        echo 'alert("El correo electrónico no está registrado. Por favor, regístrate.");';
        echo 'window.location.href = "../html/registro.html";';
        echo '</script>';
        exit();
    } else {
        // Si el correo existe, verificar la contraseña
        $sql = "SELECT ID FROM usuarios WHERE CorreoElectronico = ? AND Contrasena = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $correo, $contraseña);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $_SESSION['fk_usuario'] = $id;

            echo '<script>';
            echo 'sessionStorage.setItem("usuarioLogueado", "true");';
            echo 'sessionStorage.setItem("usuarioId", "' . $id . '");';
            echo 'window.location.href = "../html/muro.html";';
            echo '</script>';
            exit();
        } else {
            // Si la contraseña es incorrecta, mostrar un mensaje de alerta
            echo '<script>';
            echo 'alert("Contraseña incorrecta. Por favor, intente nuevamente.");';
            echo 'window.location.href = "../html/inicio-sesion.html";';
            echo '</script>';
            exit();
        }
    }

    $stmt->close();
    $conexion->close();
}
?>
