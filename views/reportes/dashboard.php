<?php
session_start();
include_once '../../models/Reporte.php';

// Seguridad: Solo Admin (RF Precondición)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$modelo = new Reporte();

// Lógica de Fechas (Por defecto: Mes actual)
$fecha_inicio = isset($_GET['inicio']) ? $_GET['inicio'] : date('Y-m-01');
$fecha_fin = isset($_GET['fin']) ? $_GET['fin'] : date('Y-m-d');

// Consultas a BD
$datos_ventas = $modelo->obtenerTotalVentas($fecha_inicio, $fecha_fin);
$top_productos = $modelo->obtenerMasVendidos($fecha_inicio, $fecha_fin);
$bajo_stock = $modelo->obtenerBajoStock();
$todo_stock = $modelo->obtenerStockCompleto();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes y Estadisticas</title>
</head>
<body>
    <a href="../../index.php">Volver al Menu</a>
    <hr>

    <h1>Panel de Control (Dashboard)</h1>

    <fieldset>
        <legend>Rango de Reporte</legend>
        <form action="" method="GET">
            <label>Desde:</label>
            <input type="date" name="inicio" value="<?php echo $fecha_inicio; ?>" required>
            
            <label>Hasta:</label>
            <input type="date" name="fin" value="<?php echo $fecha_fin; ?>" required>
            
            <button type="submit">GENERAR REPORTE</button>
        </form>
    </fieldset>

    <br>

    <button onclick="window.print();">IMPRIMIR / EXPORTAR PDF</button>

    <hr>

    <h2>1. Reporte Financiero</h2>
    
    <table border="1" width="50%">
        <tr>
            <td bgcolor="#ddd"><strong>Total Vendido (Dinero):</strong></td>
            <td><h2><?php echo number_format($datos_ventas['total_ganado'], 2); ?> Bs</h2></td>
        </tr>
        <tr>
            <td bgcolor="#ddd"><strong>Transacciones Realizadas:</strong></td>
            <td><?php echo $datos_ventas['cantidad_ventas']; ?> Ventas</td>
        </tr>
    </table>

    <h3>Productos Mas Vendidos (Top 5)</h3>
    <?php if(!empty($top_productos)): ?>
        <table border="1" width="50%">
            <thead>
                <tr bgcolor="#eee">
                    <th>Producto</th>
                    <th>Unidades Vendidas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($top_productos as $top): ?>
                    <tr>
                        <td><?php echo $top['nombre']; ?></td>
                        <td><?php echo $top['total_unidades']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay ventas registradas en este periodo (Excepcion 1).</p>
    <?php endif; ?>

    <hr>

    <h2>2. Reporte de Almacen</h2>

    <h3>⚠️ Alerta: Productos Bajo Stock (RF-38)</h3>
    <?php if(!empty($bajo_stock)): ?>
        <table border="1" width="100%" style="border: 2px solid red;">
            <thead>
                <tr bgcolor="#ffcccc"> <th>Codigo</th>
                    <th>Producto</th>
                    <th>Stock Minimo</th>
                    <th>Stock Actual</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bajo_stock as $prod): ?>
                    <tr>
                        <td><?php echo $prod['codigo']; ?></td>
                        <td><?php echo $prod['nombre']; ?></td>
                        <td><?php echo $prod['stock_minimo']; ?></td>
                        <td style="color:red; font-weight:bold;"><?php echo $prod['stock_actual']; ?></td>
                        <td>
                            <a href="../compras/registrar.php">Reponer Stock</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color:green;"><strong>Inventario Saludable (Excepcion 2): No hay productos urgentes.</strong></p>
    <?php endif; ?>

    <br>

    <h3>Estado General del Inventario (RF-37)</h3>
    <table border="1" width="100%">
        <thead>
            <tr bgcolor="#ddd">
                <th>Producto</th>
                <th>Categoria</th>
                <th>Proveedor</th>
                <th>Costo</th>
                <th>P. Venta</th>
                <th>Stock</th>
                <th>Valoracion (Stock x Costo)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $valor_total_almacen = 0;
                foreach($todo_stock as $p): 
                    $valor_item = $p['stock_actual'] * $p['precio_compra'];
                    $valor_total_almacen += $valor_item;
            ?>
                <tr>
                    <td><?php echo $p['nombre']; ?></td>
                    <td><?php echo $p['nombre_categoria']; ?></td>
                    <td><?php echo $p['empresa']; ?></td>
                    <td><?php echo $p['precio_compra']; ?></td>
                    <td><?php echo $p['precio_venta']; ?></td>
                    <td><?php echo $p['stock_actual']; ?></td>
                    <td><?php echo number_format($valor_item, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" align="right"><strong>VALOR TOTAL DE MERCADERIA:</strong></td>
                <td><strong><?php echo number_format($valor_total_almacen, 2); ?> Bs</strong></td>
            </tr>
        </tfoot>
    </table>

    <br><br><br>

</body>
</html>