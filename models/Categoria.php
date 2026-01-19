<?php
include_once __DIR__ . '/../config/conexion.php';

class Categoria {
    private $conn;
    private $table = "categorias";

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    public function listar() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id_categoria DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre) {
        $sql = "INSERT INTO " . $this->table . " (nombre_categoria) VALUES (:nom)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':nom' => $nombre]);
    }

    // EXCEPCION 4: Verificar si está en uso antes de borrar
    public function tieneProductos($id) {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE id_categoria = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public function eliminar($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id_categoria = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>