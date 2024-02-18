<?php
// Clase UsuarioModel
class UsuarioModel {
    private $conn;

    // Constructor para establecer la conexión
    public function __construct() {
        $servername = "127.0.0.1"; // Cambia esto si la base de datos no está en el mismo servidor
        $username = "root";
        $password = "";
        $database = "compras";

        // Crear conexión
        $this->conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

   // Función para insertar un nuevo usuario
public function insertarUsuario($nombre, $apellido, $usuario, $email, $contraseña, $fechaCreacion) {
    try {
        // Escapar caracteres especiales para evitar inyección de SQL
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        $usuario = $this->conn->real_escape_string($usuario);
        $email = $this->conn->real_escape_string($email);
        $contraseña = $this->conn->real_escape_string($contraseña);
        $fechaCreacion = $this->conn->real_escape_string($fechaCreacion);

        // Construir la consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, fechaCreacion) VALUES ('$nombre', '$apellido', '$usuario', '$email', '$contraseña', '$fechaCreacion')";

        // Ejecutar la consulta
        if ($this->conn->query($sql) === TRUE) {
            return true; // Éxito
        } else {
            return false; // Error
        }
    } catch (Exception $e) {
        // Capturar cualquier excepción y devolver una respuesta de error JSON
        return array('error' => 'Error al insertar usuario: ' . $e->getMessage());
    }
}   
}
// Incluye la definición de la clase UsuarioModel
require_once("UsuarioModel.php");
// Verificar si se recibieron datos POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $email = $_POST['correo'];
    $contraseña = $_POST['clave'];
    $fechaCreacion = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

    // Crear una instancia de la clase UsuarioModel
    $usuarioModel = new UsuarioModel();

    // Insertar un nuevo usuario en la base de datos
    $resultado = $usuarioModel->insertarUsuario($nombre, $apellido, $usuario, $email, $contraseña, $fechaCreacion);

    // Crear una respuesta JSON
    $respuesta = array();

    // Verificar si la inserción fue exitosa
    if ($resultado) {
        // Asignar el mensaje de éxito a la respuesta
        $respuesta['mensaje'] = "Usuario insertado correctamente";
    } else {
        // Asignar el mensaje de error a la respuesta
        $respuesta['error'] = "Error al insertar usuario";
    }

    // Devolver la respuesta en formato JSON
    echo json_encode($respuesta);
} else {
    // Si la solicitud no es POST, devolver un error
    http_response_code(405); // Método no permitido
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
