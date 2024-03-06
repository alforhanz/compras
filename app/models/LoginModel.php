<?php
// Incluye la definición de la clase UsuarioModel
require_once("ConexionModel.php");

// Función para manejar la autenticación de usuarios
function autenticarUsuario($usuario, $contraseña) {
    // Crear una instancia de la clase UsuarioModel
    $usuarioModel = new UsuarioModel();

    // Validar las credenciales del usuario
    $usuarioValidado = $usuarioModel->validarCredenciales($usuario, $contraseña);

    // Crear una respuesta JSON
    $respuesta = array();

    // Verificar si el usuario fue validado
    if ($usuarioValidado) {
        // Asignar los datos del usuario validado a la respuesta
        $respuesta['success'] = true;
        $respuesta['usuario'] = $usuarioValidado;
    } else {
        // Si las credenciales son incorrectas, asignar un mensaje de error a la respuesta
        $respuesta['success'] = false;
        $respuesta['error'] = "Credenciales incorrectas";
    }

    // Devolver la respuesta en formato JSON
    echo json_encode($respuesta);
}

// Verificar si se recibieron datos POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Autenticar al usuario con las credenciales proporcionadas
    autenticarUsuario($usuario, $contraseña);
} else {
    // Si la solicitud no es POST, devolver un error
    http_response_code(405); // Método no permitido
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
