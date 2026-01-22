<?php
include_once __DIR__ . '/../config/conexion.php';

class Venta {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // 1. REGISTRAR VENTA (Transacción Compleja)
    public function registrar($id_usuario, $total, $productos_carrito) {
        try {
            $this->conn->beginTransaction();

            // A) Insertar Cabecera de Venta
            $sql = "INSERT INTO ventas (id_usuario, fecha_venta, total, estado) VALUES (:user, NOW(), :total, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user' => $id_usuario, ':total' => $total]);
            $id_venta = $this->conn->lastInsertId();

            // B) Insertar Detalles y RESTAR Stock
            $sql_detalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES (:idv, :idp, :cant, :prec, :sub)";
            $sql_stock   = "UPDATE productos SET stock_actual = stock_actual - :cant WHERE id_producto = :idp";
            
            $stmt_det = $this->conn->prepare($sql_detalle);
            $stmt_stk = $this->conn->prepare($sql_stock);

            foreach ($productos_carrito as $prod) {
                // Guardar detalle
                $stmt_det->execute([
                    ':idv' => $id_venta,
                    ':idp' => $prod['id_producto'],
                    ':cant' => $prod['cantidad'],
                    ':prec' => $prod['precio'],
                    ':sub'  => $prod['subtotal']
                ]);

                // Restar stock
                $stmt_stk->execute([
                    ':cant' => $prod['cantidad'],
                    ':idp'  => $prod['id_producto']
                ]);
            }

            $this->conn->commit();
            return $id_venta; // Devolvemos el ID para imprimir el ticket si quieres
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 2. LISTAR HISTORIAL
    public function listarHistorial() {
        $sql = "SELECT v.*, u.nombres as vendedor 
                FROM ventas v 
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario 
                ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. OBTENER DETALLES (Para el Modal)
    public function obtenerDetalles($id_venta) {
        $sql = "SELECT d.*, p.nombre, p.codigo 
                FROM detalle_ventas d
                INNER JOIN productos p ON d.id_producto = p.id_producto
                WHERE d.id_venta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_venta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. ANULAR VENTA (Devolver productos al stock)
    public function anular($id_venta) {
        try {
            $this->conn->beginTransaction();

            // Obtener los productos de esa venta para devolverlos
            $detalles = $this->obtenerDetalles($id_venta);

            $sql_stock = "UPDATE productos SET stock_actual = stock_actual + :cant WHERE id_producto = :idp";
            $stmt_stk = $this->conn->prepare($sql_stock);

            foreach ($detalles as $d) {
                $stmt_stk->execute([':cant' => $d['cantidad'], ':idp' => $d['id_producto']]);
            }

            // Marcar venta como anulada (Estado 0)
            $sql_anular = "UPDATE ventas SET estado = 0 WHERE id_venta = :id";
            $stmt_anular = $this->conn->prepare($sql_anular);
            $stmt_anular->execute([':id' => $id_venta]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>