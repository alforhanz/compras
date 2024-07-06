<?php
class UsuarioModel {
    private $conn;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "compras";

        $this->conn = new mysqli($servername, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function insertarUsuario($nombre, $apellido, $usuario, $email, $contraseña, $fechaCreacion) {
        try {
            $nombre = $this->conn->real_escape_string($nombre);
            $apellido = $this->conn->real_escape_string($apellido);
            $usuario = $this->conn->real_escape_string($usuario);
            $email = $this->conn->real_escape_string($email);
            $contraseña = $this->conn->real_escape_string($contraseña);
            $fechaCreacion = $this->conn->real_escape_string($fechaCreacion);

            $sql = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, fechaCreacion) VALUES ('$nombre', '$apellido', '$usuario', '$email', '$contraseña', '$fechaCreacion')";

            if ($this->conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return array('error' => 'Error al insertar usuario: ' . $e->getMessage());
        }
    }
}

require_once("UsuarioModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $email = $_POST['correo'];
    $contraseña = $_POST['clave'];
    $fechaCreacion = date('Y-m-d H:i:s');

    $usuarioModel = new UsuarioModel();
    $resultado = $usuarioModel->insertarUsuario($nombre, $apellido, $usuario, $email, $contraseña, $fechaCreacion);

    $respuesta = array();

    if ($resultado === true) {
        $respuesta['mensaje'] = "Usuario insertado correctamente";
    } else {
        $respuesta['error'] = "Error al insertar usuario";
    }

    echo json_encode($respuesta);
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
