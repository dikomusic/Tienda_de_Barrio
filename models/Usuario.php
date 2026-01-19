<?php
// --- BLOQUE DE DEPURACION (Para que veas el error si falla) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// -------------------------------------------------------------

include_once __DIR__ . '/../config/conexion.php';

class Usuario {
    private $conn;
    private $table = "usuarios";

    public function __construct() {
        // Verificamos si existe la clase Conexion antes de usarla
        if (class_exists('Conexion')) {
            $db = new Conexion();
            $this->conn = $db->getConexion();
        } else {
            die("Error Crítico: No se encuentra el archivo config/conexion.php o la clase Conexion.");
        }
    }

    // 1. LISTAR USUARIOS
    public function listar() {
        $sql = "SELECT u.*, r.nombre_rol, 
                CONCAT(u.nombres, ' ', u.apellido_paterno) as nombre_completo 
                FROM " . $this->table . " u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. REGISTRAR USUARIO
    public function crear($ci, $nom, $pat, $mat, $cel, $dir, $nac, $cuenta, $clave, $rol) {
        $sql = "INSERT INTO " . $this->table . " 
                (ci, nombres, apellido_paterno, apellido_materno, celular, direccion, fecha_nacimiento, cuenta, clave, id_rol, estado) 
                VALUES (:ci, :nom, :pat, :mat, :cel, :dir, :nac, :cta, :pass, :rol, 1)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':ci' => $ci, ':nom' => $nom, ':pat' => $pat, ':mat' => $mat, 
            ':cel' => $cel, ':dir' => $dir, ':nac' => $nac, 
            ':cta' => $cuenta, ':pass' => $clave, ':rol' => $rol
        ]);
    }

    // 3. ACTUALIZAR USUARIO
    public function actualizar($id, $ci, $nom, $pat, $mat, $cel, $dir, $nac, $rol) {
        $sql = "UPDATE " . $this->table . " 
                SET ci=:ci, nombres=:nom, apellido_paterno=:pat, apellido_materno=:mat, 
                    celular=:cel, direccion=:dir, fecha_nacimiento=:nac, id_rol=:rol
                WHERE id_usuario=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':ci' => $ci, ':nom' => $nom, ':pat' => $pat, ':mat' => $mat, 
            ':cel' => $cel, ':dir' => $dir, ':nac' => $nac, ':rol' => $rol, ':id' => $id
        ]);
    }

    // 4. RESTABLECER CLAVE
    public function restablecerClave($id, $claveDefecto) {
        $sql = "UPDATE " . $this->table . " SET clave = :pass WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pass' => $claveDefecto, ':id' => $id]);
    }

    // 5. CAMBIAR ESTADO (INHABILITAR)
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE " . $this->table . " SET estado = :est WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':est' => $estado, ':id' => $id]);
    }

    // 6. LOGIN INTELIGENTE (Maneja Excepciones 1 y 2)
    public function login($cuenta, $clave) {
        $sql = "SELECT * FROM " . $this->table . " WHERE cuenta = :cta LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cta' => $cuenta]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($clave == $row['clave']) {
                // EXCEPCIÓN 2: Cuenta Inactiva
                if ($row['estado'] == 0) return "INACTIVO"; 
                
                // Login Exitoso
                $row['nombre_completo'] = $row['nombres'] . " " . $row['apellido_paterno'];
                return $row;
            }
        }
        // EXCEPCIÓN 1: Datos Incorrectos
        return "ERROR_DATOS"; 
    }

    // --- FUNCIONES DE VALIDACIÓN (EXCEPCIONES 3 y 4) ---
    public function existeUsuario($cuenta) {
        $stmt = $this->conn->prepare("SELECT id_usuario FROM " . $this->table . " WHERE cuenta = :cta");
        $stmt->execute([':cta' => $cuenta]);
        return $stmt->rowCount() > 0;
    }

    public function existeCI($ci) {
        $stmt = $this->conn->prepare("SELECT id_usuario FROM " . $this->table . " WHERE ci = :ci");
        $stmt->execute([':ci' => $ci]);
        return $stmt->rowCount() > 0;
    }

    // --- AUXILIARES ---
    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function listarRoles() {
        $stmt = $this->conn->query("SELECT * FROM roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerClaveActual($id) {
        $stmt = $this->conn->prepare("SELECT clave FROM " . $this->table . " WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['clave'] : false;
    }

    public function cambiarClavePropia($id, $clave) {
        $sql = "UPDATE " . $this->table . " SET clave = :pass WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pass' => $clave, ':id' => $id]);
    }
}
?>