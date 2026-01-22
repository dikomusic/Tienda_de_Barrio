<?php
session_start();
include_once '../../models/Categoria.php';
include_once '../../models/Proveedor.php';

if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$catModel = new Categoria(); $categorias = $catModel->listar();
$provModel = new Proveedor(); $proveedores = $provModel->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <style>
        body { background-color: #f4f4f4; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        .form-card { background: white; padding: 40px; border-radius: 15px; width: 600px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-top: 15px; font-size: 14px; color: #333; }
        input, select { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; background: #fafafa; }
        .btn-save { background: black; color: white; border: none; padding: 15px; width: 100%; margin-top: 30px; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-card">
        <h1>Registrar Nuevo Producto</h1>
        <p style="color:#666; font-size:12px; margin-bottom:20px;">
            Nota: El Stock y Precio de Compra se actualizarán automáticamente cuando registres una compra de este producto.
        </p>

        <form action="../../controllers/ProductoController.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="guardar">

            <label>Código de Barras / Código Interno</label>
            <input type="text" name="codigo" required placeholder="Escanea o escribe el código">

            <label>Nombre del Producto</label>
            <input type="text" name="nombre" required placeholder="Ej: Coca Cola 2L">

            <div style="display:flex; gap:20px;">
                <div style="flex:1;">
                    <label>Categoría</label>
                    <select name="id_categoria" required>
                        <?php foreach($categorias as $c): ?>
                            <option value="<?php echo $c['id_categoria']; ?>"><?php echo $c['nombre_categoria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label>Proveedor Principal</label>
                    <select name="id_proveedor" required>
                        <?php foreach($proveedores as $p): ?>
                            <option value="<?php echo $p['id_proveedor']; ?>"><?php echo $p['empresa']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <label>Precio de Venta al Público (Bs)</label>
            <input type="number" name="precio_venta" step="0.50" required placeholder="0.00">

            <label>Imagen del Producto</label>
            <input type="file" name="imagen">

            <button type="submit" class="btn-save">GUARDAR PRODUCTO</button>
            <a href="index.php" class="btn-back">Cancelar y Volver</a>
        </form>
    </div>

</body>
</html>