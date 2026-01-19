<?php
session_start();
include_once '../../models/Producto.php';

// Seguridad: Solo Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$modelo = new Producto();
$categorias = $modelo->listarCategorias();
$proveedores = $modelo->listarProveedores();

$p = null; // Producto vacio
$titulo = "Registrar Nuevo Producto";
$accion = "guardar";

// Si viene ID, es Edicion
if (isset($_GET['id'])) {
    $p = $modelo->obtenerPorId($_GET['id']);
    $titulo = "Modificar Producto";
    $accion = "editar";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
</head>
<body>

    <h1><?php echo $titulo; ?></h1>

    <?php if(isset($_GET['error'])): ?>
        <div style="color:red; border:1px solid red; padding:10px;">
            <strong>ERROR:</strong>
            <?php 
                if($_GET['error'] == 'codigo_duplicado') echo "El CODIGO ingresado ya existe en otro producto.";
                if($_GET['error'] == 'negativo') echo "El precio o stock no pueden ser negativos.";
                if($_GET['error'] == 'formato_imagen') echo "Formato de imagen no valido (Solo JPG/PNG).";
                if($_GET['error'] == 'bd') echo "Error de Base de Datos.";
            ?>
        </div>
        <br>
    <?php endif; ?>

    <form action="../../controllers/ProductoController.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="accion" value="<?php echo $accion; ?>">
        <?php if($p): ?>
            <input type="hidden" name="id_producto" value="<?php echo $p['id_producto']; ?>">
            <input type="hidden" name="imagen_actual" value="<?php echo $p['imagen']; ?>">
        <?php endif; ?>

        <fieldset>
            <legend>Datos Principales</legend>

            <label>Codigo de Barras / Manual:</label><br>
            <input type="text" name="codigo" required 
                   value="<?php echo $p ? $p['codigo'] : ''; ?>" 
                   <?php echo $p ? 'readonly' : ''; ?>> 
            <?php if($p) echo "(No se puede modificar)"; ?>
            <br><br>

            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre" required value="<?php echo $p ? $p['nombre'] : ''; ?>"><br><br>

            <label>Descripcion:</label><br>
            <textarea name="descripcion" rows="3"><?php echo $p ? $p['descripcion'] : ''; ?></textarea><br><br>

            <label>Categoria:</label><br>
            <select name="id_categoria" required>
                <option value="">-- Seleccione --</option>
                <?php foreach($categorias as $cat): ?>
                    <option value="<?php echo $cat['id_categoria']; ?>" 
                        <?php echo ($p && $p['id_categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                        <?php echo $cat['nombre_categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Proveedor:</label><br>
            <select name="id_proveedor" required>
                <option value="">-- Seleccione --</option>
                <?php foreach($proveedores as $prov): ?>
                    <option value="<?php echo $prov['id_proveedor']; ?>" 
                        <?php echo ($p && $p['id_proveedor'] == $prov['id_proveedor']) ? 'selected' : ''; ?>>
                        <?php echo $prov['empresa']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <br>

        <fieldset>
            <legend>Precios y Stock</legend>

            <label>Precio Compra (Costo):</label><br>
            <input type="number" step="0.50" name="precio_compra" required 
                   value="<?php echo $p ? $p['precio_compra'] : ''; ?>"><br><br>

            <label>Precio Venta (Publico):</label><br>
            <input type="number" step="0.50" name="precio_venta" required 
                   value="<?php echo $p ? $p['precio_venta'] : ''; ?>"><br><br>

            <label>Stock Actual:</label><br>
            <input type="number" name="stock" required 
                   value="<?php echo $p ? $p['stock_actual'] : '0'; ?>"><br><br>

            <label>Stock Minimo (Alerta):</label><br>
            <input type="number" name="stock_minimo" required 
                   value="<?php echo $p ? $p['stock_minimo'] : '5'; ?>">
        </fieldset>

        <br>

        <fieldset>
            <legend>Imagen del Producto</legend>
            <?php if($p && $p['imagen']): ?>
                <p>Imagen Actual:</p>
                <img src="../../<?php echo $p['imagen']; ?>" width="100"><br>
            <?php endif; ?>
            
            <label>Seleccionar Nueva Imagen:</label><br>
            <input type="file" name="imagen" accept="image/*">
        </fieldset>

        <br>
        <button type="submit">GUARDAR PRODUCTO</button>
        <br><br>
        <a href="index.php">Cancelar y Volver</a>

    </form>

</body>
</html>