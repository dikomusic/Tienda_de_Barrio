<?php
session_start();
include_once '../../models/Producto.php';

// Seguridad: Solo Admin puede gestionar. 
// (El empleado tendrá su propia vista de ventas despues)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$modelo = new Producto();
$productos = $modelo->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
</head>
<body>

    <a href="../../index.php">Volver al Menu</a>
    <hr>
    
    <h1>Gestion de Inventario</h1>
    <a href="../categorias/index.php">[GESTIONAR CATEGORIAS]</a>
    <a href="../proveedores/index.php">[GESTIONAR PROVEEDORES]</a>
    <a href="formulario.php"> + NUEVO PRODUCTO</a>
    <br><br>

    <?php if(isset($_GET['mensaje'])): ?>
        <div style="color:green; border:1px solid green; padding:5px;">
            <?php 
                if($_GET['mensaje'] == 'creado') echo "Producto registrado correctamente.";
                if($_GET['mensaje'] == 'editado') echo "Producto actualizado correctamente.";
            ?>
        </div>
        <br>
    <?php endif; ?>

    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr style="background-color:#ddd;">
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Proveedor</th>
                <th>Costo</th>
                <th>P. Venta</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $prod): ?>
                
                <?php 
                    $color_stock = "black";
                    if($prod['stock_actual'] <= $prod['stock_minimo']) {
                        $color_stock = "red"; // Alerta visual
                    }
                ?>

                <tr>
                    <td align="center">
                        <?php if($prod['imagen']): ?>
                            <img src="../../<?php echo $prod['imagen']; ?>" width="50" height="50">
                        <?php else: ?>
                            Sin Foto
                        <?php endif; ?>
                    </td>
                    
                    <td><?php echo $prod['codigo']; ?></td>
                    <td><?php echo $prod['nombre']; ?></td>
                    <td><?php echo $prod['nombre_categoria']; ?></td>
                    <td><?php echo $prod['empresa']; ?></td>
                    <td><?php echo $prod['precio_compra']; ?></td>
                    <td><strong><?php echo $prod['precio_venta']; ?></strong></td>
                    
                    <td style="color: <?php echo $color_stock; ?>;">
                        <?php echo $prod['stock_actual']; ?>
                        <?php if($color_stock == "red") echo "(BAJO)"; ?>
                    </td>

                    <td>
                        <?php echo ($prod['estado'] == 1) ? 'DISPONIBLE' : 'NO DISPONIBLE'; ?>
                    </td>

                    <td align="center">
                        <a href="formulario.php?id=<?php echo $prod['id_producto']; ?>">Modificar</a>
                        |
                        <?php if($prod['estado'] == 1): ?>
                            <a href="../../controllers/ProductoController.php?accion=estado&id=<?php echo $prod['id_producto']; ?>&estado=0" 
                               onclick="return confirm('¿Ocultar este producto del catalogo?')">
                               Inhabilitar
                            </a>
                        <?php else: ?>
                            <a href="../../controllers/ProductoController.php?accion=estado&id=<?php echo $prod['id_producto']; ?>&estado=1">
                                Activar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html> 