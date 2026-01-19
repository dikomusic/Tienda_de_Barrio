<?php
session_start();
include_once '../../models/Proveedor.php';
// Seguridad
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../index.php"); exit(); }

$modeloProv = new Proveedor();
$proveedores = $modeloProv->listar(); // Para llenar el select (RF-22)

$total_compra = 0;
?>
<!DOCTYPE html>
<html>
<head><title>Registrar Compra (Ingreso)</title></head>
<body>
    <a href="../../index.php">Volver al Menu</a> | 
    <a href="historial.php">VER HISTORIAL DE COMPRAS</a>
    <hr>
    <h1>Registrar Ingreso de Mercaderia</h1>

    <?php if(isset($_GET['error'])): ?>
        <div style="color:red; border:1px solid red; padding:5px;">
            <?php 
                if($_GET['error'] == 'valores') echo "ERROR: Cantidad y Costo deben ser mayores a 0 (Excepción 3).";
                if($_GET['error'] == 'no_existe') echo "ERROR: Producto no encontrado.";
                if($_GET['error'] == 'inactivo') echo "ERROR: El producto está inhabilitado (Excepción 5).";
                if($_GET['error'] == 'vacio') echo "ERROR: La lista está vacía (Excepción 4).";
                if($_GET['error'] == 'bd') echo "ERROR CRÍTICO DE BASE DE DATOS. Verifica que las tablas existan.";
            ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['mensaje']) && $_GET['mensaje']=='exito') echo "<h3 style='color:green'>¡COMPRA REGISTRADA Y STOCK ACTUALIZADO!</h3>"; ?>

    <fieldset>
        <legend>Agregar Item</legend>
        <form action="../../controllers/CompraController.php" method="POST" autocomplete="off">
            <input type="hidden" name="accion" value="agregar">
            
            <label>Codigo Producto:</label>
            <input type="text" name="codigo" required autofocus placeholder="Ej: PROD-1">
            
            <label>Cantidad (Unidades):</label>
            <input type="number" name="cantidad" required min="1">
            
            <label>Costo Unitario (Compra):</label>
            <input type="number" name="costo" required min="0.1" step="0.01">
            
            <button type="submit">AGREGAR A LA LISTA</button>
        </form>
    </fieldset>

    <br>

    <table border="1" width="100%">
        <thead>
            <tr style="background-color:#eee;">
                <th>Codigo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($_SESSION['carrito_compra']) && !empty($_SESSION['carrito_compra'])): ?>
                <?php foreach($_SESSION['carrito_compra'] as $item): ?>
                    <tr>
                        <td><?php echo $item['codigo']; ?></td>
                        <td><?php echo $item['nombre']; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td><?php echo $item['costo']; ?></td>
                        <td><?php echo $item['subtotal']; ?></td>
                    </tr>
                    <?php $total_compra += $item['subtotal']; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" align="center">Lista vacía</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right"><strong>TOTAL COMPRA:</strong></td>
                <td><strong><?php echo number_format($total_compra, 2); ?> Bs</strong></td>
            </tr>
        </tfoot>
    </table>

    <br>

    <?php if($total_compra > 0): ?>
        <fieldset>
            <legend>Finalizar Ingreso</legend>
            <form action="../../controllers/CompraController.php" method="POST">
                <input type="hidden" name="accion" value="finalizar">
                
                <label>Seleccionar Proveedor (RF-22):</label>
                <select name="id_proveedor" required>
                    <?php foreach($proveedores as $prov): ?>
                        <option value="<?php echo $prov['id_proveedor']; ?>"><?php echo $prov['empresa']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <br><br>
                <button type="submit" onclick="return confirm('¿Confirmar ingreso de stock?')">CONFIRMAR COMPRA</button>
            </form>
            <br>
            <a href="../../controllers/CompraController.php?accion=vaciar">[Cancelar todo]</a>
        </fieldset>
    <?php endif; ?>

</body>
</html>