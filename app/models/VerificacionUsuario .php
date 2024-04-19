<?php
// Clase VerificacionUsuario que extiende UsuarioModel
class VerificacionUsuario extends UsuarioModel {

    // Método para validar las credenciales de inicio de sesión
    public function validarCredenciales($usuario, $contraseña) {
        try {
            // Escapar caracteres especiales para evitar inyección de SQL
            $usuario = $this->conn->real_escape_string($usuario);
            $contraseña = $this->conn->real_escape_string($contraseña);

            // Construir la consulta SQL para buscar el usuario por usuario y contraseña
            $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$contraseña'";

            // Ejecutar la consulta
            $result = $this->conn->query($sql);

            // Verificar si se encontró algún resultado
            if ($result->num_rows > 0) {
                // El usuario y contraseña son válidos
                return true;
            } else {
                // El usuario y contraseña son inválidos
                return false;
            }
        } catch (Exception $e) {
            // Capturar cualquier excepción y devolver una respuesta de error JSON
            return array('error' => 'Error al validar credenciales: ' . $e->getMessage());
        }
    }
}

// Verificar si se recibieron datos POST para iniciar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'login') {
    // Obtener los datos del formulario de inicio de sesión
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Crear una instancia de la clase VerificacionUsuario
    $verificacionUsuario = new VerificacionUsuario();

    // Validar las credenciales
    $resultado = $verificacionUsuario->validarCredenciales($usuario, $contraseña);

    // Crear una respuesta JSON
    $respuesta = array();

    // Verificar si las credenciales son válidas
    if ($resultado) {
        // Asignar el mensaje de éxito a la respuesta
        $respuesta['mensaje'] = "Inicio de sesión exitoso";
    } else {
        // Asignar el mensaje de error a la respuesta
        $respuesta['error'] = "Credenciales inválidas";
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>
