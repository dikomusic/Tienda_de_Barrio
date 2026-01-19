<?php
session_start();
include_once '../../models/Proveedor.php';
// Validar Sesión Admin...
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../../index.php"); exit(); }

$modelo = new Proveedor();
$lista = $modelo->listar();
?>
<!DOCTYPE html>
<html>
<head><title>Gestionar Proveedores</title></head>
<body>
    <a href="../productos/index.php">Volver a Productos</a>
    <h1>Lista de Proveedores</h1>
    
    <a href="formulario.php"> + NUEVO PROVEEDOR</a>
    <br><br>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Vendedor (Contacto)</th>
                <th>Telefono</th>
                <th>Dias de Visita</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $prov): ?>
            <tr>
                <td><?php echo $prov['empresa']; ?></td>
                <td><?php echo $prov['nombre_vendedor']; ?></td>
                <td><?php echo $prov['telefono']; ?></td>
                <td><?php echo $prov['dias_visita']; ?></td>
                <td>
                    <a href="formulario.php?id=<?php echo $prov['id_proveedor']; ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>