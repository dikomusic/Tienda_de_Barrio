<?php
session_start();
include_once '../models/Compra.php';
include_once '../models/Producto.php'; // Necesario para buscar producto

$modeloCompra = new Compra();
$modeloProducto = new Producto();

// Inicializar carrito de compras (separado del de ventas)
if (!isset($_SESSION['carrito_compra'])) {
    $_SESSION['carrito_compra'] = [];
}

// ACCIÓN 1: AGREGAR AL CARRITO
if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo']; // RF-21: Costo ingresado manualmente

    // EXCEPCIÓN 3: Valores Inválidos
    if ($cantidad <= 0 || $costo <= 0) {
        header("Location: ../views/compras/registrar.php?error=valores");
        exit();
    }

    // RF-23: Buscar Producto
    // (Usamos la función auxiliar del modelo Venta o Producto para buscar por código)
    // Nota: Reutilizamos lógica simple de BD aquí para no complicar dependencias
    include_once '../config/conexion.php';
    $db = new Conexion();
    $conn = $db->getConexion();
    
    $stmt = $conn->prepare("SELECT * FROM productos WHERE codigo = :cod");
    $stmt->execute([':cod' => $codigo]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // EXCEPCIÓN 5: Producto Inactivo
        if($producto['estado'] == 0) {
            header("Location: ../views/compras/registrar.php?error=inactivo");
            exit();
        }

        $subtotal = $cantidad * $costo;

        $item = [
            'id_producto' => $producto['id_producto'],
            'codigo' => $producto['codigo'],
            'nombre' => $producto['nombre'],
            'cantidad' => $cantidad,
            'costo' => $costo,
            'subtotal' => $subtotal
        ];
        
        array_push($_SESSION['carrito_compra'], $item);
        header("Location: ../views/compras/registrar.php");
    } else {
        header("Location: ../views/compras/registrar.php?error=no_existe");
    }
}

// ACCIÓN 2: FINALIZAR COMPRA (RF-21)
if (isset($_POST['accion']) && $_POST['accion'] == 'finalizar') {
    $id_proveedor = $_POST['id_proveedor']; // RF-22 Seleccionar Proveedor
    
    // EXCEPCIÓN 4: Lista Vacía
    if (empty($_SESSION['carrito_compra'])) {
        header("Location: ../views/compras/registrar.php?error=vacio");
        exit();
    }

    $total = 0;
    foreach ($_SESSION['carrito_compra'] as $p) {
        $total += $p['subtotal'];
    }

    $id_usuario = $_SESSION['id_usuario'];

    if ($modeloCompra->registrarCompra($id_proveedor, $id_usuario, $total, $_SESSION['carrito_compra'])) {
        $_SESSION['carrito_compra'] = []; // Vaciar
        header("Location: ../views/compras/registrar.php?mensaje=exito");
    } else {
        header("Location: ../views/compras/registrar.php?error=bd");
    }
}

// ACCIÓN 3: VACIAR
if (isset($_GET['accion']) && $_GET['accion'] == 'vaciar') {
    $_SESSION['carrito_compra'] = [];
    header("Location: ../views/compras/registrar.php");
}

// ACCIÓN 4: ANULAR (RF-28)
if (isset($_GET['accion']) && $_GET['accion'] == 'anular') {
    
    // EXCEPCIÓN 2: Permisos Insuficientes (Solo Admin)
    if ($_SESSION['rol'] != 1) {
        die("ACCESO DENEGADO: Se requieren permisos de Administrador.");
    }

    $id = $_GET['id'];
    $resultado = $modeloCompra->anularCompra($id);

    if ($resultado == "OK") {
        header("Location: ../views/compras/historial.php?mensaje=anulado");
    } elseif ($resultado == "STOCK_ERROR") {
        // EXCEPCIÓN 1: Mensaje de error específico
        header("Location: ../views/compras/historial.php?error=stock_insuficiente");
    } else {
        header("Location: ../views/compras/historial.php?error=bd");
    }
}
?>