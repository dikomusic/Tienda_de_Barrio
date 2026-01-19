<?php
session_start();
include_once '../../models/Usuario.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../../index.php"); exit(); }

$modelo = new Usuario();
$roles = $modelo->listarRoles();
$u = null;
$titulo = "Registrar Nuevo Empleado";
$accion = "guardar";

if (isset($_GET['id'])) {
    $u = $modelo->obtenerPorId($_GET['id']);
    $titulo = "Modificar Datos de Empleado";
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

<div class="card">
    <h3><?php echo $titulo; ?></h3>

    <?php if(!$u): ?>
        <div class="auto-msg">
            ⚙️ <strong>Generación Automática de Credenciales:</strong><br>
            El usuario será: 1ª letra Nombre + Apellido Paterno + 1ª letra Materno.<br>
            Clave por defecto: "Tienda de Barrio".
        </div>
    <?php endif; ?>

    <form action="../../controllers/UsuarioController.php" method="POST">
        <input type="hidden" name="accion" value="<?php echo $accion; ?>">
        <?php if($u): ?> <input type="hidden" name="id_usuario" value="<?php echo $u['id_usuario']; ?>"> <?php endif; ?>

        <div class="row">
            <div class="col">
                <label>Cédula de Identidad (CI):</label>
                <input type="text" name="ci" required 
       value="<?php echo $u ? $u['ci'] : ''; ?>" 
       <?php echo $u ? 'readonly' : ''; ?>>
            </div>
            <div class="col">
                <label>Fecha de Nacimiento:</label>
                <input type="date" name="nacimiento" required value="<?php echo $u ? $u['fecha_nacimiento'] : ''; ?>">
            </div>
        </div>

        <label>Nombres:</label>
        <input type="text" name="nombres" required placeholder="Ej: Juanito" value="<?php echo $u ? $u['nombres'] : ''; ?>">

        <div class="row">
            <div class="col">
                <label>Apellido Paterno:</label>
                <input type="text" name="paterno" required placeholder="Ej: Mamane" value="<?php echo $u ? $u['apellido_paterno'] : ''; ?>">
            </div>
            <div class="col">
                <label>Apellido Materno:</label>
                <input type="text" name="materno" required placeholder="Ej: Quespe" value="<?php echo $u ? $u['apellido_materno'] : ''; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Celular:</label>
                <input type="text" name="celular" value="<?php echo $u ? $u['celular'] : ''; ?>">
            </div>
            <div class="col">
                <label>Rol:</label>
                <select name="id_rol" required>
                    <?php foreach($roles as $r): ?>
                        <option value="<?php echo $r['id_rol']; ?>" <?php echo ($u && $u['id_rol'] == $r['id_rol']) ? 'selected' : ''; ?>>
                            <?php echo $r['nombre_rol']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $u ? $u['direccion'] : ''; ?>">
        <?php if($u): ?>
            <label>Usuario (Cuenta):</label>
            <input type="text" name="cuenta" 
                   value="<?php echo $u['cuenta']; ?>" 
                   readonly>
        <?php endif; ?>

        <button type="submit">💾 Guardar Datos</button>
        <a href="index.php">Cancelar</a>
    </form>
</div>

</body>
</html>