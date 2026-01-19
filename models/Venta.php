<?php
include_once __DIR__ . '/../config/conexion.php';

class Venta {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // RF-29, RF-31, RF-32: REGISTRAR VENTA COMPLETA
    public function registrarVenta($id_usuario, $total, $carrito_productos) {
        try {
            // INICIO DE TRANSACCION (Todo o Nada)
            $this->conn->beginTransaction();

            // 1. Insertar Cabecera de Venta
            $sql = "INSERT INTO ventas (id_usuario, total, estado) VALUES (:usr, :tot, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':usr' => $id_usuario, ':tot' => $total]);
            $id_venta = $this->conn->lastInsertId();

            // 2. Procesar cada producto del carrito
            foreach ($carrito_productos as $prod) {
                // RF-32: DESCONTAR STOCK
                $sql_stock = "UPDATE productos SET stock_actual = stock_actual - :cant WHERE id_producto = :id";
                $stmt_stock = $this->conn->prepare($sql_stock);
                $stmt_stock->execute([':cant' => $prod['cantidad'], ':id' => $prod['id_producto']]);

                // 3. Insertar Detalle
                $sql_det = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) 
                            VALUES (:idv, :idp, :cant, :pre, :sub)";
                $stmt_det = $this->conn->prepare($sql_det);
                $stmt_det->execute([
                    ':idv' => $id_venta,
                    ':idp' => $prod['id_producto'],
                    ':cant' => $prod['cantidad'],
                    ':pre' => $prod['precio_venta'],
                    ':sub' => $prod['subtotal']
                ]);
            }

            // Si todo salió bien, confirmamos cambios
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            // Si algo falló, deshacemos todo
            $this->conn->rollBack();
            return false;
        }
    }

    // RF-35: CONSULTAR HISTORIAL
    public function listarHistorial() {
        $sql = "SELECT v.*, CONCAT(u.nombres, ' ', u.apellido_paterno) as vendedor 
                FROM ventas v 
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario 
                ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // RF-34 y RF-33: ANULAR VENTA Y RESTAURAR STOCK
    public function anularVenta($id_venta) {
        try {
            $this->conn->beginTransaction();

            // 1. Cambiar estado a ANULADO (0)
            $sql = "UPDATE ventas SET estado = 0 WHERE id_venta = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id_venta]);

            // 2. Obtener los productos de esa venta para devolverlos
            $sql_det = "SELECT id_producto, cantidad FROM detalle_ventas WHERE id_venta = :id";
            $stmt_det = $this->conn->prepare($sql_det);
            $stmt_det->execute([':id' => $id_venta]);
            $detalles = $stmt_det->fetchAll(PDO::FETCH_ASSOC);

            // 3. RF-33: RESTAURAR STOCK
            foreach ($detalles as $item) {
                $sql_rest = "UPDATE productos SET stock_actual = stock_actual + :cant WHERE id_producto = :id";
                $stmt_rest = $this->conn->prepare($sql_rest);
                $stmt_rest->execute([':cant' => $item['cantidad'], ':id' => $item['id_producto']]);
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Función auxiliar para buscar producto por código en el POS
    public function buscarPorCodigo($codigo) {
        $sql = "SELECT * FROM productos WHERE codigo = :cod AND estado = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cod' => $codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>