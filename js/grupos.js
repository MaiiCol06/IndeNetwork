document.addEventListener('DOMContentLoaded', function () {
    const mostrarFormularioButton = document.getElementById('mostrarFormulario');
    const formularioGrupo = document.getElementById('formularioGrupo');
    const fondoDifuminado = document.getElementById('fondoDifuminado');
    mostrarFormularioButton.addEventListener('click', () => {
        formularioGrupo.style.display = 'block';
        fondoDifuminado.style.display = 'block';
    });
    fondoDifuminado.addEventListener('click', () => {
        formularioGrupo.style.display = 'none';
        fondoDifuminado.style.display = 'none';
    });

    const formulario = document.getElementById('formulario-grupo');
    formulario.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(formulario);

        fetch('../php/creacion_grupos.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "Grupo creado con éxito") {
                    formulario.reset();
                    formularioGrupo.style.display = 'none';
                    fondoDifuminado.style.display = 'none';
                    window.location.href = '../html/grupos.html';
                } else {
                    alert('Error al crear el grupo.');
                }
            })
            .catch(() => {
                alert('Error al crear el grupo.');
            });
    });
    
    var esProfesor = sessionStorage.getItem("esProfesor");

   if (esProfesor === "true") {
       document.getElementById('mostrarFormulario').classList.remove('oculto');
   }
});
