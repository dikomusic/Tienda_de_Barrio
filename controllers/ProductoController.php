<?php
session_start();
include_once '../models/Producto.php';

// Validar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) { header("Location: ../login.php"); exit(); }

$modelo = new Producto();

// ACCIÓN: GUARDAR NUEVO PRODUCTO
if (isset($_POST['accion']) && $_POST['accion'] == 'guardar') {
    // 1. Recibimos SOLO los datos del nuevo formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $id_categoria = $_POST['id_categoria']; // Si esto llega vacío, da error
    $id_proveedor = $_POST['id_proveedor'];
    $precio_venta = $_POST['precio_venta'];

    // 2. Validación de Seguridad (Evita el error "Column cannot be null")
    if (empty($id_categoria) || empty($id_proveedor)) {
        // Si por alguna razón están vacíos, devolvemos al form con error
        header("Location: ../views/productos/formulario.php?error=faltan_datos");
        exit();
    }
    
    // 3. Manejo de la Imagen (Si no suben nada, pone una por defecto)
    $imagen = "default.png"; 
    if (isset($_FILES['imagen']) && $_FILES['imagen']['name']) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); } // Crea carpeta si no existe
        
        $nombre_archivo = time() . "_" . basename($_FILES["imagen"]["name"]); // Nombre único
        $target_file = $target_dir . $nombre_archivo;
        
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen = "uploads/" . $nombre_archivo;
        }
    }

    // 4. LLAMAMOS AL MODELO (OJO: Stock y Precio Compra inician en 0 automáticamente)
    $res = $modelo->crear($codigo, $nombre, $id_categoria, $id_proveedor, $precio_venta, $imagen);

    if ($res) {
        header("Location: ../views/productos/index.php"); // Éxito
    } else {
        header("Location: ../views/productos/formulario.php?error=db"); // Error BD
    }
    exit();
}

// ACCIÓN: ELIMINAR (Opcional, si lo necesitas)
if (isset($_GET['eliminar'])) {
    // ... lógica de eliminar
}

if (isset($_GET['accion']) && $_GET['accion'] == 'estado') {
    $id = $_GET['id'];
    $estado = $_GET['estado']; // 1 o 0
    
    $modelo->cambiarEstado($id, $estado);
    
    header("Location: ../views/productos/index.php");
    exit();
}
?>