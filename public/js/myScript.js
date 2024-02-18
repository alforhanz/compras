function registrarUsuario() {
    // Obtén el formulario
    var form = document.getElementById('registro-form');

    // Agrega un evento de envío al formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previene el envío del formulario por defecto

        // Obtén los valores de las contraseñas
        var password = document.getElementById('password').value;
        var password2 = document.getElementById('password2').value;

        // Verifica si las contraseñas coinciden
        if (password !== password2) {
            // Las contraseñas no coinciden, muestra un mensaje de error y detén el envío del formulario
            console.log('Las contraseñas no coinciden');
            return;
        }

        // Obtén los datos del formulario
        var formData = {
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            usuario: document.getElementById('usuario').value,
            correo: document.getElementById('mail').value,
            clave: password // Utiliza solo la primera contraseña para enviar al servidor
        };

        // Envía los datos al archivo PHP usando AJAX
        $.ajax({
            type: 'POST',
            url: '../../app/models/UsuarioModel.php',
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(data) {
           
                console.log(data); // Imprimir el mensaje recibido desde el servidor
          
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Registro Exitoso",
                    showConfirmButton: false,
                    timer: 1500
                  });            
            // Redirigir al usuario al índice
            window.location.href = '../../index.html'; // Cambia 'index.html' a la ruta correcta de tu página de inicio
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX..', textStatus, errorThrown);
        });
    });
}

// Llama a la función registrarUsuario cuando el documento esté listo
$(document).ready(function() {
    registrarUsuario();
});


/////////////////////LOGIN//////////////////////////////////////////////////////////////

function validaUsuarios(action) {
    // Obtener los valores de usuario y contraseña del formulario
    var usuario = document.querySelector('input[name="username"]').value;
    var contraseña = document.querySelector('input[name="password"]').value;

    // Crear un objeto FormData para enviar los datos al servidor
    var formData = new FormData();
    formData.append('usuario', usuario);
    formData.append('contraseña', contraseña);
    formData.append('action', action); // Agregar el parámetro 'action'

    // Realizar la solicitud AJAX
    $.ajax({
        url: '../../app/models/UsuarioModel.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Manejar la respuesta del servidor
            var data = JSON.parse(response);
            if (data.success) {
                // Si la autenticación fue exitosa, redirigir o mostrar un mensaje de bienvenida
                //alert('Bienvenido ' + data.usuario.nombre + ' ' + data.usuario.apellido);
                window.location.href = 'dashcompras.html'; // Reemplaza 'ruta/a/la/página/principal' con la ruta correcta
            } else {
                // Si hubo un error de autenticación, mostrar un mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error
                });
            }
        },
        error: function(xhr, status, error) {
            // Si hubo un error en la solicitud AJAX, mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al realizar la solicitud. Por favor, inténtalo de nuevo más tarde.'
            });
        }
    });
}
