<?php
session_start();
// Seguridad
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../index.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
</head>
<body>

<div class="card">
    <h2>🔒 Mi Seguridad</h2>
    <p>Cambiar contraseña de acceso</p>

    <?php if(isset($_GET['error'])): ?>
        <div class="msg error">
            <?php 
                if($_GET['error'] == 'no_coinciden') echo "⚠️ Las contraseñas nuevas no coinciden.";
                if($_GET['error'] == 'clave_incorrecta') echo "❌ La contraseña actual es incorrecta.";
            ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'exito'): ?>
        <div class="msg success">✅ ¡Contraseña actualizada correctamente!</div>
    <?php endif; ?>

    <form action="../../controllers/PerfilController.php" method="POST">
        <input type="hidden" name="accion" value="cambiar_clave">

        <label>Contraseña Actual:</label>
        <input type="password" name="clave_actual" required placeholder="Ingresa tu clave actual">

        <label>Nueva Contraseña:</label>
        <input type="password" name="clave_nueva" required placeholder="Nueva clave secreta">

        <label>Confirmar Nueva Contraseña:</label>
        <input type="password" name="clave_confirmar" required placeholder="Repite la nueva clave">

        <button type="submit">💾 Guardar Nueva Clave</button>
        <a href="../../index.php">Cancelar y Volver</a>
    </form>
</div>

</body>
</html>