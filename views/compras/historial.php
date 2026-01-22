<?php
session_start();
include_once '../../models/Compra.php';
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$modelo = new Compra();
$compras = $modelo->listarHistorial();

// LOGICA DEL MODAL (SOBRE-PANTALLA)
$detalles_modal = null;
$mostrar_modal = false;
$compra_seleccionada = null;

if(isset($_GET['ver_detalle'])) {
    $id_ver = $_GET['ver_detalle'];
    $detalles_modal = $modelo->obtenerDetallesCompra($id_ver);
    $mostrar_modal = true;
    // Buscar datos cabecera simple
    foreach($compras as $c){ if($c['id_compra'] == $id_ver) $compra_seleccionada = $c; }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <style>
        /* REUTILIZAMOS ESTILOS (Mismos que registrar.php) */
        * { margin: 0; padding: 0; box-sizing: border_box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; height: 100vh; background-color: #f4f4f4; }
 
        .config-btn { background-color: #000099; text-align: center; padding: 15px; text-decoration: none; color: white; font-weight: bold; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        .top-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab { padding: 10px 20px; background: #ddd; border-radius: 20px; text-decoration: none; color: #666; font-weight: bold; }
        .tab.active { background: #ccc; color: black; border: 1px solid #999; }
        
        .white-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #ddd; min-height: 500px; }
        .card-title { font-size: 28px; font-weight: bold; margin-bottom: 20px; }

        /* ESTILOS DE TABLA DE HISTORIAL */
        .history-item { 
            display: flex; justify-content: space-between; align-items: center; 
            background: #f4f4f4; padding: 15px; margin-bottom: 10px; border-radius: 10px; border: 1px solid #ddd; 
        }
        .h-col { width: 20%; font-weight: bold; font-size: 14px; }
        .btn-detail { 
            background: white; border: 1px solid #000; padding: 5px 15px; 
            border-radius: 20px; text-decoration: none; color: black; font-size: 12px; font-weight: bold; 
        }
        .btn-anular { 
            color: red; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 10px; 
        }

        /* ESTILOS DEL MODAL (SOBRE-PANTALLA) */
        .overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); /* Fondo oscuro transparente */
            display: flex; justify-content: center; align-items: center;
            z-index: 1000;
        }
        .modal-box {
            background: white; width: 600px; padding: 30px; border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            text-align: center;
        }
        .modal-title { font-size: 22px; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .back-btn { 
            background: #000; color: white; padding: 10px 30px; border-radius: 5px; 
            text-decoration: none; font-weight: bold; display: inline-block; margin-top: 20px;
        }
    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main-content">
        <div class="top-tabs">
            <a href="registrar.php" class="tab">REGISTRO DE COMPRA</a>
            <a href="#" class="tab active">HISTORIAL DE COMPRAS</a>
        </div>

        <div class="white-card">
            <h1 class="card-title">Historial de Compras</h1>
            <p style="color:#666; margin-bottom:20px;">Registro de ingreso de mercadería</p>

            <div style="display:flex; padding:0 15px; margin-bottom:10px; font-size:12px; color:#666; font-weight:bold;">
                <div style="width:10%;">ID</div>
                <div style="width:25%;">Empresa</div>
                <div style="width:25%;">Fecha y Hora</div>
                <div style="width:20%;">Monto Total</div>
                <div style="width:20%; text-align:right;">Acciones</div>
            </div>

            <?php foreach($compras as $c): ?>
                <div class="history-item" style="<?php echo ($c['estado']==0)?'opacity:0.6; border:1px solid red;':''; ?>">
                    <div style="width:10%;"><?php echo $c['id_compra']; ?></div>
                    <div style="width:25%;">
                        <?php echo $c['empresa']; ?>
                        <?php if($c['estado']==0) echo " <span style='color:red'>(ANULADO)</span>"; ?>
                    </div>
                    <div style="width:25%;"><?php echo $c['fecha_compra']; ?></div>
                    <div style="width:20%; font-weight:bold;"><?php echo $c['total']; ?> Bs</div>
                    <div style="width:20%; text-align:right;">
                        <?php if($c['estado']==1): ?>
                            <a href="../../controllers/CompraController.php?accion=anular&id=<?php echo $c['id_compra']; ?>" 
                               onclick="return confirm('¿Seguro? Se descontará el stock.')" 
                               class="btn-anular">Anular</a>
                        <?php endif; ?>
                        
                        <a href="?ver_detalle=<?php echo $c['id_compra']; ?>" class="btn-detail">Ver detalle</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if($mostrar_modal): ?>
        <div class="overlay">
            <div class="modal-box">
                <h2 class="modal-title">
                    Detalle de Compra #<?php echo $compra_seleccionada['id_compra']; ?> <br>
                    <span style="font-size:14px; color:#666;"><?php echo $compra_seleccionada['empresa']; ?></span>
                </h2>

                <table style="width:100%; border-collapse:collapse; margin-bottom:20px; font-size:14px; text-align:left;">
                    <tr style="background:#eee;">
                        <th style="padding:10px;">Producto</th>
                        <th>Cant.</th>
                        <th>Costo</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach($detalles_modal as $d): ?>
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #ddd;"><?php echo $d['nombre']; ?></td>
                            <td style="border-bottom:1px solid #ddd;"><?php echo $d['cantidad']; ?></td>
                            <td style="border-bottom:1px solid #ddd;"><?php echo $d['precio_costo']; ?></td>
                            <td style="border-bottom:1px solid #ddd; font-weight:bold;"><?php echo $d['subtotal']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
                <h3 style="text-align:right;">Total: <?php echo $compra_seleccionada['total']; ?> Bs</h3>

                <a href="historial.php" class="back-btn">VOLVER ATRAS</a>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>