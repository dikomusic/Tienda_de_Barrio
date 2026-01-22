<?php
include_once __DIR__ . '/../config/conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConexion();
    }

    // 1. LOGIN (¡ESTA ES LA FUNCION QUE FALTABA!)
    public function login($cuenta, $clave) {
        // Buscamos por la columna 'cuenta' (tu usuario) y que esté activo
        $sql = "SELECT * FROM usuarios WHERE cuenta = :cta AND estado = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cta' => $cuenta]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos la contraseña encriptada
        if ($user && password_verify($clave, $user['clave'])) {
            return $user;
        }
        return false;
    }

    // 2. LISTAR
    public function listar() {
        $sql = "SELECT 
                    id_usuario, ci, nombres, apellido_paterno, apellido_materno, 
                    cuenta, id_rol, estado 
                FROM usuarios 
                ORDER BY id_usuario DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. CREAR (Generación Automática de Usuario)
    public function crear($ci, $nombres, $apaterno, $amaterno, $rol) {
        // A) GENERAR USUARIO: 1ra letra Nombre + Ap Paterno + 1ra letra Materno
        // Ej: Juan Mamani Quispe -> jmamaniq
        $usuario_base = strtolower(substr($nombres, 0, 1) . $apaterno . substr($amaterno, 0, 1));
        $usuario_base = preg_replace('/\s+/', '', $usuario_base); // Quitar espacios

        // Validar duplicados y agregar número si existe (ej: jmamaniq1)
        $cuenta_final = $usuario_base;
        $contador = 0;
        do {
            $check = $this->conn->prepare("SELECT COUNT(*) FROM usuarios WHERE cuenta = :cta");
            $check->execute([':cta' => $cuenta_final]);
            if ($check->fetchColumn() > 0) {
                $contador++;
                $cuenta_final = $usuario_base . $contador;
            } else {
                break;
            }
        } while (true);

        // B) CLAVE PREDETERMINADA
        $clave_default = password_hash("Tienda de Barrio", PASSWORD_DEFAULT);

        // C) INSERTAR
        $sql = "INSERT INTO usuarios (ci, nombres, apellido_paterno, apellido_materno, cuenta, clave, id_rol, estado, fecha_registro) 
                VALUES (:ci, :nom, :ape, :ama, :cta, :pass, :rol, 1, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':ci' => $ci,
            ':nom' => $nombres,
            ':ape' => $apaterno,
            ':ama' => $amaterno,
            ':cta' => $cuenta_final,
            ':pass' => $clave_default,
            ':rol' => $rol
        ]);
    }

    // 4. ACTUALIZAR
    public function actualizar($id, $ci, $nombres, $apaterno, $amaterno, $rol) {
        $sql = "UPDATE usuarios SET ci=:ci, nombres=:nom, apellido_paterno=:ape, apellido_materno=:ama, id_rol=:rol 
                WHERE id_usuario=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':ci' => $ci, ':nom' => $nombres, ':ape' => $apaterno, ':ama' => $amaterno, ':rol' => $rol, ':id' => $id
        ]);
    }

    // 5. RESTABLECER CLAVE
    public function restablecerClave($id) {
        $clave_default = password_hash("Tienda de Barrio", PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET clave = :pass WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pass' => $clave_default, ':id' => $id]);
    }

    // 6. CAMBIAR ESTADO
    public function cambiarEstado($id, $nuevo_estado) {
        $sql = "UPDATE usuarios SET estado = :est WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':est' => $nuevo_estado, ':id' => $id]);
    }
    
    // 7. OBTENER POR ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarPropiaClave($id, $nueva_clave) {
        $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET clave = :pass WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pass' => $clave_hash, ':id' => $id]);
    }
}
?>