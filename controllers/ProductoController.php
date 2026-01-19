<?php
// controllers/ProductoController.php
session_start();
include_once '../models/Producto.php';

// Seguridad: Solo Admin puede gestionar (Empleados solo ven, pero no gestionan por aqui)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

$modelo = new Producto();

if (isset($_POST['accion'])) {
    // Recoger datos básicos
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo']; // Solo para registrar
    $descripcion = $_POST['descripcion'];
    $p_compra = $_POST['precio_compra'];
    $p_venta = $_POST['precio_venta'];
    $stock = $_POST['stock'];
    $minimo = $_POST['stock_minimo'];
    $categoria = $_POST['id_categoria'];
    $proveedor = $_POST['id_proveedor'];

    // EXCEPCIÓN 3: Validar negativos (RF-20)
    if ($p_compra < 0 || $p_venta < 0 || $stock < 0) {
        header("Location: ../views/productos/formulario.php?error=negativo");
        exit();
    }

    // --- MANEJO DE IMAGEN (RF-12) ---
    $imagen_bd = isset($_POST['imagen_actual']) ? $_POST['imagen_actual'] : null; // Mantener la anterior si no cambia
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
        if (in_array($_FILES['imagen']['type'], $permitidos)) {
            $ruta = '../uploads/';
            if (!file_exists($ruta)) mkdir($ruta, 0777, true); // Crear carpeta si no existe
            
            $nombre_archivo = time() . "_" . $_FILES['imagen']['name']; // Nombre único
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $nombre_archivo);
            $imagen_bd = 'uploads/' . $nombre_archivo;
        } else {
            // EXCEPCIÓN 2: Formato inválido
            header("Location: ../views/productos/formulario.php?error=formato_imagen");
            exit();
        }
    }
    // ---------------------------------

    // CASO 1: REGISTRAR
    if ($_POST['accion'] == 'guardar') {
        // EXCEPCIÓN 1: Código Duplicado
        if ($modelo->existeCodigo($codigo)) {
            header("Location: ../views/productos/formulario.php?error=codigo_duplicado");
            exit();
        }

        if ($modelo->crear($codigo, $nombre, $descripcion, $p_compra, $p_venta, $stock, $minimo, $imagen_bd, $categoria, $proveedor)) {
            header("Location: ../views/productos/index.php?mensaje=creado");
        } else {
            header("Location: ../views/productos/formulario.php?error=bd");
        }
    }

    // CASO 2: EDITAR
    if ($_POST['accion'] == 'editar') {
        $id = $_POST['id_producto'];
        
        if ($modelo->actualizar($id, $nombre, $descripcion, $p_compra, $p_venta, $stock, $minimo, $imagen_bd, $categoria, $proveedor)) {
            header("Location: ../views/productos/index.php?mensaje=editado");
        } else {
            header("Location: ../views/productos/formulario.php?id=$id&error=bd");
        }
    }
}

// CASO 3: INHABILITAR (RF-14)
if (isset($_GET['accion']) && $_GET['accion'] == 'estado') {
    $id = $_GET['id'];
    $estado = $_GET['estado'];
    $modelo->cambiarEstado($id, $estado);
    header("Location: ../views/productos/index.php");
}
?>