<?php
session_start();
include_once '../../models/Proveedor.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../../index.php"); exit(); }

$modelo = new Proveedor();
$prov = null;
$accion = "guardar";
$titulo = "Registrar Proveedor";

if(isset($_GET['id'])){
    $prov = $modelo->obtenerPorId($_GET['id']);
    $accion = "editar";
    $titulo = "Editar Proveedor";
}
?>
<!DOCTYPE html>
<html>
<head><title><?php echo $titulo; ?></title></head>
<body>
    <h1><?php echo $titulo; ?></h1>
    
    <form action="../../controllers/ProveedorController.php" method="POST">
        <input type="hidden" name="accion" value="<?php echo $accion; ?>">
        <?php if($prov): ?>
            <input type="hidden" name="id_proveedor" value="<?php echo $prov['id_proveedor']; ?>">
        <?php endif; ?>

        <label>Nombre Empresa:</label><br>
        <input type="text" name="empresa" required value="<?php echo $prov ? $prov['empresa'] : ''; ?>"><br><br>

        <label>Nombre del Vendedor (Contacto):</label><br>
        <input type="text" name="nombre_vendedor" required value="<?php echo $prov ? $prov['nombre_vendedor'] : ''; ?>"><br><br>

        <label>Telefono / Celular:</label><br>
        <input type="text" name="telefono" required value="<?php echo $prov ? $prov['telefono'] : ''; ?>"><br><br>

        <label>Dias de Visita (Ej: Lunes y Jueves):</label><br>
        <input type="text" name="dias_visita" required value="<?php echo $prov ? $prov['dias_visita'] : ''; ?>"><br><br>

        <button type="submit">GUARDAR</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>