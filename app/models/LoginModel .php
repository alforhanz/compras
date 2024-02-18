<?php
require_once("conexion.php");

class LoginModel  {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::obtenerConexion();
    }

    public function verificarCredenciales($usuario, $contraseña) {
        try {
            // Escapar caracteres especiales para evitar inyección de SQL
            $usuario = $this->conn->real_escape_string($usuario);
            $contraseña = $this->conn->real_escape_string($contraseña);

            // Construir la consulta SQL para verificar las credenciales
            $sql = "SELECT id, nombre, apellido, email FROM usuarios WHERE usuario = '$usuario' AND password = '$contraseña'";

            // Ejecutar la consulta
            $result = $this->conn->query($sql);

            // Verificar si se encontró un usuario con las credenciales proporcionadas
            if ($result && $result->num_rows > 0) {
                // Obtener los datos del usuario
                $usuarioData = $result->fetch_assoc();
                // Devolver los datos del usuario en formato JSON
                return json_encode(array('success' => true, 'usuario' => $usuarioData));
            } else {
                // Devolver un mensaje de error en formato JSON
                return json_encode(array('success' => false, 'error' => 'Credenciales inválidas'));
            }
        } catch (Exception $e) {
            // Capturar cualquier excepción y devolver una respuesta de error JSON
            return json_encode(array('success' => false, 'error' => 'Error al verificar credenciales: ' . $e->getMessage()));
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de login
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Crear una instancia de la clase UsuarioModel
    $usuarioModel = new UsuarioModel();

    // Verificar las credenciales del usuario
    $resultado = $usuarioModel->verificarCredenciales($usuario, $contraseña);

    // Devolver la respuesta en formato JSON
    echo $resultado;
} else {
    // Si la solicitud no es POST, devolver un error
    http_response_code(405); // Método no permitido
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
