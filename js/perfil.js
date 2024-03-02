document.addEventListener("DOMContentLoaded", function() {
    var usuarioLogueado = sessionStorage.getItem("usuarioLogueado");
    var esProfesor = sessionStorage.getItem("esProfesor");

    if (!usuarioLogueado && esProfesor !== "true") {
        window.location.href = "../html/inicio-sesion.html";
    }
});

$(document).ready(function() {
    $.ajax({
        url: '../perfil.php',
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            $('#perfil_info_container').html(response);
        }
    });
});
