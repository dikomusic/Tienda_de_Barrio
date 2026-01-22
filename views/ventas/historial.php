<?php
session_start();
include_once '../../models/Venta.php';

if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$modelo = new Venta();
$ventas = $modelo->listarHistorial();

// LOGICA DEL MODAL DETALLE
$detalles_modal = null;
$mostrar_modal = false;
$venta_seleccionada = null;

if(isset($_GET['ver_detalle'])) {
    $id_ver = $_GET['ver_detalle'];
    $detalles_modal = $modelo->obtenerDetalles($id_ver);
    $mostrar_modal = true;
    foreach($ventas as $v){ if($v['id_venta'] == $id_ver) $venta_seleccionada = $v; }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <style>
        /* ESTILOS (Mismos que Compras) */
        * { margin: 0; padding: 0; box-sizing: border_box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; height: 100vh; background-color: #f4f4f4; }
        
      
        .config-btn { background-color: #000099; text-align: center; padding: 15px; text-decoration: none; color: white; font-weight: bold; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        .top-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab { padding: 10px 20px; background: #ddd; border-radius: 20px; text-decoration: none; color: #666; font-weight: bold; }
        .tab.active { background: #ccc; color: black; border: 1px solid #999; }
        
        .white-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #ddd; min-height: 500px; }
        .card-title { font-size: 28px; font-weight: bold; margin-bottom: 20px; }

        /* ALERTAS */
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .alert-green { background: #ccffcc; color: green; }
        .alert-red { background: #ffcccc; color: red; }

        /* TABLA HISTORIAL */
        .history-item { 
            display: flex; justify-content: space-between; align-items: center; 
            background: #f4f4f4; padding: 15px; margin-bottom: 10px; border-radius: 10px; border: 1px solid #ddd; 
        }
        
        /* BOTONES DE ACCION */
        .btn-detail { background: white; border: 1px solid #000; padding: 5px 15px; border-radius: 20px; text-decoration: none; color: black; font-size: 12px; font-weight: bold; }
        .btn-anular { color: red; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 15px; border: 1px solid red; padding: 4px 10px; border-radius: 20px; }
        .btn-anular:hover { background: red; color: white; }

        /* MODAL */
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: white; width: 600px; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); text-align: center; }
        .back-btn { background: #000; color: white; padding: 10px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main-content">
        <div class="top-tabs">
            <a href="registrar.php" class="tab">PUNTO DE VENTA</a>
            <a href="#" class="tab active">HISTORIAL DE VENTAS</a>
        </div>

        <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'anulado'): ?>
            <div class="alert alert-green">✅ Venta anulada correctamente. El stock ha sido restaurado.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-red">⛔ No tienes permisos para anular ventas.</div>
        <?php endif; ?>

        <div class="white-card">
            <h1 class="card-title">Historial de Ventas</h1>
            <p style="color:#666; margin-bottom:20px;">Registro de transacciones realizadas</p>

            <div style="display:flex; padding:0 15px; margin-bottom:10px; font-size:12px; color:#666; font-weight:bold;">
                <div style="width:10%;">ID</div>
                <div style="width:25%;">Vendedor</div>
                <div style="width:25%;">Fecha</div>
                <div style="width:15%;">Total</div>
                <div style="width:25%; text-align:right;">Acciones</div>
            </div>

            <?php foreach($ventas as $v): ?>
                <div class="history-item" style="<?php echo ($v['estado']==0)?'opacity:0.7; background:#fff0f0; border:1px solid #ffcccc;':''; ?>">
                    
                    <div style="width:10%;">#<?php echo $v['id_venta']; ?></div>
                    
                    <div style="width:25%;">
                        <?php echo $v['vendedor']; ?>
                        <?php if($v['estado']==0) echo " <br><span style='color:red; font-size:10px; font-weight:bold;'>[ANULADA]</span>"; ?>
                    </div>
                    
                    <div style="width:25%;"><?php echo $v['fecha_venta']; ?></div>
                    
                    <div style="width:15%; font-weight:bold;"><?php echo number_format($v['total'], 2); ?> Bs</div>
                    
                    <div style="width:25%; text-align:right;">
                        
                        <?php if($v['estado'] == 1 && $_SESSION['rol'] == 1): ?>
                            <a href="../../controllers/VentaController.php?accion=anular&id=<?php echo $v['id_venta']; ?>" 
                               onclick="return confirm('¿Seguro que deseas ANULAR esta venta? \n\nLos productos volverán al stock automáticamente.')"
                               class="btn-anular">
                               Anular
                            </a>
                        <?php endif; ?>

                        <a href="?ver_detalle=<?php echo $v['id_venta']; ?>" class="btn-detail">Ver detalle</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if($mostrar_modal): ?>
        <div class="overlay">
            <div class="modal-box">
                <h2 style="margin-bottom:10px;">Detalle Venta #<?php echo $venta_seleccionada['id_venta']; ?></h2>
                <p style="margin-bottom:20px; color:#666;">
                    Atendido por: <strong><?php echo $venta_seleccionada['vendedor']; ?></strong>
                </p>

                <table style="width:100%; border-collapse:collapse; margin-bottom:20px; font-size:14px; text-align:left;">
                    <tr style="background:#eee;">
                        <th style="padding:10px;">Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach($detalles_modal as $d): ?>
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #ddd;">
                                <?php echo $d['nombre']; ?><br>
                                <span style="font-size:10px; color:#999;"><?php echo $d['codigo']; ?></span>
                            </td>
                            <td style="border-bottom:1px solid #ddd;"><?php echo $d['cantidad']; ?></td>
                            <td style="border-bottom:1px solid #ddd;"><?php echo $d['precio_unitario']; ?></td>
                            <td style="border-bottom:1px solid #ddd; font-weight:bold;"><?php echo $d['subtotal']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
                <h3 style="text-align:right; border-top:2px solid #000; padding-top:10px;">
                    Total: <?php echo number_format($venta_seleccionada['total'], 2); ?> Bs
                </h3>

                <a href="historial.php" class="back-btn">CERRAR VENTANA</a>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>