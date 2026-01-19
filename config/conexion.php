<?php
// config/conexion.php

class Conexion {
    
    // Configuración de la BD (XAMPP por defecto)
    private $host = "localhost";
    private $db_name = "db_tienda_barrio";
    private $username = "root";
    private $password = ""; // En XAMPP la contraseña suele estar vacía
    private $charset = "utf8mb4";
    
    public $conn;

    // Método para obtener la conexión
    public function getConexion() {
        $this->conn = null;

        try {
            // Cadena de conexión (DSN)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            // Opciones para manejo de errores y emulación
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza errores reales
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arrays asociativos
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            // Crear la instancia PDO
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
            // (Opcional) Descomenta esto solo para probar si conecta, luego coméntalo
            // echo "¡Conexión exitosa a la Base de Datos!";

        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>