<?php
include_once __DIR__ . '/../config/conexion.php';

class Proveedor {
    private $conn;
    private $table = "proveedores";

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    public function listar() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id_proveedor DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($empresa, $vendedor, $tel, $dias) {
        $sql = "INSERT INTO " . $this->table . " (empresa, nombre_vendedor, telefono, dias_visita) VALUES (:emp, :ven, :tel, :dias)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':emp' => $empresa, ':ven' => $vendedor, ':tel' => $tel, ':dias' => $dias]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_proveedor = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $empresa, $vendedor, $tel, $dias) {
        $sql = "UPDATE " . $this->table . " SET empresa=:emp, nombre_vendedor=:ven, telefono=:tel, dias_visita=:dias WHERE id_proveedor=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':emp' => $empresa, ':ven' => $vendedor, ':tel' => $tel, ':dias' => $dias, ':id' => $id]);
    }
}
?>