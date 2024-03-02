<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
session_destroy();

echo '<script>';
echo 'sessionStorage.removeItem("usuarioLogueado");';
echo 'sessionStorage.removeItem("esProfesor");';
echo 'window.location.href = "../html/inicio-sesion.html";';
echo '</script>';
exit();
?>
