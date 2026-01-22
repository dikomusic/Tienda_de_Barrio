<?php
session_start();
// Seguridad...
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$total_compra = 0;
// Recuperamos el nombre del proveedor actual si existe para mostrarlo como info (opcional)
$prov_actual = isset($_SESSION['prov_actual_nombre']) ? $_SESSION['prov_actual_nombre'] : '---';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Compra</title>
    <style>
        /* ESTILOS EXACTOS DEL PANEL DE CONTROL */
        * { margin: 0; padding: 0; box-sizing: border_box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; height: 100vh; background-color: #f4f4f4; }
 
       .config-btn { background-color: #000099; text-align: center; padding: 15px; text-decoration: none; color: white; font-weight: bold; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        .top-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab { padding: 10px 20px; background: #ddd; border-radius: 20px; text-decoration: none; color: #666; font-weight: bold; }
        .tab.active { background: #ccc; color: black; border: 1px solid #999; }
        .white-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #ddd; min-height: 500px; }
        
        /* ESTILOS ESPECIFICOS DEL FORMULARIO */
        .form-row { display: flex; gap: 20px; align-items: flex-end; margin-bottom: 30px; }
        .input-group { display: flex; flex-direction: column; }
        .input-group label { font-size: 12px; font-weight: bold; margin-bottom: 5px; }
        .input-gray { background: #f0f0f0; border: none; padding: 10px 15px; border-radius: 5px; width: 180px; }
        .btn-add { background: #888; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; cursor: pointer; }
        
        .cart-container { background: #f4f4f4; border-radius: 10px; padding: 20px; min-height: 200px; border: 1px dashed #ccc; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th { text-align: left; padding: 10px; border-bottom: 2px solid #000; font-size: 14px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; font-size: 14px; }
        
        .bottom-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { background: #ddd; color: black; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
        .btn-confirm { background: #ccc; color: black; border: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main-content">
        <div class="top-tabs">
            <a href="#" class="tab active">REGISTRO DE COMPRA</a>
            <a href="historial.php" class="tab">HISTORIAL DE COMPRAS</a>
        </div>

        <div class="white-card">
            <h1>Registrar Ingreso de Mercadería</h1>
            <p style="color:#666; margin-bottom:20px;">Agrega productos (el proveedor se detecta automáticamente)</p>

            <?php if(isset($_GET['error'])): ?>
                <div style="background:#ffcccc; color:#cc0000; padding:10px; border-radius:5px; margin-bottom:15px;">
                    <?php 
                        if($_GET['error'] == 'mix_proveedor') echo "⛔ ERROR: No puedes mezclar productos de <b>".$_GET['prov']."</b> en esta compra. Termina o cancela la actual primero.";
                        if($_GET['error'] == 'no_existe') echo "⚠ Error: Producto no encontrado.";
                        if($_GET['error'] == 'valores') echo "⚠ Error: Revisa cantidades y precios.";
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['mensaje'])): ?>
                <div style="background:#ccffcc; color:green; padding:10px; border-radius:5px; margin-bottom:15px;">✅ Compra registrada con éxito.</div>
            <?php endif; ?>

            <form action="../../controllers/CompraController.php" method="POST" autocomplete="off">
                <input type="hidden" name="accion" value="agregar">

                <div class="form-row">
                    <div class="input-group">
                        <label>Código Producto</label>
                        <input type="text" name="codigo" class="input-gray" required autofocus placeholder="Ej: PROD-1">
                    </div>

                    <div class="input-group">
                        <label>Proveedor Actual</label>
                        <input type="text" class="input-gray" value="<?php echo $prov_actual; ?>" readonly style="background:#e0e0e0; color:#555; cursor:not-allowed;">
                    </div>

                    <div class="input-group">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" class="input-gray" required min="1">
                    </div>

                    <div class="input-group">
                        <label>Costo Unit.</label>
                        <input type="number" name="costo" class="input-gray" required step="0.50">
                    </div>

                    <button type="submit" class="btn-add">AGREGAR A LA LISTA</button>
                </div>
            </form>

            <div class="cart-container">
                <?php if(isset($_SESSION['carrito_compra']) && !empty($_SESSION['carrito_compra'])): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Empresa</th> <th>Cant.</th>
                                <th>Costo</th>
                                <th>Sub-Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($_SESSION['carrito_compra'] as $index => $item): ?>
                                <tr>
                                    <td><?php echo $item['codigo']; ?></td>
                                    <td><?php echo $item['nombre']; ?></td>
                                    <td><?php echo $item['empresa']; ?></td> <td><?php echo $item['cantidad']; ?></td>
                                    <td><?php echo $item['costo']; ?></td>
                                    <td><?php echo $item['subtotal']; ?></td>
                                    <td align="center">
                                        <a href="../../controllers/CompraController.php?accion=eliminar&index=<?php echo $index; ?>" 
                                           style="text-decoration:none; color:red; font-size:18px;"
                                           onclick="return confirm('¿Quitar?')">🗑</a>
                                    </td>
                                </tr>
                                <?php $total_compra += $item['subtotal']; ?>
                            <?php endforeach; ?>
                            <tr style="background:#eee; font-weight:bold;">
                                <td colspan="5" align="right">TOTAL COMPRA:</td>
                                <td><?php echo number_format($total_compra, 2); ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="bottom-actions">
                        <a href="../../controllers/CompraController.php?accion=vaciar" class="btn-cancel">✖ CANCELAR</a>
                        <form action="../../controllers/CompraController.php" method="POST">
                            <input type="hidden" name="accion" value="finalizar">
                            <button type="submit" class="btn-confirm" onclick="return confirm('¿Confirmar ingreso de mercadería?')">CONFIRMAR COMPRA</button>
                        </form>
                    </div>

                <?php else: ?>
                    <p style="text-align:center; color:#999; margin-top:50px;">📦 La lista está vacía.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    
    <div style="position:fixed; bottom:0; left:250px; right:0; text-align:center; background:#666; color:white; font-size:12px; padding:8px;">
        © 2026 Consigue ventas - Todos los derechos reservados
    </div>

</body>
</html>