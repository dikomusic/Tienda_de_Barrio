<?php
session_start();
include_once '../models/Compra.php';
include_once '../config/conexion.php';

$modeloCompra = new Compra();
$db = new Conexion();
$conn = $db->getConexion();

if (!isset($_SESSION['carrito_compra'])) {
    $_SESSION['carrito_compra'] = [];
}

// ACCIÓN 1: AGREGAR ITEM (CON FUSIÓN DE DUPLICADOS)
if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];

    // Validar positivos
    if ($cantidad <= 0 || $costo <= 0) {
        header("Location: ../views/compras/registrar.php?error=valores");
        exit();
    }

    // BUSCAR PRODUCTO Y SU PROVEEDOR
    $sql = "SELECT p.*, pr.id_proveedor, pr.empresa 
            FROM productos p 
            INNER JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor 
            WHERE p.codigo = :cod";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':cod' => $codigo]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // VALIDAR ESTADO
        if($producto['estado'] == 0) {
            header("Location: ../views/compras/registrar.php?error=inactivo");
            exit();
        }

        // --- VALIDACIÓN DE PROVEEDOR ---
        if (empty($_SESSION['carrito_compra'])) {
            $_SESSION['prov_actual_id'] = $producto['id_proveedor'];
            $_SESSION['prov_actual_nombre'] = $producto['empresa'];
        } else {
            if ($producto['id_proveedor'] != $_SESSION['prov_actual_id']) {
                header("Location: ../views/compras/registrar.php?error=mix_proveedor&prov=" . $producto['empresa']);
                exit();
            }
        }

        // --- NUEVA LÓGICA: BUSCAR SI YA EXISTE PARA INCREMENTAR ---
        $encontrado = false;
        
        foreach ($_SESSION['carrito_compra'] as $key => $item_existente) {
            if ($item_existente['id_producto'] == $producto['id_producto']) {
                // ¡YA EXISTE! Solo actualizamos la cantidad y el subtotal
                $_SESSION['carrito_compra'][$key]['cantidad'] += $cantidad;
                
                // Opcional: Actualizamos el costo al último ingresado (por si cambió)
                $_SESSION['carrito_compra'][$key]['costo'] = $costo; 
                
                // Recalculamos el subtotal de esa fila
                $_SESSION['carrito_compra'][$key]['subtotal'] = $_SESSION['carrito_compra'][$key]['cantidad'] * $costo;
                
                $encontrado = true;
                break; // Dejamos de buscar
            }
        }

        // Si NO se encontró (es un producto nuevo en la lista), lo agregamos normal
        if (!$encontrado) {
            $subtotal = $cantidad * $costo;
            $item = [
                'id_producto' => $producto['id_producto'],
                'codigo' => $producto['codigo'],
                'nombre' => $producto['nombre'],
                'empresa' => $producto['empresa'],
                'cantidad' => $cantidad,
                'costo' => $costo,
                'subtotal' => $subtotal
            ];
            array_push($_SESSION['carrito_compra'], $item);
        }
        
        header("Location: ../views/compras/registrar.php");
        
    } else {
        header("Location: ../views/compras/registrar.php?error=no_existe");
    }
}

// ACCIÓN 2: ELIMINAR UN ITEM
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $index = $_GET['index'];
    if(isset($_SESSION['carrito_compra'][$index])) {
        array_splice($_SESSION['carrito_compra'], $index, 1);
    }
    
    if(empty($_SESSION['carrito_compra'])) {
        unset($_SESSION['prov_actual_id']);
        unset($_SESSION['prov_actual_nombre']);
    }
    header("Location: ../views/compras/registrar.php");
}

// ACCIÓN 3: VACIAR TODO
if (isset($_GET['accion']) && $_GET['accion'] == 'vaciar') {
    $_SESSION['carrito_compra'] = [];
    unset($_SESSION['prov_actual_id']);
    unset($_SESSION['prov_actual_nombre']);
    header("Location: ../views/compras/registrar.php");
}

// ACCIÓN 4: CONFIRMAR COMPRA
if (isset($_POST['accion']) && $_POST['accion'] == 'finalizar') {
    if (empty($_SESSION['carrito_compra'])) {
        header("Location: ../views/compras/registrar.php?error=vacio");
        exit();
    }

    $total = 0;
    foreach ($_SESSION['carrito_compra'] as $p) { $total += $p['subtotal']; }

    $id_proveedor = $_SESSION['prov_actual_id']; 
    $id_usuario = $_SESSION['id_usuario'];

    if ($modeloCompra->registrarCompra($id_proveedor, $id_usuario, $total, $_SESSION['carrito_compra'])) {
        $_SESSION['carrito_compra'] = [];
        unset($_SESSION['prov_actual_id']);
        unset($_SESSION['prov_actual_nombre']);
        header("Location: ../views/compras/registrar.php?mensaje=exito");
    } else {
        header("Location: ../views/compras/registrar.php?error=bd");
    }
}

// ACCIÓN 5: ANULAR (Solo Admin)
if (isset($_GET['accion']) && $_GET['accion'] == 'anular') {
    $resultado = $modeloCompra->anularCompra($_GET['id']);
    if ($resultado == "OK") header("Location: ../views/compras/historial.php?mensaje=anulado");
    elseif ($resultado == "STOCK_ERROR") header("Location: ../views/compras/historial.php?error=stock_insuficiente");
    else header("Location: ../views/compras/historial.php?error=bd");
}
?>