<?php
include_once __DIR__ . '/../config/conexion.php';

class Dashboard {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    public function obtenerEstadisticas() {
        $stats = [];

        // 1. Total Productos (Activos)
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM productos WHERE estado = 1");
        $stats['total_productos'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // 2. Valor del Inventario (Precio Compra * Stock)
        $stmt = $this->conn->query("SELECT SUM(precio_compra * stock_actual) as valor FROM productos WHERE estado = 1");
        $stats['valor_inventario'] = $stmt->fetch(PDO::FETCH_ASSOC)['valor'] ?? 0;

        // 3. Ventas de HOY
        $stmt = $this->conn->query("SELECT SUM(total) as hoy FROM ventas WHERE DATE(fecha_venta) = CURDATE() AND estado = 1");
        $stats['ventas_hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['hoy'] ?? 0;

        // 4. Devoluciones/Anulaciones de HOY
        $stmt = $this->conn->query("SELECT SUM(total) as dev FROM ventas WHERE DATE(fecha_venta) = CURDATE() AND estado = 0");
        $stats['devoluciones'] = $stmt->fetch(PDO::FETCH_ASSOC)['dev'] ?? 0;

        return $stats;
    }

    public function obtenerStockBajo() {
        // Trae los 3 productos con menos stock
        $sql = "SELECT nombre, codigo, stock_actual 
                FROM productos 
                WHERE stock_actual <= stock_minimo AND estado = 1 
                ORDER BY stock_actual ASC LIMIT 3";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>