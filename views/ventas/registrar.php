<?php
session_start();
// Verificar sesión...
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../index.php"); exit(); }

$total_venta = 0;
?>
<!DOCTYPE html>
<html>
<head><title>Punto de Venta</title></head>
<body>
    <a href="../../index.php">Volver al Menú</a> | 
    <a href="historial.php">VER HISTORIAL DE VENTAS</a>
    <hr>

    <h1>Registrar Venta</h1>

    <fieldset>
        <legend>Agregar Producto</legend>
        <?php if(isset($_GET['error'])): ?>
            <div style="color:red; font-weight:bold;">
                <?php 
                    if($_GET['error'] == 'stock') echo "ERROR: Stock insuficiente.";
                    if($_GET['error'] == 'no_existe') echo "ERROR: Producto no encontrado.";
                    if($_GET['error'] == 'vacio') echo "ERROR: Debe agregar al menos un producto.";
                ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'exito'): ?>
            <div style="color:green; font-weight:bold;">¡VENTA REGISTRADA CON ÉXITO!</div>
        <?php endif; ?>

        <form action="../../controllers/VentaController.php" method="POST" autocomplete="off">
            <input type="hidden" name="accion" value="agregar">
            
            <label>Código del Producto:</label>
            <input type="text" name="codigo" required autofocus placeholder="Escanee o escriba código">
            
            <label>Cantidad:</label>
            <input type="number" name="cantidad" value="1" min="1" required>
            
            <button type="submit">AGREGAR AL CARRITO</button>
        </form>
    </fieldset>

    <br>

    <table border="1" width="100%">
        <thead>
            <tr style="background-color:#ddd;">
                <th>Código</th>
                <th>Producto</th>
                <th>Precio Unit.</th>
                <th>Cant.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
                <?php foreach($_SESSION['carrito'] as $item): ?>
                    <tr>
                        <td><?php echo $item['codigo']; ?></td>
                        <td><?php echo $item['nombre']; ?></td>
                        <td><?php echo $item['precio_venta']; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td><?php echo $item['subtotal']; ?></td>
                    </tr>
                    <?php $total_venta += $item['subtotal']; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" align="center">Carrito vacío</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right"><strong>TOTAL A PAGAR:</strong></td>
                <td><strong><?php echo number_format($total_venta, 2); ?> Bs</strong></td>
            </tr>
        </tfoot>
    </table>

    <br>

    <?php if($total_venta > 0): ?>
        <form action="../../controllers/VentaController.php" method="POST" style="display:inline;">
            <input type="hidden" name="accion" value="finalizar">
            <button type="submit" onclick="return confirm('¿Confirmar venta por <?php echo $total_venta; ?> Bs?')">
                COBRAR Y FINALIZAR
            </button>
        </form>

        <a href="../../controllers/VentaController.php?accion=vaciar" onclick="return confirm('¿Borrar todo?')">
            [CANCELAR / VACIAR CARRITO]
        </a>
    <?php endif; ?>

</body>
</html>