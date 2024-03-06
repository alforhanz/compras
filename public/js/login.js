function validaUsuarios() {
    // Obtener los valores de usuario y contraseña del formulario
    var usuario = document.querySelector('input[name="username"]').value;
    var contraseña = document.querySelector('input[name="password"]').value;

    // Crear un objeto FormData para enviar los datos al servidor
    var formData = new FormData();
    formData.append('usuario', usuario);
    formData.append('contraseña', contraseña);

    // Realizar la solicitud AJAX
    $.ajax({
        url: '../../app/models/LoginModel.php', // Reemplaza 'ruta/a/tu/archivo/php' con la ruta correcta a tu archivo PHP
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Manejar la respuesta del servidor
            var data = JSON.parse(response);
            if (data.success) {
                // Si la autenticación fue exitosa, redirigir o mostrar un mensaje de bienvenida
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1700
                  });
                window.location.href = 'ruta/a/la/página/principal'; // Reemplaza 'ruta/a/la/página/principal' con la ruta correcta
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
