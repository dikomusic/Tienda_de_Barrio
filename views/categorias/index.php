<?php
session_start();
include_once '../../models/Categoria.php';
// Validar Sesión Admin...
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../../index.php"); exit(); }

$modelo = new Categoria();
$lista = $modelo->listar();
?>
<!DOCTYPE html>
<html>
<head><title>Gestionar Categorias</title></head>
<body>
    <a href="../productos/index.php">Volver a Productos</a>
    <h1>Categorias de Productos</h1>

    <fieldset>
        <legend>Nueva Categoria</legend>
        <form action="../../controllers/CategoriaController.php" method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required placeholder="Ej: Mascotas">
            <button type="submit" name="crear">AGREGAR</button>
        </form>
    </fieldset>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'en_uso'): ?>
        <p style="color:red; font-weight:bold;">ERROR: No se puede eliminar la categoría porque tiene productos asociados.</p>
    <?php endif; ?>

    <br>
    <table border="1" width="50%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $cat): ?>
            <tr>
                <td><?php echo $cat['id_categoria']; ?></td>
                <td><?php echo $cat['nombre_categoria']; ?></td>
                <td>
                    <a href="../../controllers/CategoriaController.php?eliminar=<?php echo $cat['id_categoria']; ?>" 
                       onclick="return confirm('¿Eliminar esta categoria?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>