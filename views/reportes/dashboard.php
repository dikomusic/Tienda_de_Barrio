<?php
session_start();
include_once '../../models/Reporte.php';

// Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 1) { 
    header("Location: ../../login.php"); exit(); 
}

$reporte = new Reporte();
$hoy = $reporte->ventasHoy();
$mes = $reporte->ventasMes();
$bajos = $reporte->stockBajo();
$chartData = $reporte->ventasUltimos7Dias();
$topProd = $reporte->productosMasVendidos();

// Preparamos datos para Javascript (Gráfico 1)
$fechas = [];
$totales = [];
foreach($chartData as $d) {
    $fechas[] = date('d/m', strtotime($d['fecha'])); // Formato dia/mes
    $totales[] = $d['total'];
}

// Preparamos datos para Javascript (Gráfico 2 - Top Productos)
$prodNombres = [];
$prodCant = [];
foreach($topProd as $p) {
    $prodNombres[] = $p['nombre'];
    $prodCant[] = $p['cantidad_total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes y Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* ESTILOS GENERALES (Tu paleta de colores) */
        * { box-sizing: border_box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { display: flex; background-color: #f4f4f4; height: 100vh; overflow: hidden; }
        
     
        .config-btn { background-color: #000099; text-align: center; padding: 15px; text-decoration: none; color: white; font-weight: bold; }

        .main { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        /* TARJETAS DE DATOS (KPIs) */
        .kpi-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .kpi-card { 
            flex: 1; background: white; padding: 25px; border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;
            border-bottom: 4px solid transparent;
        }
        /* Colores de borde inferior para diferenciar */
        .kpi-blue { border-bottom-color: #0000CC; }
        .kpi-green { border-bottom-color: #00aa00; }
        .kpi-red { border-bottom-color: #cc0000; }

        .kpi-info h3 { font-size: 32px; margin-bottom: 5px; color: #333; }
        .kpi-info p { color: #888; font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .kpi-icon { font-size: 40px; opacity: 0.2; }

        /* SECCION DE GRAFICOS */
        .charts-row { display: flex; gap: 20px; margin-bottom: 30px; height: 400px; }
        
        .chart-card { 
            background: white; border-radius: 15px; padding: 20px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); flex: 1;
            display: flex; flex-direction: column;
        }
        .chart-title { font-size: 16px; font-weight: bold; margin-bottom: 20px; color: #555; }
        
        /* LISTA TOP PRODUCTOS */
        .top-list { list-style: none; padding: 0; }
        .top-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .top-item:last-child { border-bottom: none; }
        .rank-badge { background: #0000CC; color: white; width: 25px; height: 25px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 12px; margin-right: 10px; }

    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main">
        <h1 style="margin-bottom:5px;">Dashboard General</h1>
        <button onclick="window.print()" class="btn btn-primary" style="background: #ef4444;">
    📄 Exportar PDF
</button>
        <p style="color:#666; margin-bottom:30px;">Resumen estadístico de tu negocio</p>

        <div class="kpi-container">
            <div class="kpi-card kpi-blue">
                <div class="kpi-info">
                    <h3><?php echo number_format($hoy, 2); ?> Bs</h3>
                    <p>Ventas de Hoy</p>
                </div>
                <div class="kpi-icon">📅</div>
            </div>

            <div class="kpi-card kpi-green">
                <div class="kpi-info">
                    <h3><?php echo number_format($mes, 2); ?> Bs</h3>
                    <p>Acumulado Mes</p>
                </div>
                <div class="kpi-icon">📈</div>
            </div>

            <div class="kpi-card kpi-red">
                <div class="kpi-info">
                    <h3 style="color:#cc0000;"><?php echo $bajos; ?></h3>
                    <p>Stock Bajo</p>
                </div>
                <div class="kpi-icon">⚠️</div>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card" style="flex: 2;"> <div class="chart-title">Comportamiento de Ventas (Últimos 7 días)</div>
                <div style="position: relative; height:100%; width:100%;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>

            <div class="chart-card" style="flex: 1;">
                <div class="chart-title">Top 5 Más Vendidos</div>
                <div style="position: relative; height:200px; display:flex; justify-content:center;">
                    <canvas id="topChart"></canvas>
                </div>
                <div style="margin-top:20px; flex-grow:1; overflow-y:auto;">
                    <ul class="top-list">
                        <?php 
                        $i = 1;
                        foreach($topProd as $p): ?>
                            <li class="top-item">
                                <span><span class="rank-badge"><?php echo $i++; ?></span> <?php echo $p['nombre']; ?></span>
                                <strong><?php echo $p['cantidad_total']; ?> und.</strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script>
        // --- GRAFICO 1: VENTAS SEMANALES (Barras) ---
        const ctx1 = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($fechas); ?>, // Fechas desde PHP
                datasets: [{
                    label: 'Ventas (Bs)',
                    data: <?php echo json_encode($totales); ?>, // Totales desde PHP
                    backgroundColor: '#0000CC',
                    borderRadius: 5,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- GRAFICO 2: TOP PRODUCTOS (Dona) ---
        const ctx2 = document.getElementById('topChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($prodNombres); ?>,
                datasets: [{
                    data: <?php echo json_encode($prodCant); ?>,
                    backgroundColor: [
                        '#0000CC', '#000099', '#3333ff', '#6666ff', '#9999ff' // Gama de azules
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '70%' // Hace la dona más fina
            }
        });
    </script>

</body>
</html>