<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Bogota');

$servidor = "localhost";
$usuario = "id21948119_maiicol06";
$contrasena = "Smith@2006";
$basedatos = "id21948119_indenet";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$query = "SELECT p.ID, p.TextoContenido, p.ImagenRuta, p.ArchivoRuta, p.FechaHora,
          u.Nombre AS UsuarioNombre, u.Apellido AS UsuarioApellido, u.RutaImagenPerfil AS UsuarioImagen,
          pr.Nombre AS ProfesorNombre, pr.Apellido AS ProfesorApellido, pr.RutaImagenPerfil AS ProfesorImagen
          FROM Publicaciones p
          LEFT JOIN usuarios u ON p.fk_Usuario = u.ID
          LEFT JOIN Profesores pr ON p.fk_Profesor = pr.ID
          ORDER BY p.FechaHora DESC";

$resultado = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_assoc($resultado)) {
    // Decide si mostrar datos de usuario o profesor
    $nombre = isset($row['UsuarioNombre']) ? $row['UsuarioNombre'] : $row['ProfesorNombre'];
    $apellido = isset($row['UsuarioApellido']) ? $row['UsuarioApellido'] : $row['ProfesorApellido'];
    $imagenPerfil = isset($row['UsuarioImagen']) && !empty($row['UsuarioImagen']) ? $row['UsuarioImagen'] : (isset($row['ProfesorImagen']) && !empty($row['ProfesorImagen']) ? $row['ProfesorImagen'] : '../img/pagina/usuario.png');

    echo '<div class="publicacion">';
    echo '<div class="encabezado">';
    echo '<img src="' . $imagenPerfil . '" alt="Foto de perfil">';
    echo '<p>' . $nombre . ' ' . $apellido . '</p>';
    echo '</div>';
    // ...

    date_default_timezone_set('America/Bogota');

    $fechaHoraUTC = new DateTime($row['FechaHora'], new DateTimeZone('UTC'));
    $fechaHoraBogota = $fechaHoraUTC->setTimezone(new DateTimeZone('America/Bogota'));

    echo '<div class="fecha-hora">' . $fechaHoraBogota->format('d/m/Y g:i A') . '</div>';    

    $textoContenido = str_replace('\r\n', "\n", $row['TextoContenido']);
    echo '<div class="contenido">' . nl2br($textoContenido) . '</div>';
            
    if (!empty($row['ImagenRuta'])) {
        echo '<div class="imagen-container">';
        echo '<div class="imagen">';
        echo '<img src="' . $row['ImagenRuta'] . '" alt="Imagen adjunta">';
        echo '</div>';
        echo '</div>';
    }

    if (!empty($row['ArchivoRuta'])) {
        $archivo = pathinfo($row['ArchivoRuta']);
        $nombreArchivo = $archivo['basename'];
        $extensionArchivo = strtolower($archivo['extension']);
        $iconoTipoArchivo = "";

        switch ($extensionArchivo) {
            case 'pdf':
                $iconoTipoArchivo = '<i class="fas fa-file-pdf"></i>';
                break;
            case 'docx':
            case 'doc':
                $iconoTipoArchivo = '<i class="fas fa-file-word"></i>';
                break;
            case 'xlsx':
            case 'xls':
                $iconoTipoArchivo = '<i class="fas fa-file-excel"></i>';
                break;
            case 'pptx':
            case 'ppt':
                $iconoTipoArchivo = '<i class="fas fa-file-powerpoint"></i>';
                break;
            case 'mp4':
            case 'avi':
            case 'mov':
                $iconoTipoArchivo = '<i class="fas fa-file-video"></i>';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $iconoTipoArchivo = '<i class="fas fa-file-image"></i>';
                break;
            case 'txt':
                $iconoTipoArchivo = '<i class="fas fa-file-alt"></i>';
                break;
            default:
                $iconoTipoArchivo = '<i class="fas fa-file"></i>';
        }

        echo '<div class="archivo">';
        echo $iconoTipoArchivo . ' ' . $nombreArchivo . ' <a href="' . $row['ArchivoRuta'] . '" download><i class="fas fa-download"></i></a>';
        echo '</div>';
    }

    echo '<hr>';

    echo '<div class="interaciones">';
    echo '<div class="logo-cora" id="logo-cora" data-publicacion-id="' . $row['ID'] . '"></div>';
    echo '</div>';

    echo '</div>';
}

mysqli_close($conexion);

?>
