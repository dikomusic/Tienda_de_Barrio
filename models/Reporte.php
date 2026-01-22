<?php
include_once __DIR__ . '/../config/conexion.php';

class Reporte {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // 1. TARJETA: Total Vendido HOY
    public function ventasHoy() {
        $sql = "SELECT SUM(total) as total FROM ventas WHERE DATE(fecha_venta) = CURDATE() AND estado = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ? $res['total'] : 0;
    }

    // 2. TARJETA: Total Vendido este MES
    public function ventasMes() {
        $sql = "SELECT SUM(total) as total FROM ventas WHERE MONTH(fecha_venta) = MONTH(CURDATE()) AND YEAR(fecha_venta) = YEAR(CURDATE()) AND estado = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ? $res['total'] : 0;
    }

    // 3. TARJETA: Cantidad de Productos con Stock Bajo (< 5)
    public function stockBajo() {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE stock_actual <= 5 AND estado = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'];
    }

    // 4. GRAFICO: Ventas de los últimos 7 días
    public function ventasUltimos7Dias() {
        $sql = "SELECT DATE(fecha_venta) as fecha, SUM(total) as total 
                FROM ventas 
                WHERE fecha_venta >= DATE(NOW()) - INTERVAL 7 DAY AND estado = 1
                GROUP BY DATE(fecha_venta) 
                ORDER BY fecha_venta ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. TABLA: Top 5 Productos Más Vendidos
    public function productosMasVendidos() {
        $sql = "SELECT p.nombre, SUM(d.cantidad) as cantidad_total 
                FROM detalle_ventas d
                INNER JOIN ventas v ON d.id_venta = v.id_venta
                INNER JOIN productos p ON d.id_producto = p.id_producto
                WHERE v.estado = 1
                GROUP BY p.id_producto 
                ORDER BY cantidad_total DESC 
                LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>