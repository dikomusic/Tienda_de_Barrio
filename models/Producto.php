<?php
// models/Producto.php
include_once __DIR__ . '/../config/conexion.php';

class Producto {
    private $conn;
    private $table = "productos";

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    public function listar() {
        // CORRECCIÓN: Quitamos el "WHERE estado = 1" para que traiga TODOS
        $sql = "SELECT p.*, c.nombre_categoria, pr.empresa 
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                ORDER BY p.id_producto DESC"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NUEVO: Crear producto SIN pedir stock ni costo (empiezan en 0)
    public function crear($codigo, $nombre, $id_cat, $id_prov, $precio_venta, $imagen) {
        // Nota como 'stock_actual' y 'precio_compra' se ponen en 0 forzosamente
        $sql = "INSERT INTO productos (codigo, nombre, id_categoria, id_proveedor, precio_venta, imagen, stock_actual, precio_compra, estado) 
                VALUES (:cod, :nom, :cat, :prov, :p_venta, :img, 0, 0, 1)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':cod' => $codigo, 
            ':nom' => $nombre, 
            ':cat' => $id_cat, 
            ':prov' => $id_prov, 
            ':p_venta' => $precio_venta, 
            ':img' => $imagen
        ]);
    }
    // RF-13: Modificar Producto
    public function actualizar($id, $nombre, $desc, $p_compra, $p_venta, $stock, $min, $img, $cat, $prov) {
        // Nota: El código NO se edita por seguridad
        $sql = "UPDATE " . $this->table . " 
                SET nombre=:nom, descripcion=:desc, precio_compra=:pcom, precio_venta=:pven, 
                    stock_actual=:stock, stock_minimo=:min, imagen=:img, id_categoria=:cat, id_proveedor=:prov
                WHERE id_producto=:id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nombre, ':desc' => $desc, 
            ':pcom' => $p_compra, ':pven' => $p_venta, 
            ':stock' => $stock, ':min' => $min, 
            ':img' => $img, ':cat' => $cat, ':prov' => $prov, ':id' => $id
        ]);
    }

    // RF-14: Inhabilitar Producto
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE " . $this->table . " SET estado = :est WHERE id_producto = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':est' => $estado, ':id' => $id]);
    }

    // VALIDACIONES (RF-11 Excepciones)
    public function existeCodigo($codigo) {
        $stmt = $this->conn->prepare("SELECT id_producto FROM " . $this->table . " WHERE codigo = :cod");
        $stmt->execute([':cod' => $codigo]);
        return $stmt->rowCount() > 0;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT p.*, c.nombre_categoria, pr.empresa 
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                WHERE p.id_producto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // AUXILIARES PARA LOS SELECTS DEL FORMULARIO
    public function listarCategorias() {
        $stmt = $this->conn->query("SELECT * FROM categorias ORDER BY nombre_categoria ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarProveedores() {
        $stmt = $this->conn->query("SELECT * FROM proveedores ORDER BY empresa ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>