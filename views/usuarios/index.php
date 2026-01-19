<?php
session_start();
include_once '../../models/Usuario.php';

// Seguridad: Solo Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$modelo = new Usuario();
$usuarios = $modelo->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <a href="../../index.php">⬅ Volver</a>
            <h2>👥 Personal y Accesos</h2>
        </div>
        <a href="formulario.php">➕ Nuevo Usuario</a>
    </div>
    
    <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'creado'): ?>
        <div style="color:green; margin: 10px 0;">
            ✅ <strong>¡Usuario Creado!</strong><br>
            El sistema generó la cuenta: <strong><?php echo isset($_GET['usr']) ? $_GET['usr'] : 'N/A'; ?></strong><br>
            Contraseña por defecto: <em>"tienda de barrio"</em>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <p style="color:red;">Error: No puedes bloquear tu propia cuenta.</p>
    <?php endif; ?>

    <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'restablecido'): ?>
        <div style="color:blue; margin: 10px 0;">
            <strong>Acceso Restablecido:</strong> La contraseña volvió a ser "Tienda de Barrio".
        </div>
    <?php endif; ?>

    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr style="background:#eee;">
                <th>CI</th>
                <th>Empleado (Nombre Completo)</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $user): ?>
            <tr>
                <td><?php echo $user['ci']; ?></td>
                <td><?php echo $user['nombres'] . ' ' . $user['apellido_paterno']; ?></td>
                <td><strong><?php echo $user['cuenta']; ?></strong></td>
                <td><?php echo $user['nombre_rol']; ?></td>
                <td>
                    <?php if($user['estado'] == 1): ?>
                        ACTIVO
                    <?php else: ?>
                        INACTIVO
                    <?php endif; ?>
                </td>
                
                <td align="center">
                    
                    <a href="formulario.php?id=<?php echo $user['id_usuario']; ?>">Modificar</a> 
                    | 
                    
                    <a href="../../controllers/UsuarioController.php?accion=restablecer&id=<?php echo $user['id_usuario']; ?>" 
                       onclick="return confirm('¿Está seguro de resetear la clave a: Tienda de Barrio?')">
                       Restablecer
                    </a> 
                    | 

                    <?php if($user['estado'] == 1): ?>
                        <a href="../../controllers/UsuarioController.php?accion=estado&id=<?php echo $user['id_usuario']; ?>&estado=0" 
                           onclick="return confirm('¿Desea desactivar esta cuenta?')" style="color:red;">
                           Desactivar
                        </a>
                    <?php else: ?>
                        <a href="../../controllers/UsuarioController.php?accion=estado&id=<?php echo $user['id_usuario']; ?>&estado=1" 
                           style="color:green;">
                           Activar
                        </a>
                    <?php endif; ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>