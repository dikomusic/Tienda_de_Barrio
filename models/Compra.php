<?php
include_once __DIR__ . '/../config/conexion.php';

class Compra {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // RF-21 y RF-25: REGISTRAR COMPRA Y AUMENTAR STOCK
    public function registrarCompra($id_proveedor, $id_usuario, $total, $carrito) {
        try {
            $this->conn->beginTransaction();

            // 1. Insertar Cabecera
            $sql = "INSERT INTO compras (id_proveedor, id_usuario, total, estado) VALUES (:prov, :usr, :tot, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt_stock->execute([
    ':cant' => $item['cantidad'], 
    ':id' => $item['id_producto'],
    ':costo' => $item['costo'] // <--- ¡ESTO FALTABA!
]);
            $id_compra = $this->conn->lastInsertId();

            // 2. Procesar detalles
            foreach ($carrito as $item) {
                // RF-25: AUMENTAR STOCK (Suma)
                $sql_stock = "UPDATE productos SET stock_actual = stock_actual + :cant, precio_compra = :costo WHERE id_producto = :id";
                $stmt_stock = $this->conn->prepare($sql_stock);
                $stmt_stock->execute([':cant' => $item['cantidad'], ':id' => $item['id_producto']]);

                // 3. Guardar Detalle
                $sql_det = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio_costo, subtotal) 
                            VALUES (:idc, :idp, :cant, :costo, :sub)";
                $stmt_det = $this->conn->prepare($sql_det);
                $stmt_det->execute([
                    ':idc' => $id_compra,
                    ':idp' => $item['id_producto'],
                    ':cant' => $item['cantidad'],
                    ':costo' => $item['costo'], // Importante: Guardamos el costo
                    ':sub' => $item['subtotal']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // RF-26: CONSULTAR HISTORIAL
    public function listarHistorial() {
        $sql = "SELECT c.*, p.empresa, CONCAT(u.nombres, ' ', u.apellido_paterno) as usuario
                FROM compras c
                INNER JOIN proveedores p ON c.id_proveedor = p.id_proveedor
                INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                ORDER BY c.fecha_compra DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // RF-28: ANULAR COMPRA (Con validación de Excepción 1)
    public function anularCompra($id_compra) {
        try {
            $this->conn->beginTransaction();

            // 1. Obtener los productos de esa compra
            $sql_det = "SELECT id_producto, cantidad FROM detalle_compras WHERE id_compra = :id";
            $stmt_det = $this->conn->prepare($sql_det);
            $stmt_det->execute([':id' => $id_compra]);
            $detalles = $stmt_det->fetchAll(PDO::FETCH_ASSOC);

            // EXCEPCIÓN 1: Verificar si hay stock suficiente para devolver
            foreach ($detalles as $item) {
                // Consultamos stock actual
                $stmt_check = $this->conn->prepare("SELECT stock_actual FROM productos WHERE id_producto = :id");
                $stmt_check->execute([':id' => $item['id_producto']]);
                $prod = $stmt_check->fetch(PDO::FETCH_ASSOC);

                // Si quiero anular una compra de 10, pero solo me quedan 5 en stock (porque ya vendí), ERROR.
                if ($prod['stock_actual'] < $item['cantidad']) {
                    throw new Exception("STOCK_INSUFICIENTE");
                }
            }

            // 2. Si pasó la prueba, procedemos a anular
            $sql_anular = "UPDATE compras SET estado = 0 WHERE id_compra = :id";
            $stmt_anular = $this->conn->prepare($sql_anular);
            $stmt_anular->execute([':id' => $id_compra]);

            // 3. RESTAR el stock (Reversión)
            foreach ($detalles as $item) {
                $sql_rest = "UPDATE productos SET stock_actual = stock_actual - :cant WHERE id_producto = :id";
                $stmt_rest = $this->conn->prepare($sql_rest);
                $stmt_rest->execute([':cant' => $item['cantidad'], ':id' => $item['id_producto']]);
            }

            $this->conn->commit();
            return "OK";

        } catch (Exception $e) {
            $this->conn->rollBack();
            if ($e->getMessage() == "STOCK_INSUFICIENTE") {
                return "STOCK_ERROR";
            }
            return "ERROR_BD";
        }
    }

    // NUEVA FUNCION: Para ver el detalle en la ventana modal
    public function obtenerDetallesCompra($id_compra) {
        $sql = "SELECT d.*, p.nombre, p.codigo 
                FROM detalle_compras d
                INNER JOIN productos p ON d.id_producto = p.id_producto
                WHERE d.id_compra = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_compra]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>