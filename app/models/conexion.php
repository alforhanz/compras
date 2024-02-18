<?php
class Conexion {
    public static function obtenerConexion() {
        $servername = "127.0.0.1"; // Cambia esto si la base de datos no está en el mismo servidor
        $username = "root";
        $password = "";
        $database = "compras";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
