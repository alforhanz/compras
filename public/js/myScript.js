$(document).ready(function() {
    registrarUsuario();
});

function registrarUsuario() {
    var form = document.getElementById('registro-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var password = document.getElementById('password').value;
        var password2 = document.getElementById('password2').value;

        if (password !== password2) {
            console.log('Las contraseñas no coinciden');
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Las contraseñas no coinciden",
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        var formData = {
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            usuario: document.getElementById('usuario').value,
            correo: document.getElementById('mail').value,
            clave: password
        };

        $.ajax({
            type: 'POST',
            url: '../../app/models/UsuarioModel.php',
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(data) {
            console.log(data);
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Registro Exitoso",
                showConfirmButton: false,
                timer: 1500
            });
            window.location.href = '../../index.html';
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        });
    });
}
