<?php
session_start();
include_once '../models/Venta.php';

$modelo = new Venta();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// ACCIÓN 1: AGREGAR PRODUCTO AL CARRITO (Paso 2 y 3 de la Secuencia)
if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];

    $producto = $modelo->buscarPorCodigo($codigo);

    if ($producto) {
        // RF-30: VERIFICAR DISPONIBILIDAD STOCK
        if ($producto['stock_actual'] >= $cantidad) {
            
            // Calculamos subtotal
            $subtotal = $producto['precio_venta'] * $cantidad;

            // Agregamos a la sesión
            $item = [
                'id_producto' => $producto['id_producto'],
                'codigo' => $producto['codigo'],
                'nombre' => $producto['nombre'],
                'precio_venta' => $producto['precio_venta'],
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ];
            
            array_push($_SESSION['carrito'], $item);
            header("Location: ../views/ventas/registrar.php");
        } else {
            // EXCEPCIÓN 1: Stock Insuficiente
            header("Location: ../views/ventas/registrar.php?error=stock");
        }
    } else {
        header("Location: ../views/ventas/registrar.php?error=no_existe");
    }
}

// ACCIÓN 2: VACIAR CARRITO
if (isset($_GET['accion']) && $_GET['accion'] == 'vaciar') {
    $_SESSION['carrito'] = [];
    header("Location: ../views/ventas/registrar.php");
}

// ACCIÓN 3: FINALIZAR VENTA (RF-29)
if (isset($_POST['accion']) && $_POST['accion'] == 'finalizar') {
    
    // EXCEPCIÓN 3: Venta sin ítems
    if (empty($_SESSION['carrito'])) {
        header("Location: ../views/ventas/registrar.php?error=vacio");
        exit();
    }

    // RF-31: Calcular Total
    $total = 0;
    foreach ($_SESSION['carrito'] as $prod) {
        $total += $prod['subtotal'];
    }

    $id_usuario = $_SESSION['id_usuario'];

    if ($modelo->registrarVenta($id_usuario, $total, $_SESSION['carrito'])) {
        $_SESSION['carrito'] = []; // Limpiamos carrito
        header("Location: ../views/ventas/registrar.php?mensaje=exito");
    } else {
        header("Location: ../views/ventas/registrar.php?error=bd");
    }
}

// ACCIÓN 4: ANULAR VENTA (RF-34)
if (isset($_GET['accion']) && $_GET['accion'] == 'anular') {
    $id_venta = $_GET['id'];
    $modelo->anularVenta($id_venta);
    header("Location: ../views/ventas/historial.php?mensaje=anulado");
}
?>