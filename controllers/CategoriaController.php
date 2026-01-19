<?php
session_start();
include_once '../models/Categoria.php';

// Seguridad: Solo Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../index.php"); exit(); }

$modelo = new Categoria();

if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $modelo->crear($nombre);
    header("Location: ../views/categorias/index.php");
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    // EXCEPCION 4: Validación de Integridad
    if ($modelo->tieneProductos($id)) {
        header("Location: ../views/categorias/index.php?error=en_uso");
    } else {
        $modelo->eliminar($id);
        header("Location: ../views/categorias/index.php");
    }
}
?>