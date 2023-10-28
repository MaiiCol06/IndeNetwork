$(document).ready(function () {
    // Función para obtener y mostrar las publicaciones
    function obtenerYMostrarPublicaciones() {
        var colombiaTimezoneOffset = -5 * 60;

        $.ajax({
            url: 'obtener_publicaciones.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                // Recorre las publicaciones y agrégales al contenedor en la página
                postContainer.empty(); // Limpia el contenedor antes de agregar nuevas publicaciones

                response.forEach(function (publicacion) {
                    // Ajusta la hora de publicación al huso horario de Colombia
                    var fechaCreacion = new Date(publicacion.fecha_creacion);
                    fechaCreacion.setMinutes(fechaCreacion.getMinutes() + colombiaTimezoneOffset);

                    // Crea un nuevo elemento de publicación y muestra los datos
                    var nuevaPublicacion = $('<div class="post">');
                    nuevaPublicacion.append('<div class="post-header"><img src="/imagenes/Perfil/' + publicacion.foto_perfil + '" alt="Foto de perfil"><div class="post-info"><p class="post-author">' + publicacion.nombre + '</p><p class="post-date">' + fechaCreacion.toLocaleString() + '</p></div></div>');
                    nuevaPublicacion.append('<p class="post-content">' + publicacion.contenido + '</p>');

                    // Si hay una imagen en la publicación, agrégala
                    if (publicacion.imagen) {
                        nuevaPublicacion.append('<img src="/imagenes/Publicaciones' + publicacion.imagen + '" alt="Imagen de la publicación">');
                    }

                    // Agrega la publicación al contenedor principal
                    postContainer.append(nuevaPublicacion);
                });
            }
        });
    }

    var modal = document.getElementById('modalNuevaPub');
    var btn = document.getElementById('btnNuevaPub');
    var close = document.querySelector('.close');
    var postContainer = $('#post-container'); // Usamos jQuery para seleccionar el contenedor

    // Llamar a la función para obtener y mostrar publicaciones al cargar la página
    obtenerYMostrarPublicaciones();

    // Agregar evento al botón de publicación
    btn.addEventListener('click', () => {
        modal.classList.toggle('visible');
    });

    close.addEventListener('click', () => {
        modal.classList.remove('visible');
    });

    // Evento para procesar una nueva publicación
    $('#form-de-publicacion').submit(function (event) {
        event.preventDefault();
        // Código para procesar la publicación en el servidor (deberás ajustarlo según tus necesidades)

        // Después de una inserción exitosa, llamar a la función para obtener y mostrar publicaciones
        obtenerYMostrarPublicaciones();
    });
});
