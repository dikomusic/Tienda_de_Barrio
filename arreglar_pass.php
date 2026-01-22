<?php
// ARCHIVO TEMPORAL PARA ARREGLAR CONTRASEÑA
include_once 'config/conexion.php';

$db = new Conexion();
$conn = $db->getConexion();

// 1. CONFIGURACIÓN
$usuario_a_arreglar = "admin"; // <--- PON AQUI TU USUARIO EXACTO (ej: admin, edson, etc)
$nueva_clave = "admin";        // <--- PON AQUI LA CONTRASEÑA QUE QUIERES USAR

// 2. ENCRIPTAR
$clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

// 3. ACTUALIZAR EN BASE DE DATOS
$sql = "UPDATE usuarios SET clave = :pass WHERE cuenta = :usr";
$stmt = $conn->prepare($sql);
$res = $stmt->execute([':pass' => $clave_hash, ':usr' => $usuario_a_arreglar]);

if($res) {
    echo "<h1>¡LISTO! ✅</h1>";
    echo "<p>La contraseña para el usuario <b>'$usuario_a_arreglar'</b> ahora es <b>'$nueva_clave'</b> (pero encriptada).</p>";
    echo "<a href='login.php'>Ir a Iniciar Sesión</a>";
} else {
    echo "<h1>ERROR ❌</h1>";
    echo "No se pudo actualizar. Verifica que el usuario '$usuario_a_arreglar' exista en la columna 'cuenta'.";
}
?>