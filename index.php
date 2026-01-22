<?php
session_start();
include_once 'config/conexion.php'; // Conexión directa
include_once 'models/Reporte.php';  // Modelo existente

if (!isset($_SESSION['id_usuario'])) { header("Location: login.php"); exit(); }

// 1. OBTENER DATOS (Usando lo que ya tienes + Consultas directas seguras)
$reporte = new Reporte();
$db = new Conexion();
$conn = $db->getConexion();

// A) Datos del Modelo Reporte (Ya existían)
$ventasHoy = $reporte->ventasHoy();
$stockBajoCount = $reporte->stockBajo(); // Cantidad numérica

// B) Consultas Directas (Para no modificar Reporte.php)
// Total de Productos Activos
$sqlTotal = "SELECT COUNT(*) as total FROM productos WHERE estado = 1";
$stmt = $conn->prepare($sqlTotal); $stmt->execute();
$totalProductos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Valor Total del Inventario (Precio Compra * Stock)
$sqlValor = "SELECT SUM(precio_compra * stock_actual) as valor FROM productos WHERE estado = 1";
$stmt = $conn->prepare($sqlValor); $stmt->execute();
$valorInventario = $stmt->fetch(PDO::FETCH_ASSOC)['valor'];
$valorInventario = $valorInventario ? $valorInventario : 0; // Evitar nulos

// C) Lista de Productos con Stock Bajo (Para la tabla de abajo)
$sqlListaBaja = "SELECT nombre, codigo, stock_actual FROM productos WHERE stock_actual <= 5 AND estado = 1 LIMIT 4";
$stmt = $conn->prepare($sqlListaBaja); $stmt->execute();
$listaBajos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
</head>
<body>

    <?php include 'views/sidebar.php'; ?>

    <div class="main">
        
        <div class="page-header">
            <div>
                <h1 class="page-title">Panel de Control</h1>
                <p style="color: #666;">Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong></p>
            </div>
            <div style="text-align: right; font-size: 12px; color: #888;">
                Fecha: <strong><?php echo date('d/m/Y'); ?></strong>
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card card-orange">
                <div class="kpi-icon-circle bg-orange">📦</div>
                <div class="kpi-content">
                    <span class="kpi-label">Total Productos</span>
                    <h3 class="kpi-value"><?php echo $totalProductos; ?></h3>
                </div>
            </div>

            <div class="kpi-card card-blue">
                <div class="kpi-icon-circle bg-blue">📝</div>
                <div class="kpi-content">
                    <span class="kpi-label">Valor Inventario</span>
                    <h3 class="kpi-value">Bs <?php echo number_format($valorInventario, 0); ?></h3>
                </div>
            </div>

            <div class="kpi-card card-green">
                <div class="kpi-icon-circle bg-green">💵</div>
                <div class="kpi-content">
                    <span class="kpi-label">Ventas Hoy</span>
                    <h3 class="kpi-value">Bs <?php echo number_format($ventasHoy, 2); ?></h3>
                </div>
            </div>

            <div class="kpi-card card-red">
                <div class="kpi-icon-circle bg-red">⚠️</div>
                <div class="kpi-content">
                    <span class="kpi-label">Stock Crítico</span>
                    <h3 class="kpi-value"><?php echo $stockBajoCount; ?></h3>
                </div>
            </div>
        </div>

        <div class="dashboard-lower">
            
            <div class="content-panel">
                <h3 class="panel-title">Stock Bajo</h3>
                <span class="panel-subtitle">Productos con menos de 5 unidades</span>
                
                <?php if(count($listaBajos) > 0): ?>
                    <?php foreach($listaBajos as $prod): ?>
                    <div class="stock-item">
                        <div class="stock-info">
                            <h4><?php echo $prod['nombre']; ?></h4>
                            <small>Código: <?php echo $prod['codigo']; ?></small>
                        </div>
                        <span class="stock-badge"><?php echo $prod['stock_actual']; ?> und.</span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; color:#999; margin-top:20px;">✅ Todo está bien surtido</p>
                <?php endif; ?>
            </div>

            <div class="actions-panel">
                <h3 class="panel-title" style="text-align:center; margin-bottom:20px;">Accesos Rápidos</h3>
                
                <div class="actions-grid">
                    <a href="views/productos/index.php" class="action-card">
                        <span class="action-icon">📦</span>
                        <span class="action-title">Agregar Producto</span>
                    </a>
                    
                    <a href="views/ventas/registrar.php" class="action-card">
                        <span class="action-icon">🛒</span>
                        <span class="action-title">Nueva Venta</span>
                    </a>
                    
                    <a href="views/compras/registrar.php" class="action-card">
                        <span class="action-icon">🚚</span>
                        <span class="action-title">Registrar Compra</span>
                    </a>

                    <?php if($_SESSION['rol'] == 1): ?>
                    <a href="views/reportes/dashboard.php" class="action-card">
                        <span class="action-icon">📊</span>
                        <span class="action-title">Ver Reportes</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</body>
</html>