<?php
session_start();
include_once '../models/Producto.php';
include_once '../models/Venta.php';

$prodModel = new Producto();
$ventaModel = new Venta();

// Inicializar carrito
if (!isset($_SESSION['carrito_venta'])) { $_SESSION['carrito_venta'] = []; }

// 1. AGREGAR AL CARRITO (Con validación de Stock)
if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $codigo = $_POST['codigo'];
    $cantidad_solicitada = (int)$_POST['cantidad']; // Por defecto viene 1 del form, pero puede ser mas

    if ($cantidad_solicitada <= 0) { header("Location: ../views/ventas/registrar.php?error=cantidad"); exit(); }

    // Buscar producto en BD (Necesitamos saber el stock real)
    // Nota: Debes tener un metodo 'buscarPorCodigo' en tu modelo Producto. Si no, usa listar y filtra.
    // Asumiremos que creaste buscarPorCodigo o usamos listar:
    $todos = $prodModel->listar(); 
    $producto = null;
    foreach($todos as $p) { if($p['codigo'] == $codigo) { $producto = $p; break; } }

    if ($producto) {
        if ($producto['estado'] == 0) { header("Location: ../views/ventas/registrar.php?error=inactivo"); exit(); }

        // --- VALIDACION DE STOCK ---
        $stock_maximo = $producto['stock_actual'];
        $cantidad_en_carrito = 0;

        // Revisar cuánto ya tenemos en el carrito de este producto
        foreach ($_SESSION['carrito_venta'] as $item) {
            if ($item['id_producto'] == $producto['id_producto']) {
                $cantidad_en_carrito = $item['cantidad'];
                break;
            }
        }

        $total_final = $cantidad_en_carrito + $cantidad_solicitada;

        if ($total_final > $stock_maximo) {
            header("Location: ../views/ventas/registrar.php?error=stock&max=".$stock_maximo);
            exit();
        }

        // --- AGREGAR O FUSIONAR ---
        $encontrado = false;
        foreach ($_SESSION['carrito_venta'] as $key => $item) {
            if ($item['id_producto'] == $producto['id_producto']) {
                $_SESSION['carrito_venta'][$key]['cantidad'] += $cantidad_solicitada;
                $_SESSION['carrito_venta'][$key]['subtotal'] = $_SESSION['carrito_venta'][$key]['cantidad'] * $item['precio'];
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $_SESSION['carrito_venta'][] = [
                'id_producto' => $producto['id_producto'],
                'codigo' => $producto['codigo'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio_venta'],
                'cantidad' => $cantidad_solicitada,
                'subtotal' => $cantidad_solicitada * $producto['precio_venta']
            ];
        }

        header("Location: ../views/ventas/registrar.php");
    } else {
        header("Location: ../views/ventas/registrar.php?error=no_existe");
    }
    exit();
}

// 2. ELIMINAR ITEM
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $index = $_GET['index'];
    array_splice($_SESSION['carrito_venta'], $index, 1);
    header("Location: ../views/ventas/registrar.php");
    exit();
}

// 3. CANCELAR VENTA
if (isset($_GET['accion']) && $_GET['accion'] == 'vaciar') {
    $_SESSION['carrito_venta'] = [];
    header("Location: ../views/ventas/registrar.php");
    exit();
}

// 4. FINALIZAR VENTA
if (isset($_POST['accion']) && $_POST['accion'] == 'finalizar') {
    if (empty($_SESSION['carrito_venta'])) { header("Location: ../views/ventas/registrar.php"); exit(); }

    $total = 0;
    foreach ($_SESSION['carrito_venta'] as $i) { $total += $i['subtotal']; }

    $res = $ventaModel->registrar($_SESSION['id_usuario'], $total, $_SESSION['carrito_venta']);

    if ($res) {
        $_SESSION['carrito_venta'] = [];
        header("Location: ../views/ventas/registrar.php?mensaje=exito&id_venta=".$res);
    } else {
        header("Location: ../views/ventas/registrar.php?error=db");
    }
    exit();
}

// 5. ANULAR VENTA (RESTAURAR STOCK)
if (isset($_GET['accion']) && $_GET['accion'] == 'anular') {
    // Validar que sea Admin (Opcional, pero recomendado)
    $id_venta = $_GET['id'];
    
    // Llamamos al modelo que ya tiene la lógica de devolver stock
    if ($ventaModel->anular($id_venta)) {
        header("Location: ../views/ventas/historial.php?mensaje=anulado");
    } else {
        header("Location: ../views/ventas/historial.php?error=fail");
    }
    exit();
}
?>