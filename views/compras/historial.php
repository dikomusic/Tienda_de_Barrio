<?php
session_start();
include_once '../../models/Compra.php';
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../index.php"); exit(); }

$modelo = new Compra();
$compras = $modelo->listarHistorial();
?>
<!DOCTYPE html>
<html>
<head><title>Historial de Compras</title></head>
<body>
    <a href="registrar.php">Volver a Registrar</a>
    <h1>Historial de Compras</h1>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'stock_insuficiente'): ?>
        <div style="color:red; border:2px solid red; padding:10px; font-weight:bold;">
            ⛔ ERROR CRITICO (Excepción 1): <br>
            No se puede anular esta compra porque los productos YA FUERON VENDIDOS.<br>
            No hay suficiente stock físico para devolverlo al proveedor.
        </div>
        <br>
    <?php endif; ?>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Registrado por</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($compras as $c): ?>
                <tr>
                    <td><?php echo $c['id_compra']; ?></td>
                    <td><?php echo $c['fecha_compra']; ?></td>
                    <td><?php echo $c['empresa']; ?></td>
                    <td><?php echo $c['usuario']; ?></td>
                    <td><?php echo $c['total']; ?></td>
                    <td>
                        <?php echo ($c['estado'] == 1) ? '<span style="color:green">VALIDA</span>' : '<span style="color:red">ANULADA</span>'; ?>
                    </td>
                    <td>
                        <?php if($c['estado'] == 1): ?>
                            <?php if($_SESSION['rol'] == 1): ?>
                                <a href="../../controllers/CompraController.php?accion=anular&id=<?php echo $c['id_compra']; ?>" 
                                   onclick="return confirm('¿Seguro? Esto RESTARÁ el stock.')">ANULAR</a>
                            <?php else: ?>
                                (Solo Admin)
                            <?php endif; ?>
                        <?php else: ?>
                            ---
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>