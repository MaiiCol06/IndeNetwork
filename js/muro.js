document.addEventListener("DOMContentLoaded", function () {
    var usuarioLogueado = sessionStorage.getItem("usuarioLogueado");
    var esProfesor = sessionStorage.getItem("esProfesor");
 
    if (!usuarioLogueado && esProfesor !== "true") {
        window.location.href = "../html/inicio-sesion.html";
    }

    var esProfesor = sessionStorage.getItem("esProfesor");
    var perfilLink = document.getElementById('perfilLink');
 
    if (esProfesor === "true") {
        perfilLink.setAttribute('href', '../html/perfil_profes.html');
    }

    cargarPublicaciones();
 
    const refreshButton = document.getElementById('refreshButton');
    refreshButton.addEventListener('click', cargarPublicaciones);
 
    const mostrarFormularioButton = document.getElementById('mostrarFormulario');
    const formularioPublicacion = document.getElementById('formularioPublicacion');
    const fondoDifuminado = document.getElementById('fondoDifuminado');
    mostrarFormularioButton.addEventListener('click', () => {
        formularioPublicacion.style.display = 'block';
        fondoDifuminado.style.display = 'block';
    });
 
    fondoDifuminado.addEventListener('click', () => {
        formularioPublicacion.style.display = 'none';
        fondoDifuminado.style.display = 'none';
    });
 
    const formulario = document.getElementById('formulario-publicacion');
    formulario.addEventListener('submit', function (event) {
        event.preventDefault();
        const contenido = document.getElementById('contenido').value;
 
        const formData = new FormData(formulario);
 
        fetch('../php/procesar_publicacion.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                   formulario.reset();
                   formularioPublicacion.style.display = 'none';
                   fondoDifuminado.style.display = 'none';
                   cargarPublicaciones();
                } else {
                   alert('Error al publicar.');
                }
            })
            .catch(() => {
                alert('Error al publicar.');
            });
    });

    function mostrarModal(src) {
        document.getElementById('modal').style.display = 'flex';
        document.getElementById('modalImage').src = src;
        document.getElementById('downloadButton').href = src; // Establece el enlace de descarga
        document.getElementById('downloadButton').style.display = 'block'; // Muestra el botón de descarga
        document.body.classList.add('body-no-scroll');
    }

    function ocultarModal() {
        document.getElementById('modal').style.display = 'none';
        document.body.classList.remove('body-no-scroll');
    }

    function cargarPublicaciones() {
       const publicacionesContainer = document.getElementById('publicaciones-container');
       publicacionesContainer.innerHTML = 'Cargando...';

       fetch('../muro.php')
           .then(response => response.ok ? response.text() : Promise.reject(`Error en la solicitud: ${response.status}`))
           .then(data => {
               publicacionesContainer.innerHTML = data;
               var images = document.getElementsByTagName('img');
               for (var i = 0; i < images.length; i++) {
                    images[i].addEventListener('click', function(event) {
                        event.preventDefault();
                        mostrarModal(this.src);
                    });
               }
           })
           .catch(error => {
               console.error('Error al cargar las publicaciones:', error);
               publicacionesContainer.innerHTML = 'Error al cargar las publicaciones.';
           });
    }
    
    window.onload = function() {
       var images = document.getElementsByTagName('img');
       for (var i = 0; i < images.length; i++) {
           images[i].addEventListener('click', function(event) {
               event.preventDefault();
               document.getElementById('modal').style.display = 'block';
               document.getElementById('modalImage').src = this.src;
           });
       }

        document.getElementById('closeModal').addEventListener('click', function() {
            ocultarModal();
        });
    }; 
    
    function toggleHeart(event) {
        var logoCora = event.target;
        if (logoCora.classList.contains('logo-cora')) {
            var publicacionId = logoCora.getAttribute('data-publicacion-id');
            var esProfesor = sessionStorage.getItem("esProfesor") === "true";
            var usuarioId = sessionStorage.getItem("usuarioId");

            if (logoCora.classList.contains('logo-cora-lleno')) {
                // Volver a la imagen original sin animación
                logoCora.style.backgroundImage = "url('../img/pagina/CoraVacio.ico')";
                logoCora.classList.remove('logo-cora-lleno', 'logo-cora-splash');
                // Eliminar like
                procesarLike(publicacionId, usuarioId, esProfesor, false);
            } else {
                // Cambiar a la imagen de "corazón lleno" con animación de salpicadura
                logoCora.style.backgroundImage = "url('../img/pagina/CoraLleno.ico')";
                logoCora.classList.add('logo-cora-lleno');
                logoCora.classList.add('logo-cora-splash');
                var agregar = !logoCora.classList.contains('logo-cora-lleno');
                procesarLike(publicacionId, usuarioId, esProfesor, agregar);
            }
        }
    }

    function procesarLike(publicacionId, usuarioId, esProfesor, agregar) {
        // Convertir valores booleanos a strings 'true' o 'false'
        var agregarStr = agregar ? 'true' : 'false';
        var esProfesorStr = esProfesor ? 'true' : 'false';

        console.log(`Enviando solicitud para ${agregar ? 'agregar' : 'eliminar'} like:`, { publicacionId, usuarioId, esProfesor, agregar });
    
        fetch('../php/procesar_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `publicacionId=${publicacionId}&usuarioId=${usuarioId}&esProfesor=${esProfesorStr}&agregar=${agregarStr}`,
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error al procesar el like.');
            }
        })
        .catch(() => {
            alert('Error al procesar el like.');
        });
    }

    // Delegación de eventos para manejar clics en elementos .logo-cora generados dinámicamente
    document.addEventListener('click', toggleHeart);
    

});
