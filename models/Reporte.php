<?php
include_once __DIR__ . '/../config/conexion.php';

class Reporte {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // RF-36: Reporte de Ingresos (Suma total en un rango de fechas)
    public function obtenerTotalVentas($fecha_inicio, $fecha_fin) {
        // Aseguramos cubrir todo el día final agregando hora máxima
        $fecha_fin = $fecha_fin . " 23:59:59";
        
        $sql = "SELECT SUM(total) as total_ganado, COUNT(*) as cantidad_ventas 
                FROM ventas 
                WHERE estado = 1 
                AND fecha_venta BETWEEN :inicio AND :fin";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':inicio' => $fecha_inicio, ':fin' => $fecha_fin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // RF-39: Productos Más Vendidos (Top 5)
    public function obtenerMasVendidos($fecha_inicio, $fecha_fin) {
        $fecha_fin = $fecha_fin . " 23:59:59";

        $sql = "SELECT p.nombre, SUM(dv.cantidad) as total_unidades
                FROM detalle_ventas dv
                INNER JOIN ventas v ON dv.id_venta = v.id_venta
                INNER JOIN productos p ON dv.id_producto = p.id_producto
                WHERE v.estado = 1 
                AND v.fecha_venta BETWEEN :inicio AND :fin
                GROUP BY p.id_producto
                ORDER BY total_unidades DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':inicio' => $fecha_inicio, ':fin' => $fecha_fin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // RF-38: Identificar Productos Bajo Stock (Alerta)
    public function obtenerBajoStock() {
        $sql = "SELECT * FROM productos 
                WHERE stock_actual <= stock_minimo 
                AND estado = 1 
                ORDER BY stock_actual ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // RF-37: Reporte General de Stock (Inventario Completo)
    public function obtenerStockCompleto() {
        $sql = "SELECT p.*, c.nombre_categoria, pr.empresa 
                FROM productos p
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                INNER JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                WHERE p.estado = 1
                ORDER BY p.nombre ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>