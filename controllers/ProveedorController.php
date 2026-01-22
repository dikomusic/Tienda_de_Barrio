<?php
session_start();
include_once '../models/Proveedor.php';

// Validar Permisos
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { 
    header("Location: ../index.php"); 
    exit(); 
}

$modelo = new Proveedor();

// ACCION 1: GUARDAR O EDITAR
if (isset($_POST['accion'])) {
    $empresa = $_POST['empresa'];
    $vendedor = $_POST['nombre_vendedor'];
    $telefono = $_POST['telefono'];
    $dias = $_POST['dias_visita'];

    if ($_POST['accion'] == 'guardar') {
        $modelo->crear($empresa, $vendedor, $telefono, $dias);
    } 
    elseif ($_POST['accion'] == 'editar') {
        $id = $_POST['id_proveedor'];
        $modelo->actualizar($id, $empresa, $vendedor, $telefono, $dias);
    }
    
    // TRUCO: Agregamos ?modal=prov para avisar que reabra la ventana
    header("Location: ../views/productos/index.php?modal=prov");
    exit();
}

// ACCION 2: ELIMINAR
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $id = $_GET['id'];
    
    include_once '../config/conexion.php';
    $db = new Conexion();
    $conn = $db->getConexion();
    
    try {
        $stmt = $conn->prepare("DELETE FROM proveedores WHERE id_proveedor = :id");
        $stmt->execute([':id' => $id]);
    } catch (Exception $e) {
        header("Location: ../views/productos/index.php?modal=prov&error=no_borrar");
        exit();
    }

    // TRUCO: Agregamos ?modal=prov aquí también
    header("Location: ../views/productos/index.php?modal=prov");
    exit();
}
?>