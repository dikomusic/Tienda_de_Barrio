<?php
include_once '../config/conexion.php';

$db = new Conexion();
$conn = $db->getConexion();

// Usamos $_REQUEST para que puedas seguir probando desde el navegador
$termino = isset($_REQUEST['termino']) ? $_REQUEST['termino'] : '';

if($termino != '') {
    // CORRECCION: Usamos dos marcadores diferentes (:nom y :cod)
    $sql = "SELECT * FROM productos 
            WHERE (nombre LIKE :nom OR codigo LIKE :cod) 
            AND estado = 1 
            LIMIT 5"; 
            
    $stmt = $conn->prepare($sql);
    
    // CORRECCION: Enviamos el mismo término dos veces
    $stmt->execute([
        ':nom' => '%' . $termino . '%',
        ':cod' => '%' . $termino . '%'
    ]);
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($resultados);
}
?>