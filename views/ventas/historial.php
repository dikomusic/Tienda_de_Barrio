<?php
session_start();
include_once '../../models/Venta.php';
// Seguridad...
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../index.php"); exit(); }

$modelo = new Venta();
$ventas = $modelo->listarHistorial();
?>
<!DOCTYPE html>
<html>
<head><title>Historial de Ventas</title></head>
<body>
    <a href="registrar.php">Volver al POS</a>
    <h1>Historial de Ventas</h1>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ventas as $v): ?>
                <tr>
                    <td><?php echo $v['id_venta']; ?></td>
                    <td><?php echo $v['fecha_venta']; ?></td>
                    <td><?php echo $v['vendedor']; ?></td>
                    <td><?php echo $v['total']; ?> Bs</td>
                    <td>
                        <?php if($v['estado'] == 1): ?>
                            <span style="color:green;">COMPLETADA</span>
                        <?php else: ?>
                            <span style="color:red;">ANULADA</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($v['estado'] == 1): ?>
                            <a href="../../controllers/VentaController.php?accion=anular&id=<?php echo $v['id_venta']; ?>" 
                               onclick="return confirm('¿Está seguro de ANULAR esta venta? Se devolverá el stock.')">
                               ANULAR
                            </a>
                        <?php else: ?>
                            ---
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html