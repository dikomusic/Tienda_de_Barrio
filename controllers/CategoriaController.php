<?php
session_once:
session_start();
include_once '../models/Categoria.php';

// Validar Permisos
if (!isset($_SESSION['rol'])) { 
    header("Location: ../index.php"); 
    exit(); 
}

$modelo = new Categoria();

// 1. CREAR CATEGORIA
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $modelo->crear($nombre);
    
    // TRUCO: Volver a productos y abrir modal categorias
    header("Location: ../views/productos/index.php?modal=cat");
    exit();
}

// 2. ELIMINAR CATEGORIA
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $modelo->eliminar($id); // Asegúrate de tener esta función en tu Modelo
    
    // TRUCO: Volver a productos y abrir modal categorias
    header("Location: ../views/productos/index.php?modal=cat");
    exit();
}
?>